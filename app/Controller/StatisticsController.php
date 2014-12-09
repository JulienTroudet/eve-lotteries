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


		//vas chercher le total gagné
		$params = array(
			'conditions' => array('OR'=>array(array('Statistic.type' => 'win_super_lottery'), array('Statistic.type' => 'win_lottery'))),
			'fields' => array('SUM(Statistic.isk_value) as totalAmount'),
			);
		$total = $this->Statistic->find('first', $params);
		if(isset($total[0])){
			$this->set('totalWon', $total[0]['totalAmount']);
		}
		else{
			$this->set('totalWon', 0);
		}

		$db = $this->Statistic->getDataSource();
		
		$usersIsk = $db->fetchAll("SELECT users.id, users.eve_name, stat.totalIskAmount FROM users INNER JOIN ( SELECT user_id, SUM(isk_value) AS totalIskAmount FROM statistics  WHERE type = 'win_super_lottery' OR type = 'win_lottery' GROUP BY user_id) stat ON stat.user_id = id ORDER BY totalIskAmount DESC LIMIT 10");
		$this->set('usersIsk', $usersIsk);

		$usersLotWon = $db->fetchAll("SELECT users.id, users.eve_name, stat.totalWon FROM users INNER JOIN ( SELECT COUNT(*) AS totalWon, user_id FROM statistics  WHERE type = 'win_lottery' GROUP BY user_id) stat ON stat.user_id = id ORDER BY totalWon DESC LIMIT 10");
		$this->set('usersLotWon', $usersLotWon);

		$popularsItems = $db->fetchAll("SELECT eve_items.eve_id, eve_items.name, stat.totalItems FROM eve_items INNER JOIN ( SELECT COUNT(*) AS totalItems, eve_item_id FROM statistics  WHERE type = 'win_lottery' GROUP BY eve_item_id) stat ON stat.eve_item_id = id ORDER BY totalItems DESC LIMIT 10");
		$this->set('popularsItems', $popularsItems);
	}
}
