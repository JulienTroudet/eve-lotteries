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

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->loadModel('Withdrawal');

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
			'conditions' => array('Transaction.user_id' => $userGlobal['id'], 'Transaction.amount <=' => 0),
			'fields' => array('SUM(Transaction.amount) as totalAmount'),
			'group' => array('Transaction.user_id'),
			);
		$iskClaimValue = 0;
		$iskClaim = $this->Transaction->find('all', $params);
		if(isset($iskClaim[0][0]['totalAmount'])){
			$iskClaimValue = $iskClaim[0][0]['totalAmount'];
		}
		$this->set('totalClaimedIsk', $iskClaimValue);


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
	}
}
