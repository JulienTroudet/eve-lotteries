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
				$buyer = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.wallet'));

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
							'buyerEveId' => $buyer['User']['id'],
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
				$data = array('error' => 'There is already 10 ingoing lotteries ! Please complete a lottery befor starting a new one.');
				$proceed = false;
			}

			//vérification du nombre de grosses lotteries
			$params = array(
				'conditions' => array('Lottery.lottery_status_id' => '1', 'Lottery.nb_tickets' => '16'),
				);
			$nbFreeBigLotteries = 3 - $this->Lottery->find('count', $params);
			if ($proceed && $nbFreeBigLotteries <= 0) {
				$data = array('error' => 'There is already 3 big lotteries ! Please complete a big lottery befor starting a new one.');
				$proceed = false;
			}

			if ($proceed){
				$this->EveItem->contain(array('EveCategory'));
				$choosenItem = $this->EveItem->findById($itemId);

				if(empty($listPositions)){
					$listPositions = array(rand(0, $choosenItem['EveItem']['nb_tickets_default']-1));
				}

				$ticketPrice = $this->EveItem->getTicketPrice($choosenItem);
				$totalPrice = count($listPositions)*$ticketPrice;

				$buyer = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.wallet'));

				//vas voir si l'item est déjà en lotterie
				$params = array(
					'conditions' => array('AND' => array('Lottery.lottery_status_id' => '1', 'Lottery.eve_item_id' => $itemId)),
					);
				$nbSameItems = $this->Lottery->find('count', $params);

				$this->log($nbSameItems);

				if($buyer['User']['wallet'] < $totalPrice){
					$data = array('error' => 'Not enough ISK.');
				}
				//vérifie si un item est déjà dans les lotteries en cours
				else if($nbSameItems >= 1){
					$data = array('error' => 'There is already a lottery for '.preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$choosenItem['EveItem']['name']).'. Please complete this lottery before starting a new one with this item.');
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
							'buyerEveId' => $buyer['User']['id'],
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
				'User' => array('id', 'eve_name')
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
