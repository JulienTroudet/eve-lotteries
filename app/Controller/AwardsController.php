<?php
App::uses('AppController', 'Controller');
/**
 * Awards Controller
 *
 * @property Award $Award
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AwardsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('');

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
		$userGlobal = $this->Auth->user();

		$params = array(
			'conditions' => array('Award.status' => 'active'),
			'order' => array('Award.group asc', 'Award.order asc')
			);
		$awards = $this->Award->find('all', $params);
		

		
		$this->loadModel('UserAward');
		$params = array(
			'conditions' => array('UserAward.user_id' => $userGlobal['id']),
			);
		$userAwards = $this->UserAward->find('all', $params);
		$userAwards = Set::combine($userAwards, '{n}.UserAward.award_id', '{n}');

		// à partir de là on vérifie si des awards ont été gagnés
		$db = $this->UserAward->getDataSource();
		foreach ($awards as $key => $award) {
			if(!array_key_exists($award['Award']['id'] , $userAwards )){
				$result = $db->fetchAll($award['Award']['request'], array($userGlobal['id']));
				if(isset($result[0])){
					$result = $result[0][0]['result'];
				}
				else{
					$result = false;
				}
				if($result){
					$this->UserAward->create();
					$newUserAward = array('UserAward'=>array('award_id'=>$award['Award']['id'], 'user_id'=>$userGlobal['id'], 'status'=>'unclaimed'));

					$this->UserAward->save($newUserAward, true, array('award_id', 'user_id', 'status'));
					
					$userGlobal['nb_new_awards']++;
					

					$this->log('Award Update : user_id['.$userGlobal['id'].'], award_idid['.$award['Award']['id'].']', 'eve-lotteries');
				}
				
			}
		}

		$this->User->save($userGlobal, true, array('id', 'nb_new_awards'));

		$awards = Hash::remove($awards, '{n}.Award.request');
		$awards = Hash::combine($awards, '{n}.Award.id', '{n}.Award', '{n}.Award.group');

		$params = array(
			'conditions' => array('UserAward.user_id' => $userGlobal['id']),
			);
		$userAwards = $this->UserAward->find('all', $params);
		$userAwards = Set::combine($userAwards, '{n}.UserAward.award_id', '{n}');
		
		$this->set('userAwards', $userAwards);
		$this->set('awards', $awards);
	}

	/**
	 * admin index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->set('awards', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Award->exists($id)) {
			throw new NotFoundException(__('Invalid Award'));
		}
		$this->Award->recursive = 0;
		$options = array('conditions' => array('Award.' . $this->Award->primaryKey => $id));
		$this->set('award', $this->Award->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {

		$userId = $this->Auth->user('id');


		if ($this->request->is('post')) {

			$this->Award->create();
			$dataProxy = $this->request->data;

			if ($this->Award->save($dataProxy, true, array('name', 'description', 'group', 'order', 'request', 'award_credits', 'status'))) {
				$this->Session->setFlash(
					'The Award has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The Award could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Award->exists($id)) {
			throw new NotFoundException(__('Invalid Award'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Award->save($this->request->data, true, array('id', 'name', 'description', 'group', 'order', 'request', 'award_credits', 'status'))) {
				$this->Session->setFlash(
					'The Award has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The Award could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		} else {
			$options = array('conditions' => array('Award.' . $this->Award->primaryKey => $id));
			$this->request->data = $this->Award->find('first', $options);
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Award->id = $id;
		if (!$this->Award->exists()) {
			throw new NotFoundException(__('Invalid Award'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Award->delete()) {
			$this->Session->setFlash(
				'The Award has been deleted.',
				'FlashMessage',
				array('type' => 'success')
				);
		} else {
			$this->Session->setFlash(
				'The Award could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}
}
