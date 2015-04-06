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
				$this->SuperLottery->end_super_lottery();

				$superLottery = $this->SuperLottery->findById($superLotteryId);

				$buyer = $this->User->findById($userId);

				if ($superLottery['SuperLottery']['status'] != 'ongoing') {

					$data = array('error' => 'Invalid super Lottery !' );
					$this->set(compact('data')); // Pass $data to the view
					$this->set('_serialize', 'data');
					return $data;		
				}

				else if ($superLottery['SuperLottery']['status'] != 'ongoing') {
					$data = array('error' => 'Super Lottery Closed.');
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

					$buyer['User']['tokens'] -= ($nbTicketsBuy);

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

					$dataSource = $this->SuperLotteryTicket->getDataSource();
					$dataSource->begin();
					if ($this->User->save($buyer, true, array('id', 'tokens')) && $this->SuperLottery->save($superLottery, true, array('id', 'nb_ticket_bought')) && $this->SuperLotteryTicket->save($superLotTicket)) {

						$this->log('Super Ticket Bought : user_name['.$buyer['User']['eve_name'].'], idSuperTickets['.$this->SuperLotteryTicket->id.'], superLottery['.$superLottery['SuperLottery']['id'].']', 'eve-lotteries');


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

}
