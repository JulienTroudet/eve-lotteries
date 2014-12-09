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
				)
			),
		'Session',
		'Cookie'
		);
	public $helpers = array('Html', 'Form', 'Session');

	public function beforeFilter() {

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
		$this->loadModel('Lottery');
		$this->loadModel('Statistic');

		$userGlobal = $this->Auth->user();
		$userGlobal = $this->_readConnectionCookie($userGlobal);

		$params = array(
			'conditions' => array('OR'=>array(array('Statistic.type' => 'win_super_lottery'), array('Statistic.type' => 'win_lottery'))),
			'fields' => array('SUM(Statistic.isk_value) as totalAmount'),
			);
		$total = $this->Statistic->find('first', $params);
		if(isset($total[0])){
			$this->set('totalWon', $total[0]['totalAmount']);
		}
		else{
			$this->set('totalWon', 0);
		}

		
		
		if (!isset($userGlobal)) {
		
			$this->_setAntiForgeryToken();

			$eveSSO_URL = $this->Config->findByName('eve_sso_url');
			$this->set('eveSSO_URL', $eveSSO_URL['Config']['value']);
			$appEveId = $this->Config->findByName('app_eve_id');
			$this->set('appEveId', $appEveId['Config']['value']);
			$appReturnUrl = $this->Config->findByName('app_return_url');
			$this->set('appReturnUrl', $appReturnUrl['Config']['value']);
		}
		
		$params = array(
			'conditions' => array('Lottery.lottery_status_id' => '1'),
			);
		$nbFreeLotteries = 10 - $this->Lottery->find('count', $params);
		$this->set('nbFreeLotteries', $nbFreeLotteries);

		$this->set('userGlobal', $userGlobal);


		$apiCheckTime = $this->Config->findByName("apiCheck");
		$this->set('apiCheckTime', CakeTime::niceShort($apiCheckTime['Config']['value']));
		

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

}