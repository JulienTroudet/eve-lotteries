<?php
App::uses('AppController', 'Controller');
/**
 * SuperLotteries Controller
 *
 * @property SuperLottery $SuperLottery
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SuperLotteriesController extends AppController {

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
		$params = array(
			'contain' => array('EveItem', 'SuperLotteryTicket', 'Winner'),
			'order' => array('SuperLottery.created' => 'desc'), 
			);
		$this->Paginator->settings = $params;
		$superLotteries = $this->Paginator->paginate();
		foreach ($superLotteries as $key => $superLottery) {
			$superLotteries[$key]['SuperLotteryTicket'] = Hash::combine($superLottery['SuperLotteryTicket'], '{n}.buyer_user_id', '{n}');
			$superLotteries[$key]['percentage'] = ($superLottery['SuperLottery']['nb_ticket_bought']*100)/$superLottery['SuperLottery']['nb_tickets'];
		}

		$this->set('superLotteries', $superLotteries);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->SuperLottery->recursive = 0;
		$this->set('superLotteries', $this->Paginator->paginate());
	}

	/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_complete($id = null) {
		$this->SuperLottery->recursive = 0;
		if (!$this->SuperLottery->exists($id)) {
			throw new NotFoundException(__('Invalid super lottery'));
		}

		$superlottery = $this->SuperLottery->findById($id);

		$superlottery['SuperLottery']['lottery_status_id'] = 2;

		if ($this->SuperLottery->save($superlottery, true, array('id', 'lottery_status_id'))) {
			$this->Session->setFlash(
				'The super lottery has been completed.',
				'FlashMessage',
				array('type' => 'info')
				);
			return $this->redirect(array('action' => 'index', 'admin' => true));
		}
		else{
			$this->Session->setFlash(
				'The super lottery couldn\'t been completed ! Please try again.',
				'FlashMessage',
				array('type' => 'error')
				);
			return $this->redirect(array('action' => 'index', 'admin' => true));
		}

		return $this->redirect(array('action' => 'index', 'admin' => true));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->SuperLottery->recursive = 0;
		if (!$this->SuperLottery->exists($id)) {
			throw new NotFoundException(__('Invalid super lottery'));
		}
		$options = array('conditions' => array('SuperLottery.' . $this->SuperLottery->primaryKey => $id));
		$this->set('superLottery', $this->SuperLottery->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$userId = $this->Auth->user('id');

		if ($this->request->is('post')) {
			$this->SuperLottery->create();

			$newSuperLottery = $this->request->data;
			$newSuperLottery['SuperLottery']['lottery_status_id'] = 1;
			$newSuperLottery['SuperLottery']['creator_user_id'] = $userId;

			$countLotOngoing = $this->SuperLottery->find('count', array('conditions' => array('lottery_status_id'=>'1')));

			if ($countLotOngoing >= 1) {
				$this->Session->setFlash(
					'There is already a super lottery ongoing.',
					'FlashMessage',
					array('type' => 'warning')
					);
				return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
			} 
			else if ($this->SuperLottery->save($newSuperLottery, true, array('eve_item_id', 'number_items', 'name', 'creator_user_id', 'nb_tickets', 'ticket_value', 'lottery_status_id'))) {
				$this->Session->setFlash(
					'The super lottery has been saved.',
					'FlashMessage',
					array('type' => 'info')
					);
				return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
			} 
			else {
				$this->Session->setFlash(
					'The super lottery could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'warning')
					);
				return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
			}
		}
		$eveItems = $this->SuperLottery->EveItem->find('all', array('order'=>'EveItem.name asc'));
		$this->set('eveItems', $eveItems);
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->SuperLottery->exists($id)) {
			throw new NotFoundException(__('Invalid super lottery'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SuperLottery->save($this->request->data)) {
				$this->Session->setFlash(__('The super lottery has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The super lottery could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SuperLottery.' . $this->SuperLottery->primaryKey => $id));
			$this->request->data = $this->SuperLottery->find('first', $options);
		}
		$eveItems = $this->SuperLottery->EveItem->find('list');
		$lotteryStatuses = $this->SuperLottery->LotteryStatus->find('list');
		$this->set(compact('eveItems', 'lotteryStatuses'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->SuperLottery->id = $id;
		if (!$this->SuperLottery->exists()) {
			throw new NotFoundException(__('Invalid super lottery'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SuperLottery->delete()) {
			$this->Session->setFlash(
					'The super lottery has been deleted.',
					'FlashMessage',
					array('type' => 'info')
					);
		} else {
			$this->Session->setFlash(
					'The super lottery could not be deleted. Please, try again.',
					'FlashMessage',
					array('type' => 'warning')
					);
		}
		return $this->redirect(array('action' => 'index'));
	}
}
