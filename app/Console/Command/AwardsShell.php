<?php

class AwardsShell extends AppShell {

	public $uses = array('Award', 'User', 'UserAward');

	private $pheal = null;

	public function main() {
		$this->out('Ok');
	}

	public function update_awards() {
		$db = $this->UserAward->getDataSource();

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

		$this->out('Update complete');
		
	}
}