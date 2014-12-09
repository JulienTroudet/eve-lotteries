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
	 * add method
	 *
	 * @return void
	 */
	public function add($lottery_id = null, $lottery_value = null) {

		if (!$this->Ticket->Lottery->exists($lottery_id)) {
			throw new NotFoundException(__('Invalid Lottery'));
		}

		$lottery = $this->Ticket->Lottery->find('first', array('conditions' => array('Lottery.id' => $lottery_id)));

		$ticket_value = round($lottery_value/$lottery['Lottery']['nb_tickets'], 0);


		if ($this->request->is('post')) {
			
			$nbCreated = 0;
			for ($i=0; $i < $lottery['Lottery']['nb_tickets']; $i++) { 

				$this->Ticket->create();
				$dataProxy = $this->request->data;
				$dataProxy['Ticket']['lottery_id'] = $lottery_id;
				$dataProxy['Ticket']['position'] = $i;

				if ($this->Ticket->save($dataProxy)) {
					$nbCreated++;
				}
			}
			
			if ($nbCreated == $lottery['Lottery']['nb_tickets']) {
				$this->Session->setFlash(__('All the tickets have been created.'));
				return $this->redirect(array('controller' => 'Lotteries', 'action' => 'view', $lottery_id));
			} else {
				$this->Session->setFlash(__('The tickets could not be saved. Please, try again.'));
			}
		}

		$this->set('ticket_value', $ticket_value);
		$this->set('lottery', $lottery);

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
				$options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $ticketId));
				$choosenTicket = $this->Ticket->find('first', $options);

				$options = array('conditions' => array('User.' . $this->User->primaryKey => $userId));
				$buyer = $this->User->find('first', $options);

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
					}
				}
			}


			

			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');

		}
	}

	
}
