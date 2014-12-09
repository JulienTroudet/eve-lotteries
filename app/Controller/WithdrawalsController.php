<?php
App::uses('AppController', 'Controller');
/**
 * Lotteries Controller
 *
 * @property Lottery $Lottery
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class WithdrawalsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

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

		$paginateVar = array(
			'contain' => array(
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => array('new', 'claimed'), 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item', 'award')),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'limit' => 10
			);
		$this->Paginator->settings = $paginateVar;
		$unclaimed_awards = $this->Paginator->paginate('Withdrawal');
		$this->set('unclaimed_awards', $unclaimed_awards);

		$params = array(
			'contain' => array(
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => 'completed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item')),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'limit' => 10
			);
		$claimed_awards = $this->Withdrawal->find('all', $params);

		$this->set('claimed_awards', $claimed_awards);
	}

	public function list_awards() {
		$this->layout = false;

		$userGlobal = $this->Auth->user();
		$paginateVar = array(
			'contain' => array(
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => array('new', 'claimed'), 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item', 'award')),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'limit' => 10
			);
		$this->Paginator->settings = $paginateVar;
		$unclaimed_awards = $this->Paginator->paginate('Withdrawal');
		$this->set('unclaimed_awards', $unclaimed_awards);

		$params = array(
			'contain' => array(
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => 'completed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item')),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'limit' => 10
			);
		$claimed_awards = $this->Withdrawal->find('all', $params);
		$this->set('claimed_awards', $claimed_awards);
	}

	public function old_list() {
		$userGlobal = $this->Auth->user();
		$paginateVar = array(
			'contain' => array(
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => 'completed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array("award_credit", "award_isk", "award_item")),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'limit' => 20
			);
		$this->Paginator->settings = $paginateVar;
		$completed_awards = $this->Paginator->paginate('Withdrawal');
		$this->set('completed_awards', $completed_awards);
	}

	public function claim() {

		$this->request->onlyAllow('ajax');


		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('Ticket');
			$this->loadModel('User');
			$this->loadModel('Statistic');

			$withdrawalId = $this->request->query('withdrawal_id');
			$claimType = $this->request->query('claim_type');

			if (!$this->Withdrawal->exists($withdrawalId)) {
				$data = array('error' => 'Invalid Award.' );
			}

			if (!in_array( $claimType , array('credit', 'isk', 'item')) ){
				$data = array('error' => 'Invalid Award claim.' );
			}

			else{
				$params = array(
					'contain' => array(
						'User',
						'Ticket' => array(
							'Lottery',
							),
						),
					'conditions' => array('Withdrawal.id' => $withdrawalId),
					);

				$claimedAward = $this->Withdrawal->find('first', $params);

				$claimerUser = $this->User->findById($claimedAward['Withdrawal']['user_id'], array('User.id', 'User.eve_name', 'User.wallet'));
				if($claimedAward['Withdrawal']['status'] != 'new'){
					$data = array('error' => 'Award already claimed.');
				}
				else{
					switch ($claimType) {
						case 'credit':

						$claimedValue = $claimedAward['Ticket']['Lottery']['value']*1.05;

						$claimerUser['User']['wallet'] += $claimedValue;

						$claimedAward['Withdrawal']['group_id'] = $claimedAward['Withdrawal']['id'];
						$claimedAward['Withdrawal']['status'] = 'completed';
						$claimedAward['Withdrawal']['type'] = 'award_credit';
						$claimedAward['Withdrawal']['value'] = $claimedValue;

						if ($this->User->save($claimerUser, true, array('id', 'wallet')) && $this->Withdrawal->save($claimedAward, true, array('id', 'group_id', 'status', 'type', 'value'))) {

							$data = array (
								'success' => true,
								'message' => $claimedValue.' EVE-Lotteries Credits',
								);

							$this->Statistic->saveStat($claimerUser['User']['id'], 'withdrawal_credits', $withdrawalId, $claimedValue, $claimedAward['Ticket']['Lottery']['eve_item_id']);

							$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');


						}
						break;

						case 'isk':
						$claimedValue = $claimedAward['Ticket']['Lottery']['value'];

						$claimedAward['Withdrawal']['group_id'] = $claimedAward['Withdrawal']['id'];
						$claimedAward['Withdrawal']['status'] = 'claimed';
						$claimedAward['Withdrawal']['type'] = 'award_isk';
						$claimedAward['Withdrawal']['value'] = $claimedValue;

						if ($this->Withdrawal->save($claimedAward, true, array('id', 'group_id', 'status', 'type', 'value'))) {

							$data = array (
								'success' => true,
								'message' => $claimedValue.' ISK',
								);

							$this->Statistic->saveStat($claimerUser['User']['id'], 'withdrawal_isk', $withdrawalId, $claimedValue, $claimedAward['Ticket']['Lottery']['eve_item_id']);

							$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');


						}
						break;
						case 'item':
						$claimedISK = $claimedAward['Ticket']['Lottery']['value'];

						$claimedValue = $claimedAward['Ticket']['Lottery']['eve_item_id'];

						$claimedAward['Withdrawal']['group_id'] = $claimedAward['Withdrawal']['id'];
						$claimedAward['Withdrawal']['status'] = 'claimed';
						$claimedAward['Withdrawal']['type'] = 'award_item';
						$claimedAward['Withdrawal']['value'] = $claimedValue;

						if ($this->Withdrawal->save($claimedAward, true, array('id', 'group_id', 'status', 'type', 'value'))) {

							$data = array (
								'success' => true,
								'message' => preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$claimedAward['Ticket']['Lottery']['name']),
								);

							$this->Statistic->saveStat($claimerUser['User']['id'], 'withdrawal_item', $withdrawalId, $claimedISK, $claimedAward['Ticket']['Lottery']['eve_item_id']);

							$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');


						}
						break;
					}

					
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}

	public function admin_index() {

		$this->_organize_groups();

		$this->Withdrawal->virtualFields['total_value'] = 'SUM(Withdrawal.value)';

		$paginateVar = array(
			'contain' => array(
				'User',
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => array('claimed'), 'Withdrawal.type' => array('award_isk', 'award_item')),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'group' => array('Withdrawal.group_id'),
			'limit' => 20
			);


		$this->Paginator->settings = $paginateVar;
		$claimed_awards = $this->Paginator->paginate('Withdrawal');
		
		$this->set('claimed_awards', $claimed_awards);
	}

	public function admin_list_awards_to_complete() {

		$this->_organize_groups();

		$this->Withdrawal->virtualFields['total_value'] = 'SUM(Withdrawal.value)';
		$paginateVar = array(
			'contain' => array(
				'User',
				'Ticket' => array(
					'Lottery' => array(
						'EveItem'
						)
					),
				),
			'conditions' => array('Withdrawal.status' => array('claimed'), 'Withdrawal.type' => array('award_isk', 'award_item')),
			'order' => array(
				'Withdrawal.modified' => 'desc'
				),
			'group' => array('Withdrawal.group_id'),
			'limit' => 20
			);


		$this->Paginator->settings = $paginateVar;
		$claimed_awards = $this->Paginator->paginate('Withdrawal');
		
		$this->set('claimed_awards', $claimed_awards);
	}

	protected function _organize_groups() {
		//ici lorsque l'admin se connecte on effectue un regroupement des retraits d'ISK. Ainsi on fait une première requette afin de remplir le id_group des withdrawals pour qu'un player n'aie qu'un seul retrait à son actif (simplification des versements)
		//on récupère la liste des user_id concernés.
		$params = array(
			'conditions' => array('AND' => array('Withdrawal.status' => 'claimed', 'Withdrawal.type' => 'award_isk')),
			'fields' => array('Withdrawal.user_id'),
			'group' => array('Withdrawal.user_id')
			);

		$userIds = $this->Withdrawal->find('list', $params);

		//on update pour chaque user le group_id des withdrawal claimed ISK afin de pouvoir les grouper plus tard avec cette valeur.
		foreach ($userIds as $id => $userId) {
			$this->Withdrawal->updateAll(
				array('Withdrawal.group_id' => $id),
				array('AND' => array('Withdrawal.status' => 'claimed', 'Withdrawal.type' => 'award_isk', 'Withdrawal.user_id' => $userId, 'Withdrawal.admin_id' => null))
				);
		}
	}

	public function admin_complete_award() {
		$userGlobal = $this->Auth->user();
		$this->request->onlyAllow('ajax');


		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('Ticket');
			$this->loadModel('User');

			$withdrawalGroupId = $this->request->query('withdrawal_group_id');

			
			$claimedAwards = $this->Withdrawal->findAllByGroupId($withdrawalGroupId);
			if (count($claimedAwards)<=0) {
				$data = array('error' => 'Invalid Award.' );
				return;
			}


			else{
				$params = array(
					'contain' => array(
						'User',
						'Ticket' => array(
							'Lottery',
							),
						),
					'conditions' => array('Withdrawal.group_id' => $withdrawalGroupId),
					);

				$claimedAwards = $this->Withdrawal->find('all', $params);

				
				
				$claimerUser = null;
				$continue = true;
				foreach ($claimedAwards as $key => $claimedAward) {
					if($claimedAward['Withdrawal']['status'] != 'claimed'){
						$data = array('error' => 'Award not claimed.');
						$continue = false;
						break;
					}

					if($claimedAward['Withdrawal']['admin_id'] != $userGlobal['id']){
						$data = array('error' => 'Award not reserved or already reserved by an admin.');
						$continue = false;
						break;
					}

					if(!isset($claimerUser)){
						$claimerUser = $this->User->findById($claimedAward['Withdrawal']['user_id'], array('User.id', 'User.eve_name', 'User.wallet'));
					}
					
				}

				if($continue){
					
					$success = $this->Withdrawal->updateAll(
						array('Withdrawal.status' => '"completed"'),
						array('Withdrawal.group_id' => $withdrawalGroupId)
						);

					if ($success) {

						$data = array (
							'success' => true,
							'message' => 'You have completed the Award for '.$claimerUser['User']['eve_name'],
							);

						$this->log('Award completed : user_name['.$claimerUser['User']['eve_name'].'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalGroupId.']', 'eve-lotteries');
					}
				}
			}
			$this->set(compact('data')); 
			$this->set('_serialize', 'data');
		}
	}

	public function admin_reserve_award() {
		$userGlobal = $this->Auth->user();
		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('Ticket');

			$withdrawalGroupId = $this->request->query('withdrawal_group_id');

			$claimedAwards = $this->Withdrawal->findAllByGroupId($withdrawalGroupId);
			if (count($claimedAwards)<=0) {
				$data = array('error' => 'Invalid Award.' );
				return;
			}
			else{
				$continue = true;
				foreach ($claimedAwards as $key => $claimedAward) {
					if($claimedAward['Withdrawal']['status'] != 'claimed'){
						$data = array('error' => 'Award not claimed.');
						$continue = false;
						break;
					}

					if(isset($claimedAward['Withdrawal']['admin_id'])){
						$data = array('error' => 'Award already reserved by an admin.');
						$continue = false;
						break;
					}
				}
				if($continue){
					$success = $this->Withdrawal->updateAll(
						array('Withdrawal.admin_id' => $userGlobal['id']),
						array('Withdrawal.group_id' => $withdrawalGroupId)
						);

					if ($success) {

						$data = array (
							'success' => true,
							'message' => 'You have reserved the Award',
							);

						$this->log('Award reserved : admin_id['.$userGlobal['id'].'], withdrawal_group_id['.$withdrawalGroupId.']', 'eve-lotteries');
					}
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}

	
}
