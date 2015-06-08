<?php
App::uses('AppController', 'Controller');
/**
* Lotteries Controller
*
* @property Lottery $Lottery
* @property PaginatorComponent $Paginator
* @property SessionComponent $Session
*/
class LotteriesController extends AppController {
	/**
	* Components
	*
	* @var array
	*/
	public $components = array('Paginator', 'Session', 'RequestHandler');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'index_open', 'old_list', 'list_lotteries', 'list_special_lotteries');
	}
	/**
	* index method
	*
	* @return void
	*/
	public function index() {

		//check if the items panel must be open
		$create = $this->Session->read('Index.open');
		if($create == "open"){
			$this->set('openCreate', $create);
			$this->Session->write('Index.open', "closed");
		}

		$this->loadModel('EveItem');
		$this->loadModel('EveCategory');
        $this->loadModel('FlashLottery');
		$this->loadModel('SuperLottery');
		$this->loadModel('Statistic');
		$this->loadModel('Article');


		//vas chercher le total gagné
		//
		$this->set('totalWon', $this->_get_total_won());
		
		//vas chercher les lotteries actuelles
		$params = array(
			'contain' => array(
				'EveItem' => array('EveCategory'),
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '1'),
			'order' => array('Lottery.id desc'),
			'limit' => 10
			);
		$lotteries = $this->Lottery->find('all', $params);
		foreach ($lotteries as $key => $lottery) {
			$allBought = $this->Lottery->areAllTicketBought($lottery);
			if($allBought){
				$this->Lottery->checkForWinner($lottery['Lottery']['id']);
			}
		}
		$orderedLot = $this->_order_lotteries($lotteries);
		$this->set('lotteries', $orderedLot);

		//vas chercher les anciennes lotteries
		$paginateVar = array(
			'contain' => array(
				'EveItem' => array('EveCategory'),
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '2'),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => 6
			);
		$this->Paginator->settings = $paginateVar;
		$oldLotteries = $this->Paginator->paginate('Lottery');
		$this->set('old_lotteries', $oldLotteries);
		

		//vas chercher la liste des catégories d'item
		$params = array(
			'cache' => 'eveCategories', 
			'cacheConfig' => 'short',
			'conditions' => array('EveCategory.status' => '1'),
			'order' => array('EveCategory.name ASC'),
			'fields' => array('EveCategory.id', 'EveCategory.name'),
			);
		$eveCategories = $this->EveCategory->find('list', $params);
		$this->set('eveCategories', $eveCategories);

		//vas chercher la liste des items
		$params = array(
			'cache' => 'eveItems', 
			'cacheConfig' => 'short',
			'contain' => 'EveCategory',
			'conditions' => array('EveItem.status' => '1', 'EveCategory.status' => '1'),
			'order' => array('EveItem.name ASC'),
			);
		$eveItems = $this->EveItem->find('all', $params);
		foreach ($eveItems as $key => $value) {
			$eveItems[$key]['EveItem']['ticket_price'] = $this->EveItem->getTicketPrice($value);
		}
		$this->set('eveItems', $eveItems);


		//get the last super lottery
		$superLottery = $this->_get_last_super_lottery();
		$this->set('superLottery', $superLottery);
		//get the last flash lottery
		$flashLottery = $this->_get_last_flash_lottery();
		$this->set('flashLottery', $flashLottery);
		//get the last article
		$params = array(
			'conditions' => array('Article.modified >= now() - INTERVAL 1 DAY'),
			'order' => array('Article.created DESC')
			);
		$article = $this->Article->find('first', $params);
		$this->set('article', $article);

		$this->loadModel('Config');
		$this->set('timestamp_lotteries', $this->Config->getLotteriesTimestamp());
		$this->set('timestamp_super_lotteries', $this->Config->getSuperLotteriesTimestamp());
		$this->set('timestamp_flash_lotteries', $this->Config->getFlashLotteriesTimestamp());
	}
	public function index_open() {
		$this->Session->write('Index.open', "open");
		$this->redirect(array("action" => "index"));
	}
	/**
	* index method
	*
	* @return void
	*/
	public function list_lotteries() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {
			$this->loadModel('Config');

			$timestamp_lotteries = $this->request->query('timestamp');

			//chek if the lotteries have changed
			if($this->Config->hasLotteriesChanged($timestamp_lotteries)){
				$this->loadModel('Statistic');
				//vas chercher le total gagné
				
				$this->set('totalWon', $this->_get_total_won());

				$this->layout = false;

				$params = array(
					'contain' => array(
						'EveItem' => array('EveCategory'),
						'Ticket' => array(
							'User' => array('id', 'eve_name')
							)
						),
					'conditions' => array('Lottery.lottery_status_id' => '1'),
					'order' => array('Lottery.id desc'),
					);

				$lotteries = $this->Lottery->find('all', $params);
				$orderedLot = $this->_order_lotteries($lotteries);
				$this->set('lotteries', $orderedLot);
				$paginateVar = array(
					'contain' => array(
						'EveItem' => array('EveCategory'),
						'Ticket' => array(
							'User' => array('id', 'eve_name')
							)
						),
					'conditions' => array('Lottery.lottery_status_id' => '2'),
					'order' => array(
						'Lottery.modified' => 'desc'
						),
					'limit' => 6
					);
				$this->Paginator->settings = $paginateVar;
				$oldLotteries = $this->Paginator->paginate('Lottery');
				$this->set('old_lotteries', $oldLotteries);

				$this->set('timestamp_lotteries', $this->Config->getLotteriesTimestamp());

			}
			else{
				$this->autoRender = false;
				return "";
			}
		}
		
	}

	/**
	 * gets the special lotteries list for refreshing
	 * @return [type] [description]
	 */
	public function list_special_lotteries() {
		$this->loadModel('SuperLottery');
		$this->loadModel('SuperLotteryTicket');
		$this->loadModel('FlashLottery');

		//get the last super lottery
		$superLottery = $this->_get_last_super_lottery();
		$this->set('superLottery', $superLottery);
		//get the last flash lottery
		$flashLottery = $this->_get_last_flash_lottery();
		$this->set('flashLottery', $flashLottery);
		
	}

	/**
	* index method
	*
	* @return void
	*/
	public function admin_index() {
		$this->Lottery->recursive = 1;
		$this->set('lotteries', $this->Paginator->paginate());
	}
	/**
	* view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function admin_view() {
		$this->Lottery->recursive = 1;
		if (!$this->Lottery->exists($id)) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		$options = array('conditions' => array('Lottery.' . $this->Lottery->primaryKey => $id));
		$this->set('lottery', $this->Lottery->find('first', $options));
	}
	
	public function old_list() {
		//vas chercher les anciennes lotteries
		$paginateVar = array(
			'contain' => array(
				'EveItem' => array('EveCategory'),
				'Ticket' => array(
					'User' => array('id', 'eve_name')
					)
				),
			'conditions' => array('Lottery.lottery_status_id' => '2'),
			'order' => array(
				'Lottery.modified' => 'desc'
				),
			'limit' => '10'
			);

		$this->Paginator->settings = $paginateVar;
		$oldLotteries = $this->Paginator->paginate('Lottery');
		$this->set('old_lotteries', $oldLotteries);
	}
	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function admin_delete($id = null) {
		$this->Lottery->id = $id;
		if (!$this->Lottery->exists()) {
			throw new NotFoundException(__('Invalid lottery'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Lottery->delete($id, true)) {
			$this->Session->setFlash(
				'The lottery has been deleted.',
				'FlashMessage',
				array('type' => 'success')
				);
		} else {
			$this->Session->setFlash(
				'The lottery could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}

	protected function _order_lotteries($lotteries){
		$lines = array('line1' => array(), 'line2' => array(), 'line3' => array(), 'line4' => array(), 'line5' => array(), 'line6' => array());
		$linesPlaces = array('line1' => 0, 'line2' => 0, 'line3' => 0, 'line4' => 0, 'line5' => 0, 'line6' => 0);
		foreach ($lotteries as $lottery) {
			foreach ($lines as $key => $line) {
				if($lottery['Lottery']['nb_tickets'] == 48){
					if($linesPlaces[$key]<=0){
						array_push($lines[$key], $lottery);
						$linesPlaces[$key] +=3;
						break;
					}
					else{
						continue;
					}
				}
				else if($lottery['Lottery']['nb_tickets'] == 16){
					if($linesPlaces[$key]<=1){
						array_push($lines[$key], $lottery);
						$linesPlaces[$key] +=2;
						break;
					}
					else{
						continue;
					}
				}
				else{
					if($linesPlaces[$key]<=2){
						array_push($lines[$key], $lottery);
						$linesPlaces[$key] +=1;
						break;
					}
					else{
						continue;
					}
				}
			}
		}
		
		return array_merge($lines['line1'], $lines['line2'], $lines['line3'], $lines['line4'], $lines['line5'], $lines['line6']);
	}

	/**
	* Gets the last super lottery in the database
	* it is either the ongoing super or the las won super
	* @return [type] [description]
	*/
	protected function _get_last_super_lottery(){
		$superLottery = null;
		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'SuperLotteryTicket', 'Winner'),
			'conditions' => array(
				'OR'=>array(
					'AND'=>array(
						'SuperLottery.expiration_date BETWEEN NOW() -INTERVAL 1 DAY AND NOW()',
						'SuperLottery.status'=>array('completed', 'claimed', 'unclaimed')
						),
					'SuperLottery.status'=>'ongoing')),
			'order' => array('SuperLottery.created' => 'desc'),
			);
		$superLottery = $this->SuperLottery->find('first', $params);
		
		if(isset($superLottery['SuperLottery'])){
			$superLottery['SuperLotteryTicket'] = Hash::combine($superLottery['SuperLotteryTicket'], '{n}.buyer_user_id', '{n}');
			
			$superLottery['SuperLottery']['start_date'] = $this->_dateToUTC($superLottery['SuperLottery']['start_date']);
			$superLottery['SuperLottery']['expiration_date'] = $this->_dateToUTC($superLottery['SuperLottery']['expiration_date']);
		}
		
		$this->SuperLottery->initiate_super_lottery();
		
		$this->SuperLottery->end_super_lottery();

		return $superLottery;
	}

	/**
	* Gets the last flash lottery in the database
	* it is either the ongoing flash or the las won flash
	* @return [type] [description]
	*/
	protected function _get_last_flash_lottery(){
		
		$this->loadModel('FlashTicket');
		$flashLottery = null;
		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'Winner', 'FlashTicket'=>array('Buyer')),
			'conditions' => array(
				'OR'=>array(
					'AND'=>array(
						'FlashLottery.expiration_date BETWEEN NOW() -INTERVAL 2 HOUR AND NOW()',
						'FlashLottery.status'=>array('completed', 'claimed', 'unclaimed')
						),
					'FlashLottery.status'=>'ongoing')),
			'order' => array('FlashLottery.created' => 'desc'),
			);
		$flashLottery = $this->FlashLottery->find('first', $params);

		//organise the list of ticket bought so it is easily readable with the player ID
		if(!empty($flashLottery)){
			$flashLottery['FlashLottery']['nb_bought'] = $this->FlashTicket->find('count', array('conditions'=>array('flash_lottery_id'=>$flashLottery['FlashLottery']['id'], 'buyer_user_id is not null')));
			
			$flashLottery['FlashLottery']['start_date'] = $this->_dateToUTC($flashLottery['FlashLottery']['start_date']);
			$flashLottery['FlashLottery']['expiration_date'] = $this->_dateToUTC($flashLottery['FlashLottery']['expiration_date']);
		}

		$this->FlashLottery->initiate_flash_lottery();
		
		$this->FlashLottery->end_flash_lottery();
		
		return $flashLottery;
	}


	protected function _get_total_won(){
		
		$params = array(
			'conditions' => array('OR'=>array(array('Statistic.type' => 'win_super_lottery'), array('Statistic.type' => 'win_lottery'), array('Statistic.type' => 'win_flash_lottery'))),
			'fields' => array('SUM(Statistic.isk_value) as totalAmount'),
			);
		$total = $this->Statistic->find('first', $params);
		if(isset($total[0])){
			return $total[0]['totalAmount'];
		}
		else{
			return 0;
		}
		
	}

	protected function _dateToUTC($dateT){
		
		$server_tz = 'Europe/Paris';
		$schedule_date = new DateTime($dateT, new DateTimeZone($server_tz) );
		$schedule_date->setTimeZone(new DateTimeZone('UTC'));
		$newTime =  $schedule_date->format('c');

		return $newTime;
		
	}
}