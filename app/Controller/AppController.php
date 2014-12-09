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
		'Auth',
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
		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login'
			);
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login'
			);
		$this->Auth->loginRedirect = array(
			'controller' => 'users',
			'action' => 'index'
			);

		$this->Auth->allow('display');
	}

	public function beforeRender() {

		$userGlobal = $this->Auth->user();
		$userGlobal = $this->_readConnectionCookie($userGlobal);

		$this->loadModel('Withdrawal');
		$params = array(
			'conditions' => array('Withdrawal.status' => 'new', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => 'award'),
			);
		
		if ($userGlobal != null) {
			$userGlobal['new_awards'] = $this->Withdrawal->find('count', $params);
		}
		

		$this->set('userGlobal', $userGlobal);

		$this->loadModel('Config');
		$apiCheckTime = $this->Config->findByName("apiCheck");
		$apiCheckTimeValue = $apiCheckTime['Config']['value'];
		$this->set('apiCheckTime', $apiCheckTimeValue);
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