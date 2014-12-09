<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TicketsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public $uses = array('Ticket', 'User');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('buy');
	}

	/**
	 * buy method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function buy() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {
			
			$this->disableCache();

			$ticketId = $this->request->query('ticket_id');

			$userId = $this->Auth->user('id');

			if (!$this->Ticket->exists($ticketId)) {
				$data = array('error' => 'Invalid Ticket.' );
			}
			else if (!$this->User->exists($userId)) {
				$data = array('error' => 'You must log in to buy a ticket !');
			}
			else{
				$choosenTicket = $this->Ticket->findById($ticketId);
				$buyer = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));

				if($choosenTicket['Ticket']['buyer_user_id'] != null){
					$data = array('error' => 'Ticket already bought.');
				}

				else if($buyer['User']['wallet'] < $choosenTicket['Ticket']['value']){
					$data = array('error' => 'Not enough ISK.');
				}

				else{
					$buyer['User']['wallet'] -= $choosenTicket['Ticket']['value'];

					$choosenTicket['Ticket']['buyer_user_id'] = $buyer['User']['id'];

					if ($this->User->save($buyer, true, array('id', 'wallet')) && $this->Ticket->save($choosenTicket)) {

						$data = array (
							'success' => true,
							'message' => 'Ticket bought.',
							'buyerEveId' => $buyer['User']['eve_id'],
							'buyerName' => $buyer['User']['eve_name'],
							'buyerWallet' => number_format($buyer['User']['wallet'], 2)
							);

						$this->log('Ticket Buyed : name['.$buyer['User']['eve_name'].'], id['.$buyer['User']['id'].'], ticket['.$ticketId.'], wallet['.number_format($buyer['User']['wallet'], 2).']', 'eve-lotteries');

						$this->_checkWinner($choosenTicket['Ticket']['lottery_id']);

					}
				}
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}


	/**
	 * add method
	 *
	 * @return void
	 */
	public function buy_firsts() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {

			$this->loadModel('EveItem');
			$this->loadModel('Lottery');
			$this->loadModel('User');
			
			$this->disableCache();

			$itemId = $this->request->query('item_id');
			$listPositions = $this->request->query('list_positions');
			
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

				if(!$listPositions){
					$listPositions = array(rand(0, $choosenItem['EveItem']['nb_tickets_default']-1));
				}

				$ticketPrice = $this->EveItem->getTicketPrice($choosenItem);
				$totalPrice = count($listPositions)*$ticketPrice;

				$buyer = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.eve_id', 'User.wallet'));

				//TODO TESTS DIVERS

				if($buyer['User']['wallet'] < $totalPrice){
					$data = array('error' => 'Not enough ISK.');
				}

				else{
					$buyer['User']['wallet'] -= $totalPrice;

					$this->Lottery->create();
					$newLottery = array('Lottery'=>array(
						'eve_item_id' =>  $itemId,
						'creator_user_id' => $userId,
						'nb_tickets' => $choosenItem['EveItem']['nb_tickets_default'],
						'lottery_status_id' => 1,
						'value' => $choosenItem['EveItem']['eve_value'],
						'name'=> $choosenItem['EveItem']['name'],
						));

					if ($this->User->save($buyer, true, array('id', 'wallet')) && $this->Lottery->save($newLottery)) {

						$this->log('New Lottery : name['.$buyer['User']['eve_name'].'], id['.$buyer['User']['id'].'], lottery['.$this->Lottery->id.'], item['.$choosenItem['EveItem']['name'].']', 'eve-lotteries');

						for ($i=0; $i < $choosenItem['EveItem']['nb_tickets_default']; $i++) {
							$this->Ticket->create();
							$newTicket = array('Ticket'=>array(
								'lottery_id' => $this->Lottery->id,
								'position' => $i,
								'value' => $ticketPrice,
								));
							if (in_array($i, $listPositions)) {
								$newTicket['Ticket']['buyer_user_id'] = $userId;
								$this->log('Ticket Buyed : name['.$buyer['User']['eve_name'].'], id['.$buyer['User']['id'].'], ticket['.$this->Ticket->id.']', 'eve-lotteries');
							}
							$this->Ticket->save($newTicket);

							

							$this->_checkWinner($this->Lottery->id);
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

	protected  function _checkWinner($lotteryId) {

		$this->loadModel('Lottery');
		$this->Lottery->contain(array(
			'EveItem', 
			'Ticket' => array(
				'User' => array('id', 'eve_id', 'eve_name')
				)
			)
		);
		$lottery = $this->Lottery->findById($lotteryId);

		$winner = $this->Lottery->checkForWinner($lottery);


		if ($winner >= 0) {

			$this->loadModel('Withdrawal');

			$lottery['Lottery']['lottery_status_id'] = 2;
			$this->Lottery->save($lottery['Lottery']);

			foreach ($lottery['Ticket'] as $id => $ticket) {

				$proxyTicket = $ticket;

				if($ticket['position'] == $winner){


					$proxyTicket['is_winner'] = true;
					$proxyTicket['status'] = 'unclaimed';

					$this->log('Lottery won : lottery['.$lotteryId.'], user_id['.$ticket['buyer_user_id'].'], ticket['.$ticket['id'].']', 'eve-lotteries');

					$this->Withdrawal->create();
					$newWithdrawal = array('Withdrawal'=>array(
						'type' =>'award',
						'value' => '',
						'status' =>'new',
						'user_id' =>$ticket['buyer_user_id'],
						'ticket_id' =>$ticket['id'],
						));

					$this->Withdrawal->save($newWithdrawal, true, array('type', 'value', 'status','user_id', 'ticket_id'));

				}
				else{
					$proxyTicket['is_winner'] = false;
				}

				$this->Ticket->save($proxyTicket);
			}
		}
	}
	
}
