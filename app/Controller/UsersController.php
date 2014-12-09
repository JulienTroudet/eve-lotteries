<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'Auth');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'logout', 'register');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(
					'The user has been saved.',
					'FlashMessage',
					array('type' => 'info')
					);
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					'The user could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'danger')
					);
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(
				'The user has been deleted.',
				'FlashMessage',
				array('type' => 'info')
				);
		} else {
			$this->Session->setFlash(
				'The user could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'danger')
				);
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login() {
		if ($this->Session->read('Auth.User')) {

			$this->Session->setFlash(
				'Already logged !',
				'FlashMessage',
				array('type' => 'info')
				);
			$this->redirect('/');
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->setFlash(
					'Login succcessfull !',
					'FlashMessage',
					array('type' => 'info')
					);
				return $this->redirect(array('controller' =>'lotteries', 'action' => 'index'));
			}
			$this->Session->setFlash(
				'Your username or password was incorrect.',
				'FlashMessage',
				array('type' => 'danger')
				);
		}
	}

	public function logout() {

		$this->Session->setFlash(
			'Log out done. Good bye !',
			'FlashMessage',
			array('type' => 'info')
			);

		$this->redirect($this->Auth->logout());
	}

	function register(){
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash(
					'Registration confirmed. You are logged in!',
					'FlashMessage',
					array('type' => 'success')
					);
			return $this->redirect('/');
		}
		if (!empty($this->data)){
			if ($this->data['User']['password'] == $this->data['User']['password_confirm']){

				$dataProxy = $this->data;

				$dataProxy['User']['group_id'] = 4;
				$this->User->create();
				if($this->User->save($dataProxy)){

					$this->Auth->login();
					$this->redirect(array('action' => 'index'));
				}
			}
			else{
				$this->Session->setFlash(
					'Error in Password confirmation.',
					'FlashMessage',
					array('type' => 'danger')
					);
			}
		}
	}

	// public function initDB() {
	// 	$group = $this->User->Group;

 //    // Allow admins to everything
	// 	$group->id = 3;
	// 	$this->Acl->allow($group, 'controllers');

	
 //    // allow users to only add and edit on posts and widgets
	// 	$group->id = 4;
	// 	$this->Acl->deny($group, 'controllers');

 //    // allow basic users to log out
	// 	$this->Acl->allow($group, 'controllers/users/logout');

 //    // we add an exit to avoid an ugly "missing views" error message
	// 	echo "all done";
	// 	exit;
	// }
}
