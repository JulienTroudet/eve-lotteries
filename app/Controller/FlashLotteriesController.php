<?php
App::uses('AppController', 'Controller');

/**
 * FlashLotteries Controller
 *
 * @property FlashLottery $FlashLottery
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FlashLotteriesController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'see_last', 'list_tickets');
	}

	/**
	 * get the first flash lot without layout for Ajax
	 * @return [type] [description]
	 */
	public function see_last() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {
			$this->loadModel('Config');
			
			$flashLotteriesTimestamp = $this->request->query('timestamp');

			if($this->Config->hasFlashLotteriesChanged($flashLotteriesTimestamp)){


				$this->layout = false;
			//get the last flash lottery
				$flashLottery = $this->_get_last_flash_lottery();
				$this->set('flashLottery', $flashLottery);

				$this->set('timestamp_flash_lotteries', $this->Config->getFlashLotteriesTimestamp());
			}
			else{
				$this->autoRender = false;
				return "";
			}
		}
		
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->loadModel('FlashTicket');
		$params = array('contain' => array('EveItem' => array('EveCategory'), 'Winner',  'FlashTicket' => array('Buyer')), 'order' => array('FlashLottery.created' => 'desc'));

		$this->Paginator->settings = $params;

		$flashLotteries = $this->Paginator->paginate();
		foreach ($flashLotteries as $key => $flot) {

			$flashLotteries[$key]['FlashLottery']['nb_bought'] = $this->FlashTicket->find('count', array('conditions'=>array('flash_lottery_id'=>$flot['FlashLottery']['id'], 'buyer_user_id is not null')));

		}
		
		$this->set('flashLotteries', $flashLotteries);


	}

	public function list_flash_awards() {
		$this->layout = false;

		$userGlobal = $this->Auth->user();
		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'Winner'),
			'conditions' => array('FlashLottery.winner_user_id' => $userGlobal['id']),
			'order' => array('FlashLottery.created' => 'desc'), 
			);
		$flashWithdrawals = $this->FlashLottery->find('all', $params);

		$this->set('flashWithdrawals', $flashWithdrawals);
	}

	public function claim() {

		$this->request->onlyAllow('ajax');


		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('User');

			$idFlashLottery = $this->request->query('flash_lottery_id');

			if (!$this->FlashLottery->exists($idFlashLottery)) {
				$data = array('error' => 'Invalid Flash Lottery.' );
			}
			else{
				$params = array(
					'contain' => array('Winner', 'EveItem'),
					'conditions' => array('FlashLottery.id' => $idFlashLottery),
					);

				$flashLottery = $this->FlashLottery->find('first', $params);

				$claimerUser = $this->User->findById($flashLottery['Winner']['id']);

				if($flashLottery['FlashLottery']['status'] != 'unclaimed'){
					$data = array('error' => 'Flash Lottery already claimed.');
				}
				else{
					$flashLottery['FlashLottery']['status'] = 'claimed';
					$claimerUser['User']['nb_new_won_flash_lotteries']--;

					if($this->User->save($claimerUser['User'], true, array('id', 'nb_new_won_flash_lotteries')) && $this->FlashLottery->save($flashLottery, true, array('id', 'status'))){
						$data = array (
							'success' => true,
							'message' => 'You have claim '.$flashLottery['FlashLottery']['number_items'].' '.$flashLottery['EveItem']['name'].' !',
							'nb_new_won_flash_lotteries'=> $claimerUser['User']['nb_new_won_flash_lotteries'],
							);

						$this->log('FlashLottery claimed : user_id['.$claimerUser['User']['id'].'], flash_lottery_id['.$flashLottery['FlashLottery']['id'].']', 'eve-lotteries');
					}
					else{
						$data = array('error' => 'Flash Lottery could not be claimed.');
					}
				}
			}
			$this->set(compact('data')); 
			$this->set('_serialize', 'data');
		}
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		
		if (!$this->FlashLottery->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}

		$this->loadModel('FlashTicket');

		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'FlashTicket'=>array('Buyer'), 'Winner'),
			'conditions' => array('FlashLottery.' . $this->FlashLottery->primaryKey => $id),
			);
		$flot = $this->FlashLottery->find('first', $params);

		$flot['FlashLottery']['nb_bought'] = $this->FlashTicket->find('count', array('conditions'=>array('flash_lottery_id'=>$id, 'buyer_user_id is not null')));

		$this->set('flashLottery', $flot);
	}

	/**
	 * Fonction de complétion par les managers
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function admin_complete($id = null) {
		$this->loadModel('Message');
		$this->FlashLottery->recursive = 0;
		if (!$this->FlashLottery->exists($id)) {
			throw new NotFoundException(__('Invalid Flash Lottery'));
		}

		$flashlottery = $this->FlashLottery->findById($id);

		$flashlottery['FlashLottery']['status'] = 'completed';
		unset($flashlottery['FlashLottery']['modified']);

		if ($this->FlashLottery->save($flashlottery, true, array('id', 'status'))) {

			$this->Message->sendFlashLotteryMessage(
				$flashlottery['Winner']['id'], 
				'Flash Lottery Completed', 
				'Your prize for a Flash Lottery has been delivered by our staff. Please check your wallet or your contracts in game.',
				$flashlottery['FlashLottery']['id']
				);

			$this->Session->setFlash(
				'The Flash Lottery has been completed.',
				'FlashMessage',
				array('type' => 'info')
				);
			return $this->redirect(array('action' => 'index', 'admin' => true));
		}
		else{
			$this->Session->setFlash(
				'The Flash Lottery couldn\'t been completed ! Please try again.',
				'FlashMessage',
				array('type' => 'error')
				);
			return $this->redirect(array('action' => 'index', 'admin' => true));
		}

		return $this->redirect(array('action' => 'index', 'admin' => true));
	}


	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function list_tickets($id = null) {
		$this->layout = false;
		if (!$this->FlashLottery->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->loadModel('FlashTicket');

		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'FlashTicket'=>array('Buyer'), 'Winner'),
			'conditions' => array('FlashLottery.' . $this->FlashLottery->primaryKey => $id),
			);
		$flot = $this->FlashLottery->find('first', $params);

		$flot['FlashLottery']['nb_bought'] = $this->FlashTicket->find('count', array('conditions'=>array('flash_lottery_id'=>$id, 'buyer_user_id is not null')));

		$this->set('flashLottery', $flot);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->loadModel('Withdrawal');
		$nbWithdrawalClaimed = $this->Withdrawal->find('count', array('conditions'=>array('Withdrawal.status'=>'claimed')));
		$this->set('nbWithdrawalClaimed', $nbWithdrawalClaimed);

		$this->loadModel('SuperLottery');
		$nbSuperClaimed = $this->SuperLottery->find('count', array('conditions'=>array('SuperLottery.status'=>'claimed')));
		$this->set('nbSuperClaimed', $nbSuperClaimed);

		$nbFlashClaimed = $this->FlashLottery->find('count', array('conditions'=>array('FlashLottery.status'=>'claimed')));
		$this->set('nbFlashClaimed', $nbFlashClaimed);

		$this->FlashLottery->recursive = 0;
		$params = array('contain' => array('EveItem', 'Winner', 'FlashTicket' => array('Buyer')), 'conditions' => array('FlashLottery.status !=' => 'completed'), 'order' => array('FlashLottery.created' => 'desc'),);
		$this->Paginator->settings = $params;
		$this->set('flashLotteries', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->FlashLottery->recursive = 0;
		if (!$this->FlashLottery->exists($id)) {
			throw new NotFoundException(__('Invalid flash lottery'));
		}
		$options = array('conditions' => array('FlashLottery.' . $this->FlashLottery->primaryKey => $id));
		$this->set('flashLottery', $this->FlashLottery->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$this->loadModel('Withdrawal');
		$nbWithdrawalClaimed = $this->Withdrawal->find('count', array('conditions'=>array('Withdrawal.status'=>'claimed')));
		$this->set('nbWithdrawalClaimed', $nbWithdrawalClaimed);

		$this->loadModel('SuperLottery');
		$nbSuperClaimed = $this->SuperLottery->find('count', array('conditions'=>array('SuperLottery.status'=>'claimed')));
		$this->set('nbSuperClaimed', $nbSuperClaimed);

		$nbFlashClaimed = $this->FlashLottery->find('count', array('conditions'=>array('FlashLottery.status'=>'claimed')));
		$this->set('nbFlashClaimed', $nbFlashClaimed);

		$userId = $this->Auth->user('id');

		if ($this->request->is('post')) {
			$this->FlashLottery->create();

			$newFlashLottery = $this->request->data;
			$newFlashLottery['FlashLottery']['status'] = 'waiting';
			$newFlashLottery['FlashLottery']['creator_user_id'] = $userId;
			$newFlashLottery['FlashTicket'] = array();


			$params = array(
				'conditions' => array(
					'OR'=>array(
						"FlashLottery.start_date BETWEEN '".$newFlashLottery["FlashLottery"]["start_date"]."' AND '".$newFlashLottery["FlashLottery"]["expiration_date"]."'",
						"FlashLottery.expiration_date BETWEEN '".$newFlashLottery["FlashLottery"]["start_date"]."' AND DATE'".$newFlashLottery["FlashLottery"]["expiration_date"]."'"
						)
					)
				);
			$testOther = $this->FlashLottery->find('all', $params);

			if (!empty($testOther)) {
				$this->Session->setFlash('Can\'t create simultaneous Flash Lotteries.', 'FlashMessage', array('type' => 'error'));
				return $this->redirect(array('controller' => 'flash_lotteries', 'action' => 'admin_index', 'admin' => true));
			}


			for ($i = 0; $i < $newFlashLottery['FlashLottery']['nb_tickets']; $i++) {
				$flashTicket = array('position' => $i);

				array_push($newFlashLottery['FlashTicket'], $flashTicket);
			}

	        // debug($newFlashLottery);
	        // die();

			if ($this->FlashLottery->saveAssociated($newFlashLottery)) {
				$this->Session->setFlash('The flash lottery has been saved.', 'FlashMessage', array('type' => 'info'));
				return $this->redirect(array('controller' => 'flash_lotteries', 'action' => 'admin_index', 'admin' => true));
			} else {
				$this->Session->setFlash('The flash lottery could not be saved. Please, try again.', 'FlashMessage', array('type' => 'warning'));
				return $this->redirect(array('controller' => 'flash_lotteries', 'action' => 'admin_add', 'admin' => true));
			}
		}

	    //si pas de requête POST on vas chercher les Items pour le choix
		$eveItems = $this->FlashLottery->EveItem->find('all', array('order' => 'EveItem.name asc'));
		$this->set('eveItems', $eveItems);
	}


	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->FlashLottery->id = $id;
		if (!$this->FlashLottery->exists()) {
			throw new NotFoundException(__('Invalid flash lottery'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->FlashLottery->delete()) {
			$this->Session->setFlash('The flash lottery has been deleted.', 'FlashMessage', array('type' => 'info'));
		} else {
			$this->Session->setFlash('The flash lottery could not be deleted. Please, try again.', 'FlashMessage', array('type' => 'warning'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	/**
	* Gets the last flash lottery in the database
	* it is either the ongoing flash or the las won flash
	* @return [type] [description]
	*/
	protected function _get_last_flash_lottery(){
		$this->loadModel('FlashTicket');

		$flashLottery = null;
		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'FlashTicket'=>array('Buyer'), 'Winner'),
			'conditions' => array(
				'OR'=>array(
					'AND'=>array(
						'FlashLottery.modified BETWEEN NOW() -INTERVAL 2 HOUR AND NOW()',
						'FlashLottery.status'=>array('completed', 'claimed', 'unclaimed')
						),
					'FlashLottery.status'=>'ongoing')),
			'order' => array('FlashLottery.created' => 'desc'),
			);
		$flashLottery = $this->FlashLottery->find('first', $params);

		if(!empty($flashLottery)){
			$flashLottery['FlashLottery']['nb_bought'] = $this->FlashTicket->find('count', array('conditions'=>array('flash_lottery_id'=>$flashLottery['FlashLottery']['id'], 'buyer_user_id is not null')));
		}
		$this->FlashLottery->initiate_flash_lottery();
		
		$this->FlashLottery->end_flash_lottery();

		return $flashLottery;
	}

	
}
