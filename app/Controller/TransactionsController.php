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
public $components = array('Paginator', 'Session', 'RequestHandler');

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
	public function index() {
		$this->loadModel('Withdrawal');
		$this->loadModel('Statistic');

		$userGlobal = $this->Auth->user();

		$paginateVar = array(
			'conditions' => array('Transaction.user_id' => $userGlobal['id']),
			'order' => array(
				'Transaction.created' => 'desc'
				),
			'limit' => 10
			);
		$this->Paginator->settings = $paginateVar;

		$this->set('transactions', $this->Paginator->paginate());

		$db = $this->Transaction->getDataSource();
		
		
		$totalDeposit = $db->fetchAll(
			'SELECT SUM(amount) from transactions where user_id = ? AND amount >= 0 GROUP BY user_id',
			array($userGlobal['id'])
			);
		$total = 0;
		if (isset($totalDeposit[0][0]['SUM(amount)'])) {
			$total = $totalDeposit[0][0]['SUM(amount)'];
		}
		$this->set('totalDeposit', $total);

		
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
		$this->log($totalWaitingWithdrawals);
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
		$totalIskClaimed = $db->fetchAll('SELECT SUM(isk_value) as amount from statistics where user_id = ? AND (type = "withdrawal_isk" OR type = "withdrawal_item") GROUP BY user_id', array($userGlobal['id']));
		$total = 0;
		if (isset($totalIskClaimed[0][0]['amount'])) {
			$total = $totalIskClaimed[0][0]['amount'];
		}
		$this->set('totalClaimedIsk', $total);

		//vas chercher tous les crédits réclamés par le joueur
		$totalCreditsClaimed = $db->fetchAll('SELECT SUM(isk_value) as amount from statistics where user_id = ? AND (type = "withdrawal_credits") GROUP BY user_id', array($userGlobal['id']));
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

		//vas chercher le nombre de lotteries gagnées par le joueur
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
}
