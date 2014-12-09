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
		'Auth' => array(
			'authorize' => array(
				'Actions' => array('actionPath' => 'controllers')
				)
			),
		'Session'
		);
	public $helpers = array('Html', 'Form', 'Session');

	public function beforeFilter() {
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

		$this->loadModel('Ticket');
		$params = array(
			'conditions' => array('Ticket.status' => 'unclaimed', 'Ticket.buyer_user_id' => $userGlobal['id'], 'Ticket.is_winner' => true),
			);
		
		if ($userGlobal != null) {
			$userGlobal['new_awards'] = $this->Ticket->find('count', $params);
		}

		$this->set('userGlobal', $userGlobal);

		$this->loadModel('Config');
		$apiCheckTime = $this->Config->findByName("apiCheck");
		$apiCheckTimeValue = $apiCheckTime['Config']['value'];
		$this->set('apiCheckTime', $apiCheckTimeValue);
	}

}