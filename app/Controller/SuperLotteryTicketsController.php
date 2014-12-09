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
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function buy() {


		$userId = $this->Auth->user('id');

		if ($this->request->is('post')) {


			$dataProxy = $this->request->data;
			$nbTicketsBuy = $dataProxy['SuperLotteryTicket']['nb_tickets_buy'];
			$superLotteryId = $dataProxy['SuperLotteryTicket']['super_lottery_id'];

			

			if (!$this->SuperLottery->exists($superLotteryId)) {

				$this->Session->setFlash( 'The article has been saved.', 'FlashMessage', array('type' => 'error'));
				return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
			}
			else if (!$this->User->exists($userId)) {

				$this->Session->setFlash('You must log in to buy a ticket !', 'FlashMessage', array('type' => 'warning'));
				return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
			}
			else if ($nbTicketsBuy<=0) {
				$this->Session->setFlash('Please choose the number of tickets you want to buy.', 'FlashMessage', array('type' => 'info'));
				return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
			}
			
			else{

				$superLottery = $this->SuperLottery->findById($superLotteryId);
				$buyer = $this->User->findById($userId);

				if ($superLottery['SuperLottery']['lottery_status_id'] != 1) {

					$this->Session->setFlash('Invalid super Lottery !',	'FlashMessage',	array('type' => 'error'));
					return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
				}
				else if ($nbTicketsBuy>($superLottery['SuperLottery']['nb_tickets']-$superLottery['SuperLottery']['nb_ticket_bought'])) {
					$this->Session->setFlash('There is not enough tickets to buy.', 'FlashMessage', array('type' => 'info'));
					return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
				}
				else if($buyer['User']['tokens'] < ($superLottery['SuperLottery']['ticket_value']*$nbTicketsBuy)){

					$this->Session->setFlash('Not enough Points.', 'FlashMessage', array('type' => 'warning'));
					return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
				}
				else{

					$buyer['User']['tokens'] -= ($superLottery['SuperLottery']['ticket_value']*$nbTicketsBuy);

					$superLottery['SuperLottery']['nb_ticket_bought'] += $nbTicketsBuy;

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
					
					if ($this->User->save($buyer, true, array('id', 'tokens')) && $this->SuperLottery->save($superLottery, true, array('id', 'nb_ticket_bought')) && $this->SuperLotteryTicket->save($superLotTicket)) {

						$this->log('Super Ticket Buyed : user_name['.$buyer['User']['eve_name'].'], idSuperTickets['.$this->SuperLotteryTicket->id.'], superLottery['.$superLottery['SuperLottery']['id'].']', 'eve-lotteries');

						$this->Session->setFlash('You have bought '.$nbTicketsBuy.' Super tickets !', 'FlashMessage', array('type' => 'success'));

						$this->_checkWinner($superLottery['SuperLottery']['id'], $buyer['User']['id']);

						return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
					}

					debug($buyer);
					die();

				}



				
			}
		}
	}


	protected  function _checkWinner($lotteryId, $userId) {
		$this->loadModel('Statistic');
		$this->loadModel('SuperLottery');

		$this->SuperLottery->contain(array('SuperLotteryTicket'));
		$superLottery = $this->SuperLottery->findById($lotteryId);

		if($superLottery['SuperLottery']['nb_ticket_bought'] == $superLottery['SuperLottery']['nb_tickets']){
			$winner = rand(1, $superLottery['SuperLottery']['nb_tickets']);
			$currentCount = 0;
			foreach ($superLottery['SuperLotteryTicket'] as $key => $ticketStack) {
				$currentCount += (int)$ticketStack['nb_tickets'];
				if($winner<=$currentCount){

					$superLottery['SuperLottery']['winner_user_id'] = $ticketStack['buyer_user_id'];
					$superLottery['SuperLottery']['lottery_status_id'] = 4;

					if ($this->SuperLottery->save($superLottery, true, array('id', 'winner_user_id', 'lottery_status_id'))){
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
