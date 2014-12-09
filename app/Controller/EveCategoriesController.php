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

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->EveCategory->recursive = 0;
		$this->set('eveCategories', $this->Paginator->paginate());
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function chooseItem() {
		$this->EveCategory->recursive = 1 ;
		

$this->set('eveCategories', $this->Paginator->paginate());
}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
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
	public function add() {
		if ($this->request->is('post')) {
			$this->EveCategory->create();
			if ($this->EveCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The eve category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eve category could not be saved. Please, try again.'));
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
	public function edit($id = null) {
		if (!$this->EveCategory->exists($id)) {
			throw new NotFoundException(__('Invalid eve category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EveCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The eve category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eve category could not be saved. Please, try again.'));
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
	public function delete($id = null) {
		$this->EveCategory->id = $id;
		if (!$this->EveCategory->exists()) {
			throw new NotFoundException(__('Invalid eve category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EveCategory->delete()) {
			$this->Session->setFlash(__('The eve category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The eve category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
