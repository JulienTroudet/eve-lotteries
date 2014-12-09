<?php
App::uses('AppController', 'Controller');
/**
 * Configs Controller
 *
 * @property Config $Config
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UserAwardsController extends AppController {



	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Session');

	

	public function beforeFilter() {
		$this->Auth->allow('update_awards');
	}


	public function claim($id) {
		$userAwardId = $id;
		if (isset($userAwardId)) {

			$this->loadModel('User');
			$userId = $this->Auth->user('id');

			if (!$this->UserAward->exists($userAwardId)) {
				$this->Session->setFlash(
					'Invalid Award.',
					'FlashMessage',
					array('type' => 'warning')
					);
				return $this->redirect(array('controller' => 'Awards', 'action' => 'index', 'admin' => false));
			}
			else if (!$this->User->exists($userId)) {
				$this->Session->setFlash(
					'You must log in to claim an award !',
					'FlashMessage',
					array('type' => 'warning')
					);
				return $this->redirect(array('controller' => 'Awards', 'action' => 'index', 'admin' => false));
			}
			else{

				$params = array(
					'contain' => array('Award'),
					'conditions' => array('UserAward.id' => $userAwardId),
					);
				
				$claimedAward = $this->UserAward->find('first', $params);

				$claimerUser = $this->User->findById($userId, array('User.id', 'User.eve_name', 'User.wallet'));

				if($claimedAward['UserAward']['status'] != 'unclaimed'){
					$data = array('error' => 'Award already claimed.');
				}
				else if($claimedAward['UserAward']['user_id'] != $userId){
					$data = array('error' => 'This is not your award.');
				}
				else{

					$claimedValue = $claimedAward['Award']['award_credits'];
					$claimerUser['User']['wallet'] += $claimedValue;

					$claimedAward['UserAward']['status'] = 'completed';

					if ($this->User->save($claimerUser, true, array('id', 'wallet')) && $this->UserAward->save($claimedAward, true, array('id', 'status'))) {

						$this->Session->setFlash(
							'You have claimed the award "'.$claimedAward['Award']['name'].'" for '.$claimedAward['Award']['award_credits'].' EVE-Lotteries Credits',
							'FlashMessage',
							array('type' => 'info')
							);
						return $this->redirect(array('controller' => 'Awards', 'action' => 'index', 'admin' => false));

						$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');


					}

				}
			}
		}
		return $this->redirect(array('controller' => 'Awards', 'action' => 'index', 'admin' => false));
	}
	
	public function update_awards() {
		$db = $this->UserAward->getDataSource();


		$this->loadModel('User');
		$this->loadModel('Award');

		$params = array(
			'contain' => array('UserAward' => array('fields' => array('UserAward.award_id'))),
			'fields'  => array('User.id'),
			);
		$users = $this->User->find('all', $params);
		$users = Set::combine($users, '{n}.User.id', '{n}.UserAward.{n}.award_id');

		$params = array(
			'conditions' => array('Award.status' => 'active'),
			);
		$awards = $this->Award->find('all', $params);


		foreach ($users as $userId => $user) {
			foreach ($awards as $key => $award) {

				if(!in_array ($award['Award']['id'] , $user )){
					$result = $db->fetchAll($award['Award']['request'], array($userId));
					$result = $result[0][0]['result'];
					if($result){
						$this->UserAward->create();
						$newUserAward = array('UserAward'=>array('award_id'=>$award['Award']['id'], 'user_id'=>$userId, 'status'=>'unclaimed'));

						$this->UserAward->save($newUserAward, true, array('award_id', 'user_id', 'status'));

						$this->log('Award Update : user_id['.$userId.'], award_idid['.$award['Award']['id'].']', 'eve-lotteries');
					}
				}
				
			}
		}

		die('end');
		
	}
}
