<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TransactionsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler', 'WalletParser');
	public $helpers = array('Js');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('');

		if (!$this->Auth->loggedIn()) {
			$this->Session->setFlash('Please Log in !', 'FlashMessage', array('type' => 'warning'));
			return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
		}
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->loadModel('Withdrawal');
		$nbWithdrawalClaimed = $this->Withdrawal->find('count', array('conditions'=>array('Withdrawal.status'=>'claimed')));
		$this->set('nbWithdrawalClaimed', $nbWithdrawalClaimed);

		$this->loadModel('SuperLottery');
		$nbSuperClaimed = $this->SuperLottery->find('count', array('conditions'=>array('SuperLottery.status'=>'claimed')));
		$this->set('nbSuperClaimed', $nbSuperClaimed);

		$this->loadModel('FlashLottery');
		$nbFlashClaimed = $this->FlashLottery->find('count', array('conditions'=>array('FlashLottery.status'=>'claimed')));
		$this->set('nbFlashClaimed', $nbFlashClaimed);
		
		$this->Transaction->recursive = 0;
		$paginateVar = array(
			'contain' => array('User'),
			'order' => array(
				'Transaction.created' => 'desc'
				),
			'limit' => 20
			);
		$this->Paginator->settings = $paginateVar;
		$this->set('transactions', $this->Paginator->paginate());
	}

    /**
     * index method
     *
     * @return void
     */
    public function banking() {


        $this->Transaction->recursive = 0;
        $paginateVar = array(
            'contain' => array('User'),
            'order' => array(
                'Transaction.created' => 'desc'
            ),
            'limit' => 20
        );
        $this->Paginator->settings = $paginateVar;
        $this->set('transactions', $this->Paginator->paginate());
    }



	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {

		if ($this->request->is('post')) {

			$this->Transaction->create();
			$dataProxy = $this->request->data;

			$deposit = $this->WalletParser->parseOneDeposit($dataProxy['Transaction']['walletLine']);

			if(!$deposit) {

				$this->Session->setFlash(
					'The transaction could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
				return $this->redirect(array('action' => 'banking', 'admin' => false));
			}

			//request the transaction to see if is it not already added
			$params = array(
				'contain' => array(
					'User' => array (
						'conditions' => array('User.eve_name' => $deposit['userName'])
						)
					),
				'conditions' => array(
					'Transaction.amount' => $deposit['amount'], 
					'Transaction.eve_date' => $deposit['date']
					),
				'limit' => 1
				);
			$existingTransaction = $this->Transaction->find('first', $params);

			if(empty($existingTransaction)){

				//gets the user
				$this->loadModel('User');
				$donatorUser = $this->User->findByEveName($deposit['userName']);

				if(!is_float ($deposit['amount'])){
					$this->Session->setFlash(
						'You must provide Decimal values !',
						'FlashMessage',
						array('type' => 'error')
						);
					return $this->redirect(array('action' => 'banking', 'admin' => false));
				}
				if(empty($donatorUser)){
					$this->Session->setFlash(
						'This user does not exists',
						'FlashMessage',
						array('type' => 'error')
						);
					return $this->redirect(array('action' => 'banking', 'admin' => false));
				}

				//new object transaction
				$newTransaction=array();
				$newTransaction['Transaction']['refid'] = 'waiting';
				$newTransaction['Transaction']['amount'] = $deposit['amount'];
				$newTransaction['Transaction']['user_id'] = $donatorUser['User']['id'];
				$newTransaction['Transaction']['eve_date'] = $deposit['date'];

				
				//try to save the transaction
				if ($this->Transaction->save($newTransaction)) {

					//adds ISK if the transaction is saved
					$this->User->updateWallet($newTransaction['Transaction']['user_id'], $newTransaction['Transaction']['amount']);

					$this->Session->setFlash(
						'The transaction has been saved.',
						'FlashMessage',
						array('type' => 'success')
						);

					return $this->redirect(array('action' => 'banking', 'admin' => false));

				} else {

					$this->Session->setFlash(
						'The transaction could not be saved. Please, try again.',
						'FlashMessage',
						array('type' => 'error')
						);
					return $this->redirect(array('action' => 'banking', 'admin' => false));
				}
			}
			else{
				$this->Session->setFlash(
					'The transaction already exists.',
					'FlashMessage',
					array('type' => 'error')
					);
				return $this->redirect(array('action' => 'banking', 'admin' => false));
			}

			return $this->redirect(array('action' => 'banking', 'admin' => false));
			
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->loadModel('User');
		
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->allowMethod('post', 'delete');

		$transac = $this->Transaction->findById($id);

		$this->User->updateWallet($transac['Transaction']['user_id'], -$transac['Transaction']['amount']);
		
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(
				'The transaction has been deleted.',
				'FlashMessage',
				array('type' => 'success')
				);
		} else {
			$this->Session->setFlash(
				'The transaction could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->loadModel('Withdrawal');
		$this->loadModel('Statistic');

		$userGlobal = $this->Auth->user();

		//vas chercher la liste des transactions
		$paginateVar = array(
			'conditions' => array('Transaction.user_id' => $userGlobal['id']),
			'order' => array(
				'Transaction.created' => 'desc'
				),
			'limit' => 15
			);
		$this->Paginator->settings = $paginateVar;
		$this->set('transactions', $this->Paginator->paginate());

		$paginateVar = array(
			'model' => 'Statistic',
			'conditions' => array('AND' =>array('Statistic.user_id' => $userGlobal['id'], 'Statistic.type' => array('buy_ticket', 'withdrawal_credits', 'sponsor_isk'))),
			'order' => array(
				'Statistic.created' => 'desc'
				),
			'limit' => 15
			);
		$this->Paginator->settings = $paginateVar;
		$this->set('player_stats', $this->Paginator->paginate('Statistic'));

		$db = $this->Transaction->getDataSource();
		
		//fait la somme des transactions négatives pour obtenir le total de dépots
		$totalDeposit = $db->fetchAll(
			'SELECT SUM(amount) from transactions where user_id = ? AND amount >= 0 GROUP BY user_id',
			array($userGlobal['id'])
			);
		$total = 0;
		if (isset($totalDeposit[0][0]['SUM(amount)'])) {
			$total = $totalDeposit[0][0]['SUM(amount)'];
		}
		$this->set('totalDeposit', $total);

		//faits la somme des transactions positives pour obtenir le total des gains
		$totalWithdrawals = $db->fetchAll(
			'SELECT SUM(amount) from transactions where user_id = ? AND amount < 0 GROUP BY user_id',
			array($userGlobal['id'])
			);
		$totalW = 0;
		if (isset($totalWithdrawals[0][0]['SUM(amount)'])) {
			$totalW = $totalWithdrawals[0][0]['SUM(amount)'];
		}
		$this->set('totalWithdrawals', $totalW);


		$params = array(
			'conditions' => array('Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => 'award_isk', 'Withdrawal.status' => 'claimed'),
			'fields' => array('SUM(Withdrawal.value) as totalAmount'),
			'group' => array('Withdrawal.user_id'),
			);
		$totalWaitingWithdrawals = 0;
		$waitingWithdrawals = $this->Withdrawal->find('all', $params);
		if(isset($waitingWithdrawals[0][0]['totalAmount'])){
			$totalWaitingWithdrawals = $waitingWithdrawals[0][0]['totalAmount'];
		}
		$this->set('waitingWithdrawals', $totalWaitingWithdrawals);





		//vas chercher tous les isk déposés par le joueur
		$totalDeposit = $db->fetchAll('SELECT SUM(amount) as amount from transactions where user_id = ? AND amount >= 0 GROUP BY user_id', array($userGlobal['id']));
		$total = 0;
		if (isset($totalDeposit[0][0]['amount'])) {
			$total = $totalDeposit[0][0]['amount'];
		}
		$this->set('totalDeposit', $total);

		//vas chercher tous les isk joués par le joueur
		$totalPlayed = $db->fetchAll('SELECT SUM(isk_value) as amount from statistics where user_id = ? AND type = "buy_ticket" GROUP BY user_id', array($userGlobal['id']));
		$total = 0;
		if (isset($totalPlayed[0][0]['amount'])) {
			$total = $totalPlayed[0][0]['amount'];
		}
		$this->set('totalPlayed', $total);

		//vas chercher tous les isk réclamés par le joueur
		$totalIskClaimed = $db->fetchAll('SELECT SUM(isk_value) as amount from statistics where user_id = ? AND (type = "withdrawal_isk" OR type = "withdrawal_item" OR type = "super_withdrawal_isk" OR type = "super_withdrawal_item") GROUP BY user_id', array($userGlobal['id']));
		$total = 0;
		if (isset($totalIskClaimed[0][0]['amount'])) {
			$total = $totalIskClaimed[0][0]['amount'];
		}
		$this->set('totalClaimedIsk', $total);

		//vas chercher tous les crédits réclamés par le joueur
		$totalCreditsClaimed = $db->fetchAll('SELECT SUM(isk_value) as amount from statistics where user_id = ? AND (type = "withdrawal_credits" OR type = "super_withdrawal_credit") GROUP BY user_id', array($userGlobal['id']));
		$total = 0;
		if (isset($totalCreditsClaimed[0][0]['amount'])) {
			$total = $totalCreditsClaimed[0][0]['amount'];
		}
		$this->set('totalCreditsClaimed', $total);

		//vas chercher le nombre de lotteries jouées par le joueur
		$totalLotteriesPlayed = $db->fetchAll('SELECT COUNT(*) as nb_lot FROM (SELECT COUNT(*) from statistics INNER JOIN tickets on statistics.value=tickets.id where user_id = ? AND (type = "buy_ticket") GROUP BY tickets.lottery_id, statistics.user_id ) er', array($userGlobal['id']));
		$total = 0;
		if (isset($totalLotteriesPlayed[0][0]['nb_lot'])) {
			$total = $totalLotteriesPlayed[0][0]['nb_lot'];
		}
		$this->set('totalLotteriesPlayed', $total);

		//vas chercher le nombre de lotteries gagnées par le joueur
		$totalLotteriesWon = $db->fetchAll('SELECT COUNT(*) as nb_lot_win FROM statistics where user_id = ? AND type = "win_lottery"', array($userGlobal['id']));
		$total = 0;
		if (isset($totalLotteriesWon[0][0]['nb_lot_win'])) {
			$total = $totalLotteriesWon[0][0]['nb_lot_win'];
		}
		$this->set('totalLotteriesWon', $total);

		//vas chercher le nombre de super lotteries jouées par le joueur
		$totalSuperLotteriesPlayed = $db->fetchAll('SELECT COUNT(*) AS nb_sup_lot FROM super_lottery_tickets WHERE buyer_user_id = ?', array($userGlobal['id']));
		$total = 0;
		if (isset($totalSuperLotteriesPlayed[0][0]['nb_sup_lot'])) {
			$total = $totalSuperLotteriesPlayed[0][0]['nb_sup_lot'];
		}
		$this->set('totalSuperLotteriesPlayed', $total);

		//vas chercher le nombre de super lotteries gagnées par le joueur
		$totalSuperLotteriesWon = $db->fetchAll('SELECT COUNT(*) as nb_lot_win FROM statistics where user_id = ? AND type = "win_super_lottery"', array($userGlobal['id']));
		$total = 0;
		if (isset($totalSuperLotteriesWon[0][0]['nb_lot_win'])) {
			$total = $totalSuperLotteriesWon[0][0]['nb_lot_win'];
		}
		$this->set('totalSuperLotteriesWon', $total);
		
		//nombre de lotteries jouées 
		//nombre de super lotteries jouées
		//nombre de super lotteries gagnées (+pourcentage)
		//nombre de lotteries gagnées (+pourcentage)
	}

	public function list_transactions() {
		$this->request->onlyAllow('ajax');

		$userGlobal = $this->Auth->user();

		//vas chercher la liste des transactions
		$paginateVar = array(
			'update' => '#in-game-pane',
			'evalScripts' => true, 
			'conditions' => array('Transaction.user_id' => $userGlobal['id']),
			'order' => array(
				'Transaction.created' => 'desc'
				),
			'limit' => 15
			);
		$this->Paginator->settings = $paginateVar;
		$this->set('transactions', $this->Paginator->paginate());

		if ($this->request->is('ajax')) {
			
			$this->render('table', 'ajax'); // View, Layout
		}
	}
}
