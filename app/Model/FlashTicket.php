<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('FlashLottery', 'Model');
App::uses('Statistic', 'Model');

/**
 * Ticket Model
 *
 * @property Lottery $Lottery
 * @property User $User
 */
class FlashTicket extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'id';
    
    public $actsAs = array('Containable');
    
    public function userBuyOneTicket($userId, $flashTicketId) {

        //l'array qui contient le message à renvoyer
    	$data = Array();

        //chargement des models (ne pas les oublier dans le App:uses)
    	$userModel = new User();
    	$flashLotteryModel = new FlashLottery();
    	$statisticModel = new Statistic();

        //on trouve le bon ticket
    	$choosenFlashTicket = $this->findById($flashTicketId);

        //on trouve la lottery correspondante
    	$choosenFlashLottery = $flashLotteryModel->findById($choosenFlashTicket['FlashTicket']['flash_lottery_id']);

        //on trouve le bon acheteur
    	$buyer = $userModel->findById($userId);

        //on vérifie si le ticket n'a pas déjà été acheté
    	if ($choosenFlashTicket['FlashTicket']['buyer_user_id'] != null) {
    		$data = array('error' => 'Ticket already bought.');
    		return $data;
    	}

        //on vérifie si l'utilisateur possède assez d'argent
    	else if ($buyer['User']['tokens'] < 1) {
    		$data = array('error' => 'You need one point to buy a Flash Ticket.');
    		return $data;
    	}
    	//on vérifie que la lotterie soit toujours en cours
    	else if ($choosenFlashLottery['FlashLottery']['status'] != 'ongoing') {
    		$data = array('error' => 'Flash Lottery Closed.');
    		return $data;
    	}

        //verify if user already bought a ticket
        $existingTicket = $this->findByBuyerUserIdAndFlashLotteryId($userId, $choosenFlashTicket['FlashTicket']['flash_lottery_id']);
        if (!empty($existingTicket)) {
            $data = array('error' => 'You have already bought a ticket for this Flash Lottery !');
            return $data;
        }

        //on modifie le wallet et le nombre de tokens du joueur
    	$buyer['User']['tokens']--;

        //on ajoute au ticket l'ID de son acheteur
    	$choosenFlashTicket['FlashTicket']['buyer_user_id'] = $buyer['User']['id'];

        //on utilise une datasource pour éviter les erreurs en cas de rafraichissement pendant les requetes SQL
    	$dataSource = $this->getDataSource();
    	$dataSource->begin();

        //si la sauvegarde de user et save se passe bien
    	if ($userModel->save($buyer, true, array('id', 'tokens')) && $this->save($choosenFlashTicket)) {

            //ajout de la stat d'achat du ticket
    		$statisticModel->saveStat(
    			$buyer['User']['id'], 
    			'buy_flash_ticket',
    			$flashTicketId, 
    			1, 
    			$choosenFlashLottery['FlashLottery']['eve_item_id']);

    		$data = array('success' => true, 'message' => 'Ticket bought.', 'buyerEveId' => $buyer['User']['id'], 'buyerName' => $buyer['User']['eve_name']);

            //sauvegarde des logs
    		$this->log('FlashTicket bought : user_name[' . $buyer['User']['eve_name'] . '], id[' . $buyer['User']['id'] . '],flash  ticket[' . $flashTicketId . ']', 'eve-lotteries');
    		$this->log('User state : name[' . $buyer['User']['eve_name'] .  '], tokens[' . number_format($buyer['User']['tokens'], 2) . ']', 'eve-lotteries');

    		$dataSource->commit();

    		return $data;
    	} else {
    		$dataSource->rollback();
    		$data = array('error' => 'Error while processing.');
    		return $data;
    	}

    	return $data;
    }
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array('flash_lottery_id' => array('numeric' => array('rule' => array('numeric'),

    //'message' => 'Your custom message here',
    //'allowEmpty' => false,
    //'required' => false,
    //'last' => false, // Stop validation after this rule
    //'on' => 'create', // Limit validation to 'create' or 'update' operations
    	),));
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array('FlashLottery' => array('className' => 'FlashLottery', 'foreignKey' => 'flash_lottery_id', 'conditions' => '', 'fields' => '', 'order' => ''), 'Buyer' => array('className' => 'User', 'foreignKey' => 'buyer_user_id', 'conditions' => '', 'fields' => '', 'order' => ''));
}
