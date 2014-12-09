<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class StatisticsController extends AppController {

/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator', 'Session', 'RequestHandler');

public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('index');

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
		$this->loadModel('User');
		$params = array(
			'conditions' => array('Statistic.type' => 'buy_ticket'),
			'fields' => array('SUM(Statistic.isk_value) as totalAmount'),
			'group' => array('Statistic.type'),
			);
		$total = $this->Statistic->find('first', $params);
		$this->set('totalPlayed', $total[0]['totalAmount']);


		$db = $this->Statistic->getDataSource();
		
		$usersIsk = $db->fetchAll("SELECT users.id, users.eve_name, stat.totalIskAmount FROM users INNER JOIN ( SELECT user_id, SUM(isk_value) AS totalIskAmount FROM statistics  WHERE type = 'withdrawal_isk' GROUP BY user_id) stat ON stat.user_id = id ORDER BY totalIskAmount DESC LIMIT 10");
		$this->set('usersIsk', $usersIsk);

		$usersLotWon = $db->fetchAll("SELECT users.id, users.eve_name, stat.totalWon FROM users INNER JOIN ( SELECT COUNT(*) AS totalWon, user_id FROM statistics  WHERE type = 'win_lottery' GROUP BY user_id) stat ON stat.user_id = id ORDER BY totalWon DESC LIMIT 10");
		$this->set('usersLotWon', $usersLotWon);

		$usersItems = $db->fetchAll("SELECT users.id, users.eve_name, stat.totalItems FROM users INNER JOIN ( SELECT COUNT(*) AS totalItems, user_id FROM statistics  WHERE type = 'withdrawal_item' GROUP BY user_id) stat ON stat.user_id = id ORDER BY totalItems DESC LIMIT 10");
		$this->set('usersItems', $usersItems);
	}
}
