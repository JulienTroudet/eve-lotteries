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

	public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Lottery.id' => 'asc'
        )
    );

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
		$this->Paginator->settings = $this->paginate;
		$this->Lottery->recursive = 2;
		$this->set('lotteries', $this->Paginator->paginate());
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function adminIndex() {
		$this->Lottery->recursive = 1;
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
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function adminView($id = null) {
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
	public function add($eve_item_id = null) {
		if (!$this->Lottery->EveItem->exists($eve_item_id)) {
			throw new NotFoundException(__('Invalid Eve Item'));
		}

		$id = $this->Auth->user('id');
		if ($this->request->is('post')) {
			$this->Lottery->create();

			$dataProxy = $this->request->data;

			$dataProxy['Lottery']['creator_user_id'] = $id;
			$dataProxy['Lottery']['eve_item_id'] = $eve_item_id;

			if ($this->Lottery->save($dataProxy)) {

				$this->Session->setFlash(__('The lottery has been created.'));

				$lottery_id = $this->Lottery->getLastInsertId();

				return $this->redirect(array('controller' => 'Tickets', 'action' => 'add', $lottery_id, $dataProxy['Lottery']['lottery_value']));

			} else {
				$this->Session->setFlash(__('The lottery could not be saved. Please, try again.'));
			}
		}

		$oneEveItem = $this->Lottery->EveItem->find('first', array(
			'conditions' => array('EveItem.id' => $eve_item_id)
			));
		$lotteryStatuses = $this->Lottery->LotteryStatus->find('list');
		$this->set(compact('lotteryStatuses', 'users'));
		$this->set('eveItem', $oneEveItem);
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
		if ($this->Lottery->delete($id, true)) {
			$this->Session->setFlash(__('The lottery has been deleted.'));
		} else {
			$this->Session->setFlash(__('The lottery could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
