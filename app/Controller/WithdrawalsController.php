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
		$this->Auth->allow('index', 'view');
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
				$claimerUser = $this->User->findById($claimedAward['Withdrawal']['user_id'], array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));
				if($claimedAward['Withdrawal']['status'] != 'new'){
					$data = array('error' => 'Award already claimed.');
				}
				else{
					switch ($claimType) {
						case 'credit':

						$claimedValue = $claimedAward['Ticket']['Lottery']['value']*1.05;

						$claimerUser['User']['wallet'] += $claimedValue;

						$claimedAward['Withdrawal']['status'] = 'completed';
						$claimedAward['Withdrawal']['type'] = 'award_credit';
						$claimedAward['Withdrawal']['value'] = $claimedValue;

						if ($this->User->save($claimerUser, true, array('id', 'wallet')) && $this->Withdrawal->save($claimedAward, true, array('id', 'status', 'type', 'value'))) {

							$data = array (
								'success' => true,
								'message' => $claimedValue.' EVE-Lotteries Credits',
								);

							$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']');


						}
						break;

						case 'isk':
						$claimedValue = $claimedAward['Ticket']['Lottery']['value'];


						$claimedAward['Withdrawal']['status'] = 'claimed';
						$claimedAward['Withdrawal']['type'] = 'award_isk';
						$claimedAward['Withdrawal']['value'] = $claimedValue;

						if ($this->Withdrawal->save($claimedAward, true, array('id', 'status', 'type', 'value'))) {

							$data = array (
								'success' => true,
								'message' => $claimedValue.' ISK',
								);

							$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']');


						}
						break;
						case 'item':
						$claimedValue = $claimedAward['Ticket']['Lottery']['eve_item_id'];


						$claimedAward['Withdrawal']['status'] = 'claimed';
						$claimedAward['Withdrawal']['type'] = 'award_item';
						$claimedAward['Withdrawal']['value'] = $claimedValue;

						if ($this->Withdrawal->save($claimedAward, true, array('id', 'status', 'type', 'value'))) {

							$data = array (
								'success' => true,
								'message' => preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$claimedAward['Ticket']['Lottery']['name']),
								);

							$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']');


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
			'limit' => 20
			);
		$this->Paginator->settings = $paginateVar;
		$claimed_awards = $this->Paginator->paginate('Withdrawal');
		$this->set('claimed_awards', $claimed_awards);
	}

	public function admin_list_awards_to_complete() {
		$this->layout = false;

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
			'limit' => 20
			);
		$this->Paginator->settings = $paginateVar;
		$claimed_awards = $this->Paginator->paginate('Withdrawal');
		$this->set('claimed_awards', $claimed_awards);
	}

	public function admin_complete_award() {

		$this->request->onlyAllow('ajax');


		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('Ticket');
			$this->loadModel('User');

			$withdrawalId = $this->request->query('withdrawal_id');

			if (!$this->Withdrawal->exists($withdrawalId)) {
				$data = array('error' => 'Invalid Award.' );
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
				$claimerUser = $this->User->findById($claimedAward['Withdrawal']['user_id'], array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));
				
				if($claimedAward['Withdrawal']['status'] != 'claimed'){
					$data = array('error' => 'Award not claimed.');
				}
				else{

					$claimedAward['Withdrawal']['status'] = 'completed';

					if ($this->Withdrawal->save($claimedAward, true, array('id', 'status'))) {

						$data = array (
							'success' => true,
							'message' => 'You have completed the Award for '.$claimerUser['User']['eve_name'],
							);

						$this->log('Award completed : user_name['.$claimerUser['User']['eve_name'].'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.']');
					}
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}

	
}
