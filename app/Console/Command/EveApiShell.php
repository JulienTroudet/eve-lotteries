<?php

class EveApiShell extends AppShell {

	public $uses = array('Transaction', 'User', 'Statistic', 'Config');

	private $pheal = null;

	public function main() {
		$this->out('Ok');
	}

	public function update_wallet() {

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

	}
}