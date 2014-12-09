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
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
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
				return $this->redirect(array('action' => 'index'));
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
	public function buy($id = null) {
		$userId = $this->Auth->user('id');
	}

	
}
