<?php
App::uses('AppController', 'Controller');
/**
 * SuperLotteryTickets Controller
 *
 * @property SuperLotteryTicket $SuperLotteryTicket
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SuperLotteryTicketsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public $uses = array('SuperLottery', 'User', 'SuperLotteryTicket');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('');

		if (!$this->Auth->loggedIn()) {
			$this->Session->setFlash('Please Log in !', 'FlashMessage', array('type' => 'warning'));
			return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
		}
	}

	/**
	 * buy method
	 * Gère l'achat des tickets de super lotteries
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function buy() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {
			
			$this->disableCache();

			$nbTicketsBuy = $this->request->query('nb_tickets');
			$superLotteryId = $this->request->query('id_super');

			$userId = $this->Auth->user('id');



			if (!$this->SuperLottery->exists($superLotteryId)) {

				$data = array('error' => 'This Super Lottery does not exist.' );
				$this->set(compact('data')); // Pass $data to the view
				$this->set('_serialize', 'data');
				return $data;
			}
			else if (!$this->User->exists($userId)) {

				$data = array('error' => 'You must log in to buy a ticket !' );
				$this->set(compact('data')); // Pass $data to the view
				$this->set('_serialize', 'data');
				return $data;			
			}
			else if ($nbTicketsBuy<=0) {

				$data = array('error' => 'Please choose the number of tickets you want to buy.' );
				$this->set(compact('data')); // Pass $data to the view
				$this->set('_serialize', 'data');
				return $data;			
			}

			else{

				$superLottery = $this->SuperLottery->findById($superLotteryId);
				$buyer = $this->User->findById($userId);

				if ($superLottery['SuperLottery']['status'] != 'ongoing') {

					$data = array('error' => 'Invalid super Lottery !' );
					$this->set(compact('data')); // Pass $data to the view
					$this->set('_serialize', 'data');
					return $data;		
				}
				else if ($nbTicketsBuy>($superLottery['SuperLottery']['nb_tickets']-$superLottery['SuperLottery']['nb_ticket_bought'])) {
					$data = array('error' => 'There is not enough tickets to buy.' );
					$this->set(compact('data')); // Pass $data to the view
					$this->set('_serialize', 'data');
					return $data;
				}

				else if($buyer['User']['tokens'] < ($superLottery['SuperLottery']['ticket_value']*$nbTicketsBuy)){

					$data = array('error' => 'Not enough Points.' );
					$this->set(compact('data')); // Pass $data to the view
					$this->set('_serialize', 'data');
					return $data;

				}

				else{
					$this->loadModel('Message');

					$buyer['User']['tokens'] -= ($superLottery['SuperLottery']['ticket_value']*$nbTicketsBuy);

					$superLottery['SuperLottery']['nb_ticket_bought'] += $nbTicketsBuy;
					unset($superLottery['SuperLottery']['modified']);

					$superLotTicket = $this->SuperLotteryTicket->findBySuperLotteryIdAndBuyerUserId($superLottery['SuperLottery']['id'], $buyer['User']['id']);

					if(!isset($superLotTicket['SuperLotteryTicket'])){
						$this->SuperLotteryTicket->create();

						$superLotTicket = array('SuperLotteryTicket'=>array(
							'super_lottery_id' =>  $superLottery['SuperLottery']['id'],
							'buyer_user_id' =>$buyer['User']['id'],
							'nb_tickets' => $nbTicketsBuy,

							));
					}
					else{
						$superLotTicket['SuperLotteryTicket']['nb_tickets'] += $nbTicketsBuy;
					}

					if ($superLotTicket['SuperLotteryTicket']['nb_tickets']>($superLottery['SuperLottery']['nb_tickets']/10)) {
						$data = array('error' => 'You can\'t buy more than a tenth part of the tickets.' );
						$this->set(compact('data')); 
						$this->set('_serialize', 'data');
						return $data;
					}
					$dataSource = $this->SuperLotteryTicket->getDataSource();
					$dataSource->begin();
					if ($this->User->save($buyer, true, array('id', 'tokens')) && $this->SuperLottery->save($superLottery, true, array('id', 'nb_ticket_bought')) && $this->SuperLotteryTicket->save($superLotTicket)) {

						$this->log('Super Ticket Bought : user_name['.$buyer['User']['eve_name'].'], idSuperTickets['.$this->SuperLotteryTicket->id.'], superLottery['.$superLottery['SuperLottery']['id'].']', 'eve-lotteries');


						$this->_checkWinner($superLottery['SuperLottery']['id']);
						$dataSource->commit();

						$data = array('success' => 'You have bought super tickets.' );
						$this->set(compact('data')); 
						$this->set('_serialize', 'data');
						return $data;


					}
					else {
						$dataSource->rollback();
					}
				}
			}
		}
	}


	protected  function _checkWinner($lotteryId) {
		$this->loadModel('Statistic');
		$this->loadModel('SuperLottery');
		$this->loadModel('User');

		$this->SuperLottery->contain(array('SuperLotteryTicket', 'EveItem'));
		$superLottery = $this->SuperLottery->findById($lotteryId);

		

		if($superLottery['SuperLottery']['nb_ticket_bought'] == $superLottery['SuperLottery']['nb_tickets']){
			$winner = rand(1, $superLottery['SuperLottery']['nb_tickets']);
			$currentCount = 0;
			foreach ($superLottery['SuperLotteryTicket'] as $key => $ticketStack) {
				$currentCount += (int)$ticketStack['nb_tickets'];
				if($winner<=$currentCount){


					$superLottery['SuperLottery']['winner_user_id'] = $ticketStack['buyer_user_id'];
					$superLottery['SuperLottery']['status'] = 'unclaimed';
					unset($superLottery['SuperLottery']['modified']);

					$this->Statistic->saveStat($ticketStack['buyer_user_id'], 'win_super_lottery', $superLottery['SuperLottery']['id'], ($superLottery['EveItem']['eve_value']*$superLottery['SuperLottery']['number_items']), $superLottery['SuperLottery']['eve_item_id']);

					$this->log('Super Lottery won : lottery['.$superLottery['SuperLottery']['id'].'], user_id['.$ticketStack['buyer_user_id'].']', 'eve-lotteries');

					$winnerUser = $this->User->findById($ticketStack['buyer_user_id']);
					$winnerUser['User']['nb_new_won_super_lotteries']++;

					if ($this->User->save($winnerUser, true, array('id', 'nb_new_won_super_lotteries')) && $this->SuperLottery->save($superLottery, true, array('id', 'winner_user_id', 'status'))){
						
						$this->Message->sendSuperLotteryMessage(
							$ticketStack['buyer_user_id'], 
							'Super Lottery Won', 
							('You have win '.$superLottery['SuperLottery']['number_items'].' x '.$superLottery['EveItem']['name'].'. You can now claim your prize.'),
							$this->SuperLottery->id);

						$newSup = $this->SuperLottery->find('first', array(
							'conditions' => array('SuperLottery.status' => 'waiting'),
							'order' => array('SuperLottery.created' => 'asc'),
							));
						if(isset($newSup['SuperLottery']['id'])){
							$newSup['SuperLottery']['status'] = 'ongoing';
							$this->SuperLottery->save($newSup, true, array('id', 'status'));
						}
						break;
					}

				}
			}
		}


		// $winner = $this->SuperLottery->checkForWinner($lottery);


		// if ($winner >= 0) {


		// 	$this->loadModel('Withdrawal');

		// 	$lottery['Lottery']['lottery_status_id'] = 2;
		// 	$this->Lottery->save($lottery['Lottery']);

		// 	$this->Statistic->saveStat($userId, 'end_lottery', $lottery['Lottery']['id'], $lottery['Lottery']['value'], $lottery['Lottery']['eve_item_id']);

		// 	foreach ($lottery['Ticket'] as $id => $ticket) {

		// 		$proxyTicket = $ticket;

		// 		if($ticket['position'] == $winner){


		// 			$proxyTicket['is_winner'] = true;
		// 			$proxyTicket['status'] = 'unclaimed';

		// 			$this->Statistic->saveStat($ticket['buyer_user_id'], 'win_lottery', $lottery['Lottery']['id'], $lottery['Lottery']['value'], $lottery['Lottery']['eve_item_id']);

		// 			$this->log('Lottery won : lottery['.$lotteryId.'], user_id['.$ticket['buyer_user_id'].'], ticket['.$ticket['id'].']', 'eve-lotteries');

		// 			$this->Withdrawal->create();
		// 			$newWithdrawal = array('Withdrawal'=>array(
		// 				'type' =>'award',
		// 				'value' => '',
		// 				'status' =>'new',
		// 				'user_id' =>$ticket['buyer_user_id'],
		// 				'ticket_id' =>$ticket['id'],
		// 				));

		// 			$this->Withdrawal->save($newWithdrawal, true, array('type', 'value', 'status','user_id', 'ticket_id'));

		// 		}
		// 		else{
		// 			$proxyTicket['is_winner'] = false;
		// 		}

		// 		$this->Ticket->save($proxyTicket);
		// 	}
		// }
	}

}
