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
public $components = array('Paginator', 'Session');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$userGlobal = $this->Auth->user();

		$this->Transaction->recursive = -1;
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
	}

}
