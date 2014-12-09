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
	public $components = array('Paginator', 'Session', 'RequestHandler');

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
		$params = array(
			'contain' => array('EveItem', 'SuperLotteryTicket', 'Winner'),
			'conditions' => array('SuperLottery.status !=' => 'waiting'),
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

	public function claim() {

		$this->request->onlyAllow('ajax');


		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('User');

			$idSuperLottery = $this->request->query('super_lottery_id');

			if (!$this->SuperLottery->exists($idSuperLottery)) {
				$data = array('error' => 'Invalid Super Lottery.' );
			}
			else{
				$params = array(
					'contain' => array('Winner', 'EveItem'),
					'conditions' => array('SuperLottery.id' => $idSuperLottery),
					);

				$superLottery = $this->SuperLottery->find('first', $params);

				$claimerUser = $this->User->findById($superLottery['Winner']['id']);

				if($superLottery['SuperLottery']['status'] != 'unclaimed'){
					$data = array('error' => 'Super Lottery already claimed.');
				}
				else{
					$superLottery['SuperLottery']['status'] = 'claimed';
					$claimerUser['User']['nb_new_won_super_lotteries']--;

					if($this->User->save($claimerUser['User'], true, array('id', 'nb_new_won_super_lotteries')) && $this->SuperLottery->save($superLottery, true, array('id', 'status'))){
						$data = array (
							'success' => true,
							'message' => 'You have claim '.$superLottery['SuperLottery']['number_items'].' '.$superLottery['EveItem']['name'].' !',
							);

						$this->log('SuperLottery claimed : user_id['.$claimerUser['User']['id'].'], super_lottery_id['.$superLottery['SuperLottery']['id'].']', 'eve-lotteries');
					}
					else{
						$data = array('error' => 'Super Lottery could not be claimed.');
					}
				}
			}
			$this->set(compact('data')); 
			$this->set('_serialize', 'data');
		}
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

			$superlottery['SuperLottery']['status'] = 'completed';
			unset($superlottery['SuperLottery']['modified']);

			if ($this->SuperLottery->save($superlottery, true, array('id', 'status'))) {
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
			$newSuperLottery['SuperLottery']['status'] = 'ongoing';
			$newSuperLottery['SuperLottery']['creator_user_id'] = $userId;

			$countLotOngoing = $this->SuperLottery->find('count', array('conditions' => array('status'=>'ongoing')));

			if ($countLotOngoing >= 1) {
				$newSuperLottery['SuperLottery']['status'] = 'waiting';
			} 

			if ($this->SuperLottery->save($newSuperLottery, true, array('eve_item_id', 'number_items', 'name', 'creator_user_id', 'nb_tickets', 'ticket_value', 'status'))) {
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
		$this->set(compact('eveItems'));
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
