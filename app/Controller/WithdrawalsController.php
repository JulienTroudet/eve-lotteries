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
			'conditions' => array('Withdrawal.status !=' => 'claimed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => 'award'),
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
			'conditions' => array('Withdrawal.status' => 'claimed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array("award_credit", "award_isk", "award_item")),
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
		$this->loadModel('Ticket');

		$paginateVar = array(
			'contain' => array(
				'Lottery' => array(
					'EveItem'
					)
				),
			'conditions' => array('Ticket.status !=' => 'claimed', 'Ticket.buyer_user_id' => $userGlobal['id'], 'Ticket.is_winner' => true),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => 10
			);
		$this->Paginator->settings = $paginateVar;
		$unclaimed_awards = $this->Paginator->paginate('Ticket');
		$this->set('unclaimed_awards', $unclaimed_awards);


		$params = array(
			'contain' => array(
				'Lottery' => array(
					'EveItem'
					)
				),
			'conditions' => array('Ticket.status' => 'claimed', 'Ticket.buyer_user_id' => $userGlobal['id'], 'Ticket.is_winner' => true),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => 10
			);
		$claimed_awards = $this->Ticket->find('all', $params);
		$this->set('claimed_awards', $claimed_awards);

	}

	public function old_list() {
		$userGlobal = $this->Auth->user();
		$paginateVar = array(
			'contain' => array(
				'Lottery' => array('EveItem'),
				),
			'conditions' => array('Ticket.status' => 'claimed', 'Ticket.buyer_user_id' => $userGlobal['id'], 'Ticket.is_winner' => true),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => 10
			);
		$this->Paginator->settings = $paginateVar;
		$claimed_awards = $this->Paginator->paginate('Ticket');
		$this->set('claimed_awards', $claimed_awards);

		$this->log($claimed_awards);
	}

	public function claim_credits() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {

			$this->disableCache();
			$this->loadModel('Ticket');
			$this->loadModel('User');

			$ticketId = $this->request->query('ticket_id');

			if (!$this->Ticket->exists($ticketId)) {
				$data = array('error' => 'Invalid Ticket.' );
			}

			else{
				$params = array(
					'contain' => array(
						'Lottery', 
						),
					'conditions' => array('Ticket.id' => $ticketId),
					);

				$claimedTicket = $this->Ticket->find('first', $params);

				$buyer = $this->User->findById($claimedTicket['Ticket']['buyer_user_id'], array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));

				if($claimedTicket['Ticket']['is_winner'] == false){
					$data = array('error' => 'Award not won.');
				}

				if($claimedTicket['Ticket']['status'] != 'unclaimed'){
					$data = array('error' => 'Award already claimed.');
				}

				else{


					$buyer['User']['wallet'] += $claimedTicket['Lottery']['value']*1.05;

					$claimedTicket['Ticket']['status'] = 'claimed';

					if ($this->User->save($buyer, true, array('id', 'wallet')) && $this->Ticket->save($claimedTicket, true, array('id', 'status'))) {

						$data = array (
							'success' => true,
							'message' => 'Award claimed.',
							'valueCredits' => number_format($claimedTicket['Lottery']['value']*1.05, 2)
							);

						$this->log('Award claimed : type[credits], id['.$buyer['User']['id'].'], ticket['.$ticketId.'], wallet['.number_format($buyer['User']['wallet'], 2).']');


					}
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}

	public function claim_isk() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {
			
			$this->disableCache();
			$this->loadModel('Ticket');
			$this->loadModel('User');

			$ticketId = $this->request->query('ticket_id');

			if (!$this->Ticket->exists($ticketId)) {
				$data = array('error' => 'Invalid Ticket.' );
			}
			
			else{
				$params = array(
					'contain' => array(
						'Lottery', 
						),
					'conditions' => array('Ticket.id' => $ticketId),
					);

				$claimedTicket = $this->Ticket->find('first', $params);

				$buyer = $this->User->findById($claimedTicket['Ticket']['buyer_user_id'], array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));

				if($claimedTicket['Ticket']['is_winner'] == false){
					$data = array('error' => 'Award not won.');
				}

				if($claimedTicket['Ticket']['status'] != 'unclaimed'){
					$data = array('error' => 'Award already claimed.');
				}

				else{

					$claimedTicket['Ticket']['status'] = 'waiting isk';

					if ($this->Ticket->save($claimedTicket, true, array('id', 'status'))) {

						$data = array (
							'success' => true,
							'message' => 'Award claimed.',
							'valueCredits' => number_format($claimedTicket['Lottery']['value'], 2)
							);

						$this->log('Award claimed : type[isk], id['.$buyer['User']['id'].'], ticket['.$ticketId.']');

						
					}
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}

	public function claim_item() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {
			
			$this->disableCache();
			$this->loadModel('Ticket');
			$this->loadModel('User');

			$ticketId = $this->request->query('ticket_id');

			if (!$this->Ticket->exists($ticketId)) {
				$data = array('error' => 'Invalid Ticket.' );
			}
			
			else{
				$params = array(
					'contain' => array(
						'Lottery', 
						),
					'conditions' => array('Ticket.id' => $ticketId),
					);

				$claimedTicket = $this->Ticket->find('first', $params);

				$buyer = $this->User->findById($claimedTicket['Ticket']['buyer_user_id'], array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));

				if($claimedTicket['Ticket']['is_winner'] == false){
					$data = array('error' => 'Award not won.');
				}

				if($claimedTicket['Ticket']['status'] != 'unclaimed'){
					$data = array('error' => 'Award already claimed.');
				}

				else{

					$claimedTicket['Ticket']['status'] = 'waiting item';

					if ($this->Ticket->save($claimedTicket, true, array('id', 'status'))) {

						$data = array (
							'success' => true,
							'message' => 'Award claimed.',
							'itemName' => preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$claimedTicket['Lottery']['name']),
							);

						$this->log('Award claimed : type[item], id['.$buyer['User']['id'].'], ticket['.$ticketId.']');

						
					}
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}
	
}
