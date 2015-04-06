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
		$this->loadModel('Message');
		
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

		//array to store the player progress for each award not yet won
		$progress = array();

		// à partir de là on vérifie si des awards ont été gagnés
		$db = $this->UserAward->getDataSource();
		//pour chaque award
		foreach ($awards as $key => $award) {

			//if there is no user_award for this award
			if(!array_key_exists($award['Award']['id'] , $userAwards )){
				//go see if it is won
				$query_result = $db->fetchAll($award['Award']['request'], array($userGlobal['id']));
				if(isset($query_result[0])){
					$result = $query_result[0][0]['result'];
					$goal = $query_result[0][0]['goal'];
				}
				else{
					$result = 0;
					$goal = 1;
				}

				//if it is won
				if($result>=$goal){
					//create and save a new user_award
					$this->UserAward->create();
					$newUserAward = array('UserAward'=>array('award_id'=>$award['Award']['id'], 'user_id'=>$userGlobal['id'], 'status'=>'unclaimed'));
					$this->UserAward->save($newUserAward, true, array('award_id', 'user_id', 'status'));					
					$this->log('Award Update : user_id['.$userGlobal['id'].'], award_idid['.$award['Award']['id'].']', 'eve-lotteries');
				}
				//else we display the progress
				else{
					$progress[$award['Award']['id']]['result'] = $result;
					$progress[$award['Award']['id']]['goal'] = $goal;
				}
				
			}
		}

		$this->set('userProgress', $progress);

		$this->_delete_duplicates($userGlobal);
		


		$newAwardsCount = $this->UserAward->find('count', array(
			'conditions' => array('AND' => array('UserAward.user_id =' => $userGlobal['id'], 'UserAward.status' => 'unclaimed'))
			));
		$userGlobal['nb_new_awards'] = $newAwardsCount;
		
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

	protected function _delete_duplicates($user){
		$result = $this->UserAward->find('all', array(
                'group' => array('UserAward.award_id HAVING COUNT(*) > 1'),
                'conditions' => array('AND' => array('UserAward.user_id =' => $user['id']))
                ));

		foreach ($result as $key => $value) {
			if($value['UserAward']['status'] == 'unclaimed'){
				$this->UserAward->delete($value['UserAward']['id']);
			}
		}
	}
}
