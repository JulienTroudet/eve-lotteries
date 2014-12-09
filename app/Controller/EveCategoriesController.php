<?php
App::uses('AppController', 'Controller');
/**
 * EveCategories Controller
 *
 * @property EveCategory $EveCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EveCategoriesController extends AppController {

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
	public function admin_index() {
		$this->EveCategory->recursive = 0;
		$this->set('eveCategories', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->EveCategory->exists($id)) {
			throw new NotFoundException(__('Invalid eve category'));
		}
		$options = array('conditions' => array('EveCategory.' . $this->EveCategory->primaryKey => $id));
		$this->set('eveCategory', $this->EveCategory->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->EveCategory->create();
			if ($this->EveCategory->save($this->request->data)) {
				$this->Session->setFlash(
					'The eve category has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The eve category could not be saved. Please, try again.',
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
		if (!$this->EveCategory->exists($id)) {
			throw new NotFoundException(__('Invalid eve category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EveCategory->save($this->request->data)) {
				$this->Session->setFlash(
					'The eve category has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The eve category could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		} else {
			$options = array('conditions' => array('EveCategory.' . $this->EveCategory->primaryKey => $id));
			$this->request->data = $this->EveCategory->find('first', $options);
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
		$this->EveCategory->id = $id;
		if (!$this->EveCategory->exists()) {
			throw new NotFoundException(__('Invalid eve category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EveCategory->delete()) {
			$this->Session->setFlash(
				'The eve category has been deleted.',
				'FlashMessage',
				array('type' => 'success')
				);
		} else {
			$this->Session->setFlash(
				'The eve category could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}
}
