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

		//vas chercher les lotteries actuelles
		$params = array(
			'contain' => array(
				'EveItem', 
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '1'),
			'order' => array('Lottery.id ASC'),
			'limit' => 10
			);
		$lotteries = $this->Lottery->find('all', $params);
		$this->set('lotteries', $lotteries);


		//vas chercher les anciennes lotteries
		$paginateVar = array(
			'contain' => array(
				'EveItem', 
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '2'),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => 6
			);
		$this->Paginator->settings = $paginateVar;
		$oldLotteries = $this->Paginator->paginate('Lottery');
		$this->set('old_lotteries', $oldLotteries);


		//vas chercher la liste des catégories d'item
		$params = array(
			'conditions' => array('EveCategory.status' => '1'),
			'recursive' => -1,
			'order' => array('EveCategory.name ASC'),
			'fields' => array('EveCategory.id', 'EveCategory.name'),

			);
		$eveCategories = $this->EveCategory->find('list', $params);
		$this->set('eveCategories', $eveCategories);


		//vas chercher la liste des items
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

		$this->layout = false;
		$params = array(
			'contain' => array(
				'EveItem', 
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '1'),
			'order' => array('Lottery.id ASC'),
			);
		
		$lotteries = $this->Lottery->find('all', $params);
		$this->set('lotteries', $lotteries);


		$paginateVar = array(
			'contain' => array(
				'EveItem', 
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '2'),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => 6
			);
		$this->Paginator->settings = $paginateVar;
		$oldLotteries = $this->Paginator->paginate('Lottery');
		$this->set('old_lotteries', $oldLotteries);
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
	public function admin_view($id = null) {
		$this->Lottery->recursive = 1;
		if (!$this->Lottery->exists($id)) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		$options = array('conditions' => array('Lottery.' . $this->Lottery->primaryKey => $id));
		$this->set('lottery', $this->Lottery->find('first', $options));
	}

	
	public function old_list() {
		//vas chercher les anciennes lotteries
		$paginateVar = array(
			'contain' => array(
				'EveItem', 
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '2'),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => '10'
			);
		$this->Paginator->settings = $paginateVar;
		$oldLotteries = $this->Paginator->paginate('Lottery');
		$this->set('old_lotteries', $oldLotteries);
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
			$this->Session->setFlash(
				'The lottery has been deleted.',
				'FlashMessage',
				array('type' => 'success')
				);
		} else {
			$this->Session->setFlash(
				'The lottery could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}


	
}
