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
				$data = $this->Ticket->userBuyOneTicket($userId, $ticketId);
			}
			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');
			return $data;
		}
	}

	/**
	 * méthode pour acheter les premiers tickets d'une lotterie
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

			$proceed = true;

			if (!$this->EveItem->exists($itemId)) {
				$data = array('error' => 'Invalid Eve Item.' );
				$proceed = false;
			}
			else if (!$this->User->exists($userId)) {
				$data = array('error' => 'You must log in to buy a ticket !');
				$proceed = false;
			}

			//vérification du nombre total de lotteries
			$params = array(
				'conditions' => array('Lottery.lottery_status_id' => '1'),
				);
			$nbFreeLotteries = 10 - $this->Lottery->find('count', $params);
			if ($proceed && $nbFreeLotteries <= 0) {
				$data = array('error' => 'There is already 10 ongoing lotteries ! Please complete a lottery befor starting a new one.');
				$proceed = false;
			}

			$this->EveItem->contain(array('EveCategory'));	
			$choosenItem = $this->EveItem->findById($itemId);

			//vérification du nombre de grosses lotteries
			$params = array(
				'conditions' => array('Lottery.lottery_status_id' => '1', 'Lottery.nb_tickets' => '16'),
				);
			$nbFreeBigLotteries = 3 - $this->Lottery->find('count', $params);
			if ($proceed && $nbFreeBigLotteries <= 0 && $choosenItem['EveItem']['nb_tickets_default'] == 16) {
				$data = array('error' => 'There is already 3 big lotteries ! Please complete a big lottery before starting a new one.');
				$proceed = false;
			}

			$params = array(
				'conditions' => array('Lottery.lottery_status_id' => '1', 'Lottery.nb_tickets' => '48'),
				);
			$nbFreeBigLotteries = 1 - $this->Lottery->find('count', $params);
			if ($proceed && $nbFreeBigLotteries <= 0 && $choosenItem['EveItem']['nb_tickets_default'] == 48) {
				$data = array('error' => 'There is already one giga lottery ! Please complete the ongoing giga lottery before starting a new one.');
				$proceed = false;
			}

			if ($proceed){
				
				$buyer = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.wallet', 'User.tokens'));

				if(empty($listPositions)){
					$listPositions = array(rand(0, $choosenItem['EveItem']['nb_tickets_default']-1));
				}

				$ticketPrice = $this->EveItem->getTicketPrice($choosenItem);
				$totalPrice = count($listPositions)*$ticketPrice;

				//vas voir si l'item est déjà en lotterie
				$params = array(
					'conditions' => array('AND' => array('Lottery.lottery_status_id' => '1', 'Lottery.eve_item_id' => $itemId)),
					);
				$nbSameItems = $this->Lottery->find('count', $params);

				//vérifie si l'utilisateur sipose d'assez de crédits
				if($buyer['User']['wallet'] < $totalPrice){
					$data = array('error' => 'Not enough Credits.');
				}

				//vérifie si un item est déjà dans les lotteries en cours
				else if($nbSameItems >= 1){
					$data = array('error' => 'There is already a lottery for '.preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$choosenItem['EveItem']['name']).'. Please complete this lottery before starting a new one with this item.');
				}
				else{


					$data = $this->Lottery->createNewLotteryForItemByUser($choosenItem, $buyer);

					//si la nouvelle lottery à bien été crée
					if($data['success']){

						$dataSource = $this->Ticket->getDataSource();
						$dataSource->begin();

						$allBoughtTicketsIds = $this->Ticket->find('list', array(
							'fields' => array('Ticket.id'),
							'conditions' => array(
								'Ticket.lottery_id' => $data['lotteryId'],
								'Ticket.position' => $listPositions),
							'recursive' => -1
							));


						//Achète tous les tickets choisis 
						foreach ($allBoughtTicketsIds as $i => $idt) {
							$this->Ticket->userBuyOneTicket($buyer['User']['id'], $idt);
						}

						$data = array (
							'success' => true,
							'message' => 'Tickets bought.',
							'buyerEveId' => $buyer['User']['id'],
							'nbTickets' => $buyer['User']['id'],
							'buyerName' => $buyer['User']['eve_name'],
							'buyerWallet' => number_format($buyer['User']['wallet'], 2),
							'itemName' => $choosenItem['EveItem']['name']
							);

						$dataSource->commit();
						
					}
					else {
						$dataSource->rollback();
					}
				}
			}			

			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');

		}
	}
	
}
