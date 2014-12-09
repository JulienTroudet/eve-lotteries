<?php

class EveApiShell extends AppShell {

	public $uses = array('Transaction', 'User', 'Statistic', 'Config', 'Message', 'Award', 'UserAward');

	private $pheal = null;

	public function main() {

		$corpoKeyID = $this->Config->findByName("corpoKeyID");
		$corpoKeyIDValue = $corpoKeyID['Config']['value'];
		$corpoVCode = $this->Config->findByName("corpoVCode");
		$corpoVCodeValue = $corpoVCode['Config']['value'];


		Pheal\Core\Config::getInstance()->access = new \Pheal\Access\StaticCheck();

		$ds = ConnectionManager::getDataSource('default');
		$dsc = $ds->config;
		$dsn = 'mysql:host='.$dsc['host'].';dbname='.$dsc['database'];


		Pheal\Core\Config::getInstance()->cache = new \Pheal\Cache\PdoStorage($dsn, $dsc['login'], $dsc['password']);

		$this->pheal = new Pheal\Pheal($corpoKeyIDValue, $corpoVCodeValue, "corp");

		$apiCheckTime = $this->Config->findByName("apiCheck");
		$apiCheckTimeValue = $apiCheckTime['Config']['value'];


		$response = null;
		try {
			$response = $this->pheal->walletjournal(array(''));
			$transactions = 0;
			if($response->cached_until != $apiCheckTimeValue)
			{
				

				foreach($response->entries as $entry)
				{
					$check_api = $this->Transaction->findByRefid($entry->refID);

					if(empty($check_api)){

						$check_user_deposit = $this->User->findById($entry->ownerID1, array('User.id', 'User.eve_name','User.wallet'));
						if(!empty($check_user_deposit)){
							
							$transactions++;
							$this->Transaction->create();
							$newTransaction = array('Transaction'=>array(
								'refid' =>  $entry->refID,
								'amount' => $entry->amount,
								'user_id' => $check_user_deposit['User']['id'],
								'eve_date' => $entry->date,
								));


							$check_user_deposit['User']['wallet'] += $entry->amount;

							if ($this->User->save($check_user_deposit, true, array('id', 'wallet')) && $this->Transaction->save($newTransaction, true, array('refid', 'amount', 'user_id', 'eve_date'))){

								$this->Statistic->saveStat($check_user_deposit['User']['id'], 'deposit_isk', $this->Transaction->id, $entry->amount, null);

								$this->Message->sendMessage(
									$check_user_deposit['User']['id'], 
									'ISK Credited', 
									('You have deposited '.number_format($entry->amount, 00).' ISK to your EVE-Lotteries account.'),
									'transactions', 
									'index'
									);

								$this->log('Wallet Update : name['.$check_user_deposit['User']['eve_name'].'], id['.$check_user_deposit['User']['id'].'], amount['.$entry->amount.'], total['.$check_user_deposit['User']['wallet'].']', 'eve-lotteries');
							}
						}


						$check_user_withdrawal = $this->User->findById($entry->ownerID2, array('User.id', 'User.eve_name'));
						if(!empty($check_user_withdrawal)){

							$transactions++;
							$this->Transaction->create();
							$newTransaction = array('Transaction'=>array(
								'refid' =>  $entry->refID,
								'amount' => $entry->amount,
								'user_id' => $check_user_withdrawal['User']['id'],
								'eve_date' => $entry->date,
								));

							if ($this->Transaction->save($newTransaction, true, array('refid', 'amount', 'user_id', 'eve_date'))){
								$this->log('Given_isk Update : name['.$check_user_withdrawal['User']['eve_name'].'], id['.$check_user_withdrawal['User']['id'].'], amount['.$entry->amount.']', 'eve-lotteries');
							}
						}
					}


				}
				$apiCheckTime['Config']['value'] = $response->cached_until;
				if ($this->Config->save($apiCheckTime, true, array('id', 'value'))) {
				}
				//mysql_query("UPDATE config SET value = '".$response->cached_until."' WHERE id = '1'");
			}
			$this->log($transactions.' transactions imported', 'eve-lotteries');

		} catch (\Pheal\Exceptions\PhealException $e) {
			$this->out( sprintf(
				"an exception was caught! Type: %s Message: %s",
				get_class($e),
				$e->getMessage()
				));
		}

		//debug($response);
		$this->out($response->cached_until);
		//die($response->cached_until);
		
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
					if(isset($result[0])){
						$result = $result[0][0]['result'];
					}
					else{
						$result = false;
					}
					if($result){
						$this->UserAward->create();
						$newUserAward = array('UserAward'=>array('award_id'=>$award['Award']['id'], 'user_id'=>$userId, 'status'=>'unclaimed'));

						$this->UserAward->save($newUserAward, true, array('award_id', 'user_id', 'status'));

						$this->log('Award Update : user_id['.$userId.'], award_idid['.$award['Award']['id'].']', 'eve-lotteries');

						$this->Message->sendMessage(
							$userId, 
							'Award Completed', 
							('You have completed the award "'.$award['Award']['name'].'". Please claim your prize in the award Menu'),
							'awards', 
							'index'
							);
					}
				}
				
			}
		}

		$this->out('Update complete');
	}
}