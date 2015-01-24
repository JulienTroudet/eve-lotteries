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
				$listTicketsIds = new array($ticketId);
				$data = $this->Ticket->userBuyTickets($userId, $listTicketsIds);
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
			$this->loadModel('Statistic');
			
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
				$data = array('error' => 'There is already 3 big lotteries ! Please complete a big lottery befor starting a new one.');
				$proceed = false;
			}

			if ($proceed){
				

				if(empty($listPositions)){
					$listPositions = array(rand(0, $choosenItem['EveItem']['nb_tickets_default']-1));
				}

				$ticketPrice = $this->EveItem->getTicketPrice($choosenItem);
				$totalPrice = count($listPositions)*$ticketPrice;

				$buyer = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.wallet', 'User.tokens'));

				//vas voir si l'item est déjà en lotterie
				$params = array(
					'conditions' => array('AND' => array('Lottery.lottery_status_id' => '1', 'Lottery.eve_item_id' => $itemId)),
					);
				$nbSameItems = $this->Lottery->find('count', $params);


				if($buyer['User']['wallet'] < $totalPrice){
					$data = array('error' => 'Not enough Credits.');
				}
				//vérifie si un item est déjà dans les lotteries en cours
				else if($nbSameItems >= 1){
					$data = array('error' => 'There is already a lottery for '.preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$choosenItem['EveItem']['name']).'. Please complete this lottery before starting a new one with this item.');
				}
				else{
					$buyer['User']['wallet'] -= $totalPrice;
					$buyer['User']['tokens'] += $totalPrice/10000000;

					$this->Lottery->create();
					$newLottery = array('Lottery'=>array(
						'eve_item_id' =>  $itemId,
						'creator_user_id' => $userId,
						'nb_tickets' => $choosenItem['EveItem']['nb_tickets_default'],
						'lottery_status_id' => 1,
						'value' => $choosenItem['EveItem']['eve_value'],
						'name'=> $choosenItem['EveItem']['name'],
						));
					$dataSource = $this->Ticket->getDataSource();
					$dataSource->begin();
					
					if ($this->User->save($buyer, true, array('id', 'wallet', 'tokens')) && $this->Lottery->save($newLottery)) {
						$this->Statistic->saveStat($buyer['User']['id'], 'init_lottery', $this->Lottery->id, $choosenItem['EveItem']['eve_value'], $choosenItem['EveItem']['id']);

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
								$this->Ticket->save($newTicket);

								$this->Statistic->saveStat($buyer['User']['id'], 'buy_ticket', $this->Ticket->id, $ticketPrice, $choosenItem['EveItem']['id']);
								$this->log('Ticket Buyed : user_name['.$buyer['User']['eve_name'].'], id['.$buyer['User']['id'].'], ticket['.$this->Ticket->id.']', 'eve-lotteries');
							}
							else{
								$this->Ticket->save($newTicket);
							}
							

							$this->_checkWinner($this->Lottery->id, $buyer['User']['id']);
						}

						//$this->log('User state : name['.$buyer['User']['eve_name'].'], wallet['.number_format($buyer['User']['wallet'], 2).'], tokens['.number_format($buyer['User']['tokens'], 2).']', 'eve-lotteries');

						$data = array (
							'success' => true,
							'message' => 'Ticket bought.',
							'buyerEveId' => $buyer['User']['id'],
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

	protected  function _checkWinner($lotteryId, $userId) {
		$this->loadModel('Statistic');
		$this->loadModel('Message');
		$this->loadModel('Lottery');
		$this->loadModel('User');
		$this->Lottery->contain(array(
			'EveItem', 
			'Ticket' => array(
				'User' => array('id', 'eve_name', 'nb_new_won_lotteries')
				)
			)
		);
		$lottery = $this->Lottery->findById($lotteryId);

		$winner = $this->Lottery->checkForWinner($lottery);


		if ($winner >= 0) {


			$this->loadModel('Withdrawal');

			$lottery['Lottery']['lottery_status_id'] = 2;
			unset($lottery['Lottery']['modified']);
			$this->Lottery->save($lottery['Lottery'], true, array('id', 'lottery_status_id'));

			$this->Statistic->saveStat($userId, 'end_lottery', $lottery['Lottery']['id'], $lottery['Lottery']['value'], $lottery['Lottery']['eve_item_id']);

			foreach ($lottery['Ticket'] as $id => $ticket) {

				$proxyTicket = $ticket;

				if($ticket['position'] == $winner){


					$proxyTicket['is_winner'] = true;
					$proxyTicket['status'] = 'unclaimed';

					

					$this->Withdrawal->create();
					$newWithdrawal = array('Withdrawal'=>array(
						'type' =>'award',
						'value' => '',
						'status' =>'new',
						'user_id' =>$ticket['buyer_user_id'],
						'ticket_id' =>$ticket['id'],
						));

					$this->Withdrawal->save($newWithdrawal, true, array('type', 'value', 'status','user_id', 'ticket_id'));

					$this->Message->sendLotteryMessage(
						$ticket['buyer_user_id'], 
						'Lottery Won', 
						'You have win '.preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$lottery['EveItem']['name']).'. You can now claim your prize.', 
						$this->Withdrawal->id);

					$this->Statistic->saveStat($ticket['buyer_user_id'], 'win_lottery', $lottery['Lottery']['id'], $lottery['Lottery']['value'], $lottery['Lottery']['eve_item_id']);
					$this->log('Lottery won : lottery['.$lotteryId.'], user_id['.$ticket['buyer_user_id'].'], ticket['.$ticket['id'].']', 'eve-lotteries');

					$ticket['User']['nb_new_won_lotteries']++;
					$this->User->save($ticket['User'], true, array('id', 'nb_new_won_lotteries'));

				}
				else{
					$proxyTicket['is_winner'] = false;
				}

				$this->Ticket->save($proxyTicket);
			}
		}
	}
	
}
