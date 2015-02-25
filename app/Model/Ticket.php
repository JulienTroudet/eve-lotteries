<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Lottery', 'Model');
App::uses('Statistic', 'Model');
/**
 * Ticket Model
 *
 * @property Lottery $Lottery
 * @property User $User
 */
class Ticket extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'position';

	public $actsAs = array('Containable');



	public function userBuyOneTicket($userId, $ticketId) {

		//l'array qui contient le message à renvoyer
		$data = Array();

		//chargement des models (ne pas les oublier dans le App:uses)
		$userModel = new User();
		$lotteryModel = new Lottery();
		$statisticModel = new Statistic();

		//on trouve le bon ticket
		$choosenTicket = $this->findById($ticketId);
		//on trouve la lottery correspondante
		$choosenLottery = $lotteryModel->findById($choosenTicket['Ticket']['lottery_id']);
		//on trouve le bon acheteur
		$buyer = $userModel->findById($userId, array('User.id', 'User.eve_name', 'User.wallet', 'User.tokens'));
		//on vérifie si le ticket n'a pas déjà été acheté
		if($choosenTicket['Ticket']['buyer_user_id'] != null){
			$data = array('error' => 'Ticket already bought.');
			return $data;
		}
		//on vérifie si l'utilisateur possède assez d'argent
		else if($buyer['User']['wallet'] < $choosenTicket['Ticket']['value']){
			$data = array('error' => 'Not enough Credits.');
			return $data;
		}

		//on modifie le wallet et le nombre de tokens du joueur
		$buyer['User']['wallet'] -= $choosenTicket['Ticket']['value'];
		$buyer['User']['tokens'] += $choosenTicket['Ticket']['value']/10000000;

		//on ajoute au ticket l'ID de son acheteur
		$choosenTicket['Ticket']['buyer_user_id'] = $buyer['User']['id'];

		//on utilise une datasource pour éviter les erreurs en cas de rafraichissement pendant les requetes SQL
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		//si la sauvegarde de user et save se passe bien
		if ($userModel->save($buyer, true, array('id', 'wallet', 'tokens')) && $this->save($choosenTicket)) {

			//ajout de la stat d'achat du ticket
			$statisticModel->saveStat($buyer['User']['id'], 'buy_ticket', $ticketId, $choosenTicket['Ticket']['value'], $choosenLottery['Lottery']['eve_item_id']);

			$data = array (
				'success' => true,
				'message' => 'Ticket bought.',
				'buyerEveId' => $buyer['User']['id'],
				'buyerName' => $buyer['User']['eve_name'],
				'buyerWallet' => number_format($buyer['User']['wallet'], 2)
				);

			//sauvegarde des logs
			$this->log('Ticket bought : user_name['.$buyer['User']['eve_name'].'], id['.$buyer['User']['id'].'], ticket['.$ticketId.']', 'eve-lotteries');
			$this->log('User state : name['.$buyer['User']['eve_name'].'], wallet['.number_format($buyer['User']['wallet'], 2).'], tokens['.number_format($buyer['User']['tokens'], 2).']', 'eve-lotteries');
			
			$lotteryModel->checkForWinner($choosenTicket['Ticket']['lottery_id'], $choosenTicket['Ticket']['id']);

			$dataSource->commit();

			return $data;
		}
		else {
			$dataSource->rollback();
			$data = array('error' => 'Error while processing.');
			return $data;
		}
		// $this->create();
		// $statData = array(
		// 	'user_id' => $user_id,
		// 	'status' => 'unread',
		// 	'title' => $title,
		// 	'body' => $body,
		// 	'controller_name' => $controller_name,
		// 	'action_name' => $action_name,
		// 	);

		// $this->incrementMessageCount($user_id);

		// return $this->save($statData, true, array('user_id', 'status', 'title', 'body', 'controller_name', 'action_name'));
		return $data;
	}



	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'lottery_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'position' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		'value' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);


	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Lottery' => array(
			'className' => 'Lottery',
			'foreignKey' => 'lottery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'buyer_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			)
		);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Withdrawal' => array(
			'className' => 'withdrawal',
			'foreignKey' => 'ticket_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
			)
		);
}
