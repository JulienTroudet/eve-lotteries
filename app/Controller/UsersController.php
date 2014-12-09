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
	public $components = array('Paginator', 'Session');

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
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			print_r($this->request->data);
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			return $this->redirect('/');
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash(__('Your username or password was incorrect.'));
		}
	}

	public function logout() {
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());
	}

	function register(){
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
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
				$this->Session->setFlash(__('Error in Password confirmation.'));
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
