<?php
App::uses('AppController', 'Controller');
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
		
	}


	
}
