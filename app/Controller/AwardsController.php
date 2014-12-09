<?php
App::uses('AppController', 'Controller');
/**
 * Awards Controller
 *
 * @property Award $Award
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AwardsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('');

		if (!$this->Auth->loggedIn()) {
			$this->Session->setFlash('Please Log in !', 'FlashMessage', array('type' => 'warning'));
			return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
		}
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$userGlobal = $this->Auth->user();

		$params = array(
			'conditions' => array('Award.status' => 'active'),
			'order' => array('Award.group asc', 'Award.order desc')
			);
		$this->set('awards', $this->Award->find('all', $params));

		
		$this->loadModel('UserAward');
		$params = array(
			'conditions' => array('UserAward.user_id' => $userGlobal['id']),
			);
		$userAwards = $this->UserAward->find('all', $params);
		$userAwards = Set::combine($userAwards, '{n}.UserAward.award_id', '{n}');
		$this->set('userAwards', $userAwards);
	}

	/**
	 * admin index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->set('awards', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Award->exists($id)) {
			throw new NotFoundException(__('Invalid Award'));
		}
		$this->Award->recursive = 0;
		$options = array('conditions' => array('Award.' . $this->Award->primaryKey => $id));
		$this->set('award', $this->Award->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {

		$userId = $this->Auth->user('id');


		if ($this->request->is('post')) {

			$this->Award->create();
			$dataProxy = $this->request->data;

			if ($this->Award->save($dataProxy, true, array('name', 'description', 'group', 'order', 'request', 'award_credits', 'status'))) {
				$this->Session->setFlash(
					'The Award has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The Award could not be saved. Please, try again.',
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
		if (!$this->Award->exists($id)) {
			throw new NotFoundException(__('Invalid Award'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Award->save($this->request->data, true, array('id', 'name', 'description', 'group', 'order', 'request', 'award_credits', 'status'))) {
				$this->Session->setFlash(
					'The Award has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The Award could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		} else {
			$options = array('conditions' => array('Award.' . $this->Award->primaryKey => $id));
			$this->request->data = $this->Award->find('first', $options);
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Award->id = $id;
		if (!$this->Award->exists()) {
			throw new NotFoundException(__('Invalid Award'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Award->delete()) {
			$this->Session->setFlash(
					'The Award has been deleted.',
					'FlashMessage',
					array('type' => 'success')
					);
		} else {
			$this->Session->setFlash(
					'The Award could not be deleted. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}
}
