<?php
App::uses('AppController', 'Controller');
/**
 * LotteryStatuses Controller
 *
 * @property LotteryStatus $LotteryStatus
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LotteryStatusesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('');

		if (!$this->Auth->loggedIn()) {
			$this->Session->setFlash('Please Log in !', 'FlashMessage', array('type' => 'warning'));
			return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
		}
	}
	
}
