<?php
App::uses('AppController', 'Controller');
App::uses('ShellDispatcher', 'Console');
App::Import('ConnectionManager');
/**
 * Configs Controller
 *
 * @property Config $Config
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ConfigsController extends AppController {



	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Session');

	private $pheal = null;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('api_check_for_admin');
	}

	public function api_check_for_admin() {
		$command = '-app '.APP.' EveApi';
		$args = explode(' ', $command);

		$this->log('Manual CRON: '.$command, 'CRON eve-lotteries');

		$dispatcher = new ShellDispatcher($args, false);
		$dispatcher->dispatch();
		return $this->redirect('/');
	}


	
}
