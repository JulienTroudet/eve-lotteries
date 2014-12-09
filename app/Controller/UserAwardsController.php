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


	public function claim($id, $tab) {
		$userAwardId = $id;
		if (isset($userAwardId) && isset($tab)) {

			$this->loadModel('User');
			$userId = $this->Auth->user('id');

			if (!$this->UserAward->exists($userAwardId)) {
				$this->Session->setFlash(
					'Invalid Award.',
					'FlashMessage',
					array('type' => 'warning')
					);
				return $this->redirect(array('controller' => 'Awards', 'action' => 'index','#' => $tab, 'admin' => false));
			}
			else if (!$this->User->exists($userId)) {
				$this->Session->setFlash(
					'You must log in to claim an award !',
					'FlashMessage',
					array('type' => 'warning')
					);
				return $this->redirect(array('controller' => 'Awards', 'action' => 'index','#' => $tab,  'admin' => false));
			}
			else{

				$params = array(
					'contain' => array('Award'),
					'conditions' => array('UserAward.id' => $userAwardId),
					);
				
				$claimedAward = $this->UserAward->find('first', $params);

				$claimerUser = $this->User->findById($userId);

				if($claimedAward['UserAward']['status'] != 'unclaimed'){
					$data = array('error' => 'Award already claimed.');
				}
				else if($claimedAward['UserAward']['user_id'] != $userId){
					$data = array('error' => 'This is not your award.');
				}
				else{

					$claimedValue = $claimedAward['Award']['award_credits'];
					$claimerUser['User']['wallet'] += $claimedValue;
					$claimerUser['User']['nb_new_awards']--;

					$claimedAward['UserAward']['status'] = 'completed';

					if ($this->User->save($claimerUser, true, array('id', 'wallet', 'nb_new_awards')) && $this->UserAward->save($claimedAward, true, array('id', 'status'))) {

						$this->Session->setFlash(
							'You have claimed the award "'.$claimedAward['Award']['name'].'" for '.$claimedAward['Award']['award_credits'].' EVE-Lotteries Credits',
							'FlashMessage',
							array('type' => 'info')
							);
						return $this->redirect(array('controller' => 'Awards', 'action' => 'index','#' => $tab,  'admin' => false));

						$this->log('Award claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');


					}

				}
			}
		}
		return $this->redirect(array('controller' => 'Awards', 'action' => 'index','#' => $tab,  'admin' => false));
	}
	
	
}
