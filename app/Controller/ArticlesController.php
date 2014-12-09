<?php
App::uses('AppController', 'Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ArticlesController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Article->recursive = 0;
		$params = array(
			'contain' => array('User'),
			'order' => array('Article.created' => 'desc'), 
			'limit' => 5, 
			);
		$this->Paginator->settings = $params;
		$this->set('articles', $this->Paginator->paginate());
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Article->recursive = 0;
		$this->set('articles', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->Article->recursive = 0;
		$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
		$this->set('article', $this->Article->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {

		$userId = $this->Auth->user('id');


		if ($this->request->is('post')) {

			$this->Article->create();
			$dataProxy = $this->request->data;
			$dataProxy['Article']['creator_user_id'] = $userId;

			if ($this->Article->save($dataProxy)) {
				$this->Session->setFlash(
					'The article has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The article could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(
					'The article has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The article could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		} else {
			$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
			$this->request->data = $this->Article->find('first', $options);
		}
		$users = $this->Article->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Article->delete()) {
			$this->Session->setFlash(
					'The article has been deleted.',
					'FlashMessage',
					array('type' => 'success')
					);
		} else {
			$this->Session->setFlash(
					'The article could not be deleted. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}
}
