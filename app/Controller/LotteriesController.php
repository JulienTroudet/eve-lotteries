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
	public $components = array('Paginator', 'Session', 'RequestHandler');



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

		$this->loadModel('EveItem');
		$this->loadModel('EveCategory');
		
		$this->Paginator->settings = $this->paginate;
		$this->Lottery->contain(array(
			'EveItem', 
			'Ticket' => array(
				'User' => array('id', 'eve_id', 'eve_name')
				)
			)
		);
		$lotteries = $this->Paginator->paginate('Lottery');
		$this->set('lotteries', $lotteries);

		$params = array(
			'conditions' => array('EveCategory.status' => '1'),
			'recursive' => -1,
			'order' => array('EveCategory.name ASC'),
			'fields' => array('EveCategory.id', 'EveCategory.name'),

			);
		$eveCategories = $this->EveCategory->find('list', $params);
		$this->set('eveCategories', $eveCategories);


		$params = array(
			'contain' => 'EveCategory',
			'conditions' => array('EveItem.status' => '1'),
			'order' => array('EveItem.name ASC'),
			);

		$eveItems = $this->EveItem->find('all', $params);

		foreach ($eveItems as $key => $value) {
			
			$eveItems[$key]['EveItem']['ticket_price'] = $this->EveItem->getTicketPrice($value);
			
		}

		$this->set('eveItems', $eveItems);
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function list_lotteries() {

		
		$this->Paginator->settings = $this->paginate;
		$this->Lottery->contain(array(
			'EveItem', 
			'Ticket' => array(
				'User' => array('id', 'eve_id', 'eve_name')
				)
			)
		);
		$lotteries = $this->Paginator->paginate('Lottery');
		$this->set('lotteries', $lotteries);
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
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
	public function admin_view($id = null) {
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

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {

			$this->loadModel('EveItem');
			$this->loadModel('Ticket');
			$this->loadModel('User');
			
			$this->disableCache();

			$itemId = $this->request->query('item_id');

			$userId = $this->Auth->user('id');


			if (!$this->EveItem->exists($itemId)) {
				$data = array('error' => 'Invalid Eve Item.' );
			}
			else if (!$this->User->exists($userId)) {
				$data = array('error' => 'You must log in to buy a ticket !');
			}
			else{

				$this->EveItem->contain(array('EveCategory'));
				$choosenItem = $this->EveItem->findById($itemId);

				$ticketPrice = $this->EveItem->getTicketPrice($choosenItem);

				$buyer = $this->User->findById($userId);

				//TODO TESTS DIVERS

				if($buyer['User']['wallet'] < $ticketPrice){
					$data = array('error' => 'Not enough ISK.');
				}

				else{
					$buyer['User']['wallet'] -= $ticketPrice;
					$buyer['User']['password'] ="";

					$this->Lottery->create();
					$newLottery = array('Lottery'=>array(
						'eve_item_id' =>  $itemId,
						'creator_user_id' => $userId,
						'nb_tickets' => $choosenItem['EveItem']['nb_tickets_default'],
						'lottery_status_id' => 1,
						));

					if ($this->User->save($buyer) && $this->Lottery->save($newLottery)) {


						for ($i=0; $i < $choosenItem['EveItem']['nb_tickets_default']; $i++) {
							$this->Ticket->create();
							$newTicket = array('Ticket'=>array(
								'lottery_id' => $this->Lottery->id,
								'position' => $i,
								'value' => $ticketPrice,
								));
							if ($i==0) {
								$newTicket['Ticket']['buyer_user_id'] = $userId;
							}
							$this->Ticket->save($newTicket);
						}


						$data = array (
							'success' => true,
							'message' => 'Ticket bought.',
							'buyerEveId' => $buyer['User']['eve_id'],
							'buyerName' => $buyer['User']['eve_name'],
							'buyerWallet' => number_format($buyer['User']['wallet'], 2),
							'itemName' => $choosenItem['EveItem']['name']
							);

						
					}
				}
			}			

			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');

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
		if (!$this->Lottery->exists($id)) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Lottery->save($this->request->data)) {
				$this->Session->setFlash(__('The lottery has been saved.'));
				return $this->redirect(array('action' => 'index', 'admin' => true));
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
	public function admin_delete($id = null) {
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
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}


	
}
