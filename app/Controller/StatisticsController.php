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

		$popularsItems = $db->fetchAll("SELECT eve_items.eve_id, eve_items.name, eve_categories.url_start, stat.totalItems 
										FROM eve_items 
										INNER JOIN eve_categories ON eve_categories.id = eve_items.eve_category_id 
										INNER JOIN ( SELECT COUNT(*) AS totalItems, eve_item_id FROM statistics  WHERE type = 'win_lottery' GROUP BY eve_item_id) stat ON stat.eve_item_id = eve_items.id ORDER BY totalItems DESC LIMIT 10");
		$this->set('popularsItems', $popularsItems);
	}

	public function list_stats() {
		$this->request->onlyAllow('ajax');

		$userGlobal = $this->Auth->user();

		//vas chercher la liste des transactions
		$paginateVar = array(
			'update' => '#el-tansaction-pane',
			'evalScripts' => true, 
			'conditions' => array('AND' =>array('Statistic.user_id' => $userGlobal['id'], 'Statistic.type' => array('buy_ticket', 'withdrawal_credits', 'sponsor_isk'))),
			'order' => array(
				'Statistic.created' => 'desc'
				),
			'limit' => 15
			);
		$this->Paginator->settings = $paginateVar;
		$this->set('player_stats', $this->Paginator->paginate());

		if ($this->request->is('ajax')) {
			
			$this->render('table', 'ajax'); // View, Layout
		}
	}

	public function admin_index() {


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

		$totalDeposited = $db->fetchAll("SELECT SUM(statistics.isk_value) as total FROM statistics  WHERE type='deposit_isk'");
		$this->set('totalDeposited', $totalDeposited[0][0]['total']);

		$totalWallets = $db->fetchAll("SELECT SUM(users.wallet) as total FROM users  WHERE users.id != 94931126 AND users.group_id != 3");
		$this->set('totalWallets', $totalWallets[0][0]['total']);

		$totalUnclaimed = $db->fetchAll("SELECT SUM(lotteries.value) as total FROM withdrawals INNER JOIN tickets ON withdrawals.ticket_id = tickets.id INNER JOIN lotteries ON tickets.lottery_id = lotteries.id WHERE withdrawals.status='new'");
		$this->set('totalUnclaimed', $totalUnclaimed[0][0]['total']);

		$totalClaimed = $db->fetchAll("SELECT SUM(lotteries.value) as total FROM withdrawals INNER JOIN tickets ON withdrawals.ticket_id = tickets.id INNER JOIN lotteries ON tickets.lottery_id = lotteries.id WHERE withdrawals.status='claimed'");
		$this->set('totalClaimed', $totalClaimed[0][0]['total']);

		$totalClaimed = $db->fetchAll("SELECT SUM(lotteries.value) as total FROM withdrawals INNER JOIN tickets ON withdrawals.ticket_id = tickets.id INNER JOIN lotteries ON tickets.lottery_id = lotteries.id WHERE withdrawals.status='claimed'");
		$this->set('totalClaimed', $totalClaimed[0][0]['total']);

		$totalInPlay = $db->fetchAll("SELECT SUM(lotteries.value) as total FROM lotteries WHERE lotteries.lottery_status_id='1'");
		$this->set('totalInPlay', $totalInPlay[0][0]['total']);

		$totalInPlaySuper = $db->fetchAll("SELECT (eve_items.eve_value*super_lotteries.number_items) as total FROM super_lotteries INNER JOIN eve_items ON eve_items.id = super_lotteries.eve_item_id WHERE super_lotteries.status='ongoing'");
		if(isset($totalInPlaySuper[0][0]['total'])){
			$this->set('totalInPlaySuper', $totalInPlaySuper[0][0]['total']);
		}
		else{
			$this->set('totalInPlaySuper', '0');
		}
		// debug($totalDeposited);
		// die();
		// $usersLotWon = $db->fetchAll("SELECT users.id, users.eve_name, stat.totalWon FROM users INNER JOIN ( SELECT COUNT(*) AS totalWon, user_id FROM statistics  WHERE type = 'win_lottery' GROUP BY user_id) stat ON stat.user_id = id ORDER BY totalWon DESC LIMIT 10");
		// $this->set('usersLotWon', $usersLotWon);

		// $popularsItems = $db->fetchAll("SELECT eve_items.eve_id, eve_items.name, stat.totalItems FROM eve_items INNER JOIN ( SELECT COUNT(*) AS totalItems, eve_item_id FROM statistics  WHERE type = 'win_lottery' GROUP BY eve_item_id) stat ON stat.eve_item_id = id ORDER BY totalItems DESC LIMIT 10");
		// $this->set('popularsItems', $popularsItems);
	}

	public function admin_thanks_player($id_player) {

		$this->Statistic->saveStat($id_player, 'help_bug', null, null, null);

		$this->Session->setFlash(
				'The user has been thanked.',
				'FlashMessage',
				array('type' => 'info')
				);

		$this->redirect(array('controller' => 'users', 'action' => 'view', 'admin' => true, $id_player));
	}
}
