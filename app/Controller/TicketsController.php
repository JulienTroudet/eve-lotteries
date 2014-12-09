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
				$buyer = $this->User->findById($userId);

				if($choosenTicket['Ticket']['buyer_user_id'] != null){
					$data = array('error' => 'Ticket already bought.');
				}

				else if($buyer['User']['wallet'] < $choosenTicket['Ticket']['value']){
					$data = array('error' => 'Not enough ISK.');
				}

				else{
					$buyer['User']['wallet'] -= $choosenTicket['Ticket']['value'];
					$buyer['User']['password'] ="";

					$choosenTicket['Ticket']['buyer_user_id'] = $buyer['User']['id'];

					if ($this->User->save($buyer) && $this->Ticket->save($choosenTicket)) {

						$data = array (
							'success' => true,
							'message' => 'Ticket bought.',
							'buyerEveId' => $buyer['User']['eve_id'],
							'buyerName' => $buyer['User']['eve_name'],
							'buyerWallet' => number_format($buyer['User']['wallet'], 2)
							);

						$this->_checkWinner($choosenTicket['Ticket']['lottery_id']);

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


		if ($winner != null) {

			$lottery['Lottery']['lottery_status_id'] = 2;
			$this->Lottery->save($lottery['Lottery']);

			foreach ($lottery['Ticket'] as $id => $ticket) {

				$this->log($ticket);

				$proxyTicket = $ticket;

				if($ticket['position'] == $winner){

					$proxyTicket['is_winner'] = true;
				}
				else{
					$proxyTicket['is_winner'] = false;
				}

				$this->Ticket->save($proxyTicket);
			}
		}
	}
}
