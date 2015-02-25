<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FlashTicketsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public $uses = array('FlashTicket', 'User');

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

			if (!$this->FlashTicket->exists($ticketId)) {
				$data = array('error' => 'Invalid Ticket.' );
			}
			else if (!$this->User->exists($userId)) {
				$data = array('error' => 'You must log in to buy a ticket !');
			}
			else{
				$data = $this->FlashTicket->userBuyOneTicket($userId, $ticketId);
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
		}
	}
	
}
