<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeTime', 'Utility');


App::import('Vendor', 'Pheal', array('file' => 'Pheal' . DS . 'Pheal.php'));
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'Acl',
		'Auth' => array(
			'authorize' => array(
				'Actions' => array('actionPath' => 'Controllers')
				),
			),
		'Session',
		'Cookie'
		);
	public $helpers = array('Html', 'Form', 'Session');

	public function beforeFilter() {


        $this->_check_if_banned();



		$this->Cookie->name = 'eve-lotteries';
		$this->Cookie->time = '1 week';
		$this->Cookie->key = 'qSI232qsmdsflgjmsdlfkgsmdlfkjsdmlfgjlmdfhkh';
		$this->Cookie->type('aes');

        //Configure AuthComponent
		$this->Auth->authorize = 'Actions';	
		$this->Auth->loginAction = array(
			'controller' => 'users', 
			'action' => 'login', 
			'admin' => false, 
			'plugin' => false
			);
		$this->Auth->loginRedirect = array(
			'controller' => 'users', 
			'action' => 'login', 
			'admin' => false, 
			'plugin' => false
			);
		$this->Auth->unauthorizedRedirect = array(
			'controller' => 'users', 
			'action' => 'forbidden', 
			'admin' => false, 
			'plugin' => false
			);
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login',
			'admin' => false,
			'plugin' => false
			);
		

		$this->Auth->allow('display');


	}

	public function beforeRender() {



		$this->loadModel('Config');
		$this->loadModel('Statistic');
		$this->loadModel('User');

		App::uses('CakeSession', 'Model/Datasource');
		CakeSession::write('Auth',$this->User->findById(AuthComponent::user('id')));

		$userGlobal = $this->Auth->user();
		$userGlobal = $this->_readConnectionCookie($userGlobal);

        //if user is banned
        if($userGlobal['group_id']==7){
            $this->Cookie->destroy();
            $this->Auth->logout();
            throw new ForbiddenException('Character is Banned');
        }


        $nbFreeLotteries = $this->_getNbFreeLotteries();
		$this->set('nbFreeLotteries', $nbFreeLotteries);

        //if user is admin or manager
        if($userGlobal['group_id']==3 || $userGlobal['group_id']==5){

            $nbClaimedWithdrawals = $this->_getNbClaimedWithdrawals();
            $this->set('nbClaimedWithdrawals', $nbClaimedWithdrawals);

            $nbClaimedWages = $this->_getNbClaimedWages();
            $this->set('nbClaimedWages', $nbClaimedWages);

            $nbClaimedSuper = $this->_getNbClaimedSuper();
            $this->set('nbClaimedSuper', $nbClaimedSuper);

            $nbClaimedFlash = $this->_getNbClaimedFlash();
            $this->set('nbClaimedFlash', $nbClaimedFlash);
        }



		$this->set('userGlobal', $userGlobal);


		$apiCheckTime = $this->Config->findByName("apiCheck");
		$this->set('apiCheckTime', $apiCheckTime['Config']['value']);
		

	}

	protected function _setAntiForgeryToken() {
		$state = md5(rand());
		$this->Session->write('User.antiForgeryToken', $state);
		$this->set('antiForgeryToken', $state);
		return $state;	
	}

	protected function _readConnectionCookie($userGlobal) {
		if ($userGlobal != null) {
			return $userGlobal;
		}

		$cookValue = $this->Cookie->read('User');
		if( isset($cookValue['user']) && isset($cookValue['token']) ) {
			$this->loadModel('User');
			$cookUser = $this->User->findByIdAndCookieValue($cookValue['user'], $cookValue['token']);

			if($cookUser != null){
				$this->Auth->login($cookUser['User']);
				$userGlobal = $this->Auth->user();
				return $userGlobal;
			}
		}
		return null;	
	}

    protected function _check_if_banned(){
        //see if the IP is banned or not
        $this->loadModel('BannedIp');
        $listBann = $this->BannedIp->find('list',
            array(
                'fields'=>array('BannedIp.ip'),
                'cache' => 'bannedipcache',
                'cacheConfig' => 'short',
            ));

        if (in_array ($this->request->clientIp(), $listBann)) {
            throw new ForbiddenException('IP is Banned');
        }
    }

    protected function _getNbFreeLotteries(){
        $this->loadModel('Lottery');

        $params = array(
            'conditions' => array('Lottery.lottery_status_id' => '1'),
        );
        $nbFreeLotteries = 10 - $this->Lottery->find('count', $params);

        return $nbFreeLotteries;

    }

    protected function _getNbClaimedWithdrawals(){
        $this->loadModel('Withdrawal');

        $params = array(
            'conditions' => array('Withdrawal.status' => 'claimed'),
        );
        $nb = $this->Withdrawal->find('count', $params);

        return $nb;

    }

    protected function _getNbClaimedWages(){
        $this->loadModel('Wage');

        $params = array(
            'conditions' => array('Wage.status' => 'claimed'),
        );
        $nb = $this->Wage->find('count', $params);

        return $nb;

    }

    protected function _getNbClaimedSuper(){
        $this->loadModel('SuperLottery');

        $params = array(
            'conditions' => array('SuperLottery.status' => 'claimed'),
        );
        $nb = $this->SuperLottery->find('count', $params);

        return $nb;

    }

    protected function _getNbClaimedFlash(){
        $this->loadModel('FlashLottery');

        $params = array(
            'conditions' => array('FlashLottery.status' => 'claimed'),
        );
        $nb = $this->FlashLottery->find('count', $params);

        return $nb;

    }
}