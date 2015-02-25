<?php
App::uses('AppController', 'Controller');

/**
 * SuperLotteries Controller
 *
 * @property FlashLottery $FlashLottery
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FlashLotteriesController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'visible_flash_lottery');
	}

	/**
	 * get the first flash lot without layout for Ajax
	 * @return [type] [description]
	 */
	public function visible_flash_lottery() {
		$this->layout = false;
		//get the last flash lottery
		$flashLottery = $this->_get_last_flash_lottery();
		$this->set('flashLottery', $flashLottery);
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$params = array('contain' => array('EveItem' => array('EveCategory'), 'FlashLotteryTicket' => array('Buyer')), 'order' => array('FlashLottery.created' => 'desc'),);
		$this->Paginator->settings = $params;
		$flashLotteries = $this->Paginator->paginate();

		$this->set('flashLotteries', $flashLotteries);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->FlashLottery->recursive = 0;
		$params = array('contain' => array('EveItem', 'FlashTicket' => array('Buyer')), 'conditions' => array('FlashLottery.status !=' => 'completed'), 'order' => array('FlashLottery.created' => 'desc'),);
		$this->Paginator->settings = $params;
		$this->set('flashLotteries', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->FlashLottery->recursive = 0;
		if (!$this->FlashLottery->exists($id)) {
			throw new NotFoundException(__('Invalid super lottery'));
		}
		$options = array('conditions' => array('FlashLottery.' . $this->FlashLottery->primaryKey => $id));
		$this->set('superLottery', $this->FlashLottery->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$userId = $this->Auth->user('id');

		if ($this->request->is('post')) {
			$this->FlashLottery->create();

			$newFlashLottery = $this->request->data;
			$newFlashLottery['FlashLottery']['status'] = 'waiting';
			$newFlashLottery['FlashLottery']['creator_user_id'] = $userId;
			$newFlashLottery['FlashTicket'] = array();

			for ($i = 1; $i <= $newFlashLottery['FlashLottery']['nb_tickets']; $i++) {
				$flashTicket = array('position' => $i);

				array_push($newFlashLottery['FlashTicket'], $flashTicket);
			}

	        // debug($newFlashLottery);
	        // die();

			if ($this->FlashLottery->saveAssociated($newFlashLottery)) {
				$this->Session->setFlash('The flash lottery has been saved.', 'FlashMessage', array('type' => 'info'));
				return $this->redirect(array('controller' => 'flash_lotteries', 'action' => 'admin_index', 'admin' => true));
			} else {
				$this->Session->setFlash('The flash lottery could not be saved. Please, try again.', 'FlashMessage', array('type' => 'warning'));
				return $this->redirect(array('controller' => 'flash_lotteries', 'action' => 'admin_add', 'admin' => true));
			}
		}

	    //si pas de requête POST on vas chercher les Items pour le choix
		$eveItems = $this->FlashLottery->EveItem->find('all', array('order' => 'EveItem.name asc'));
		$this->set('eveItems', $eveItems);
	}


	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->FlashLottery->id = $id;
		if (!$this->FlashLottery->exists()) {
			throw new NotFoundException(__('Invalid flash lottery'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->FlashLottery->delete()) {
			$this->Session->setFlash('The flash lottery has been deleted.', 'FlashMessage', array('type' => 'info'));
		} else {
			$this->Session->setFlash('The flash lottery could not be deleted. Please, try again.', 'FlashMessage', array('type' => 'warning'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	/**
	* Gets the last flash lottery in the database
	* it is either the ongoing flash or the las won flash
	* @return [type] [description]
	*/
	protected function _get_last_flash_lottery(){
		
		$flashLottery = null;
		$params = array(
			'contain' => array('EveItem' => array('EveCategory'), 'FlashTicket'=>array('Buyer')),
			'conditions' => array(
				'OR'=>array(
					'AND'=>array(
						'FlashLottery.modified BETWEEN NOW() -INTERVAL 1 DAY AND NOW()',
						'FlashLottery.status'=>array('completed', 'claimed')
						),
					'FlashLottery.status'=>'ongoing')),
			'order' => array('FlashLottery.created' => 'desc'),
			);
		$flashLottery = $this->FlashLottery->find('first', $params);


		if(empty($flashLottery)){
			$this->FlashLottery->initiate_flash_lottery();
		}
		else{
			$this->FlashLottery->end_flash_lottery();
		}

		return $flashLottery;
	}

	
}
