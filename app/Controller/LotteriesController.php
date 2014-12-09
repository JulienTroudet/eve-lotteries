<?php
App::uses('AppController', 'Controller');
/**
 * Lotteries Controller
 *
 * @property Lottery $Lottery
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LotteriesController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Lottery->recursive = 0;
		$this->set('lotteries', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->Lottery->exists($id)) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		$options = array('conditions' => array('Lottery.' . $this->Lottery->primaryKey => $id));
		$this->set('lottery', $this->Lottery->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lottery->create();
			if ($this->Lottery->save($this->request->data)) {
				$this->Session->setFlash(__('The lottery has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lottery could not be saved. Please, try again.'));
			}
		}
		$eveItems = $this->Lottery->EveItem->find('list');
		$lotteryStatuses = $this->Lottery->LotteryStatus->find('list');
		$users = $this->Lottery->User->find('list');
		$this->set(compact('eveItems', 'lotteryStatuses', 'users'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->Lottery->exists($id)) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Lottery->save($this->request->data)) {
				$this->Session->setFlash(__('The lottery has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lottery could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lottery.' . $this->Lottery->primaryKey => $id));
			$this->request->data = $this->Lottery->find('first', $options);
		}
		$eveItems = $this->Lottery->EveItem->find('list');
		$lotteryStatuses = $this->Lottery->LotteryStatus->find('list');
		$users = $this->Lottery->User->find('list');
		$this->set(compact('eveItems', 'lotteryStatuses', 'users'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Lottery->id = $id;
		if (!$this->Lottery->exists()) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Lottery->delete()) {
			$this->Session->setFlash(__('The lottery has been deleted.'));
		} else {
			$this->Session->setFlash(__('The lottery could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
