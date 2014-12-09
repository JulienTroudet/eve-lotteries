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

		// $totalClaimedIsk = 0;
		// $params = array(
		// 	'conditions' => array('Withdrawal.user_id' => $userGlobal['id'], 'status' =>'claimed','type' =>'witdrawal'),
		// 	);
		// $iskClaim = $this->Withdrawal->find('first', $params);
		// if(isset($iskClaim['Withdrawal'])){
		// 	$totalClaimedIsk = $iskClaim['Withdrawal']['value'];
		// }

		// $this->set('totalClaimedIsk', $totalClaimedIsk);


	}
}
