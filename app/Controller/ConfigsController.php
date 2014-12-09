<?php
App::uses('AppController', 'Controller');
App::Import('ConnectionManager');
/**
 * Configs Controller
 *
 * @property Config $Config
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ConfigsController extends AppController {



	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Session');

	private $pheal = null;

	public function beforeFilter() {

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
	}


	/**
	 * index method
	 *
	 * @return void
	 */
	public function update_api_check() {
		
		$apiCheckTime = $this->Config->findByName("apiCheck");
		$apiCheckTimeValue = $apiCheckTime['Config']['value'];
		
		
		$response = null;
		try {
			$response = $this->pheal->walletjournal(array(''));
			$transactions = 0;
			if($response->cached_until != $apiCheckTimeValue)
			{
				$this->loadModel('Transaction');
				$this->loadModel('User');

				foreach($response->entries as $entry)
				{
					$check_api = $this->Transaction->findByRefid($entry->refID);

					if(empty($check_api)){

						$check_user_deposit = $this->User->findByEveId($entry->ownerID1, array('User.id', 'User.eve_name','User.wallet'));
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
								$this->log('Wallet Update : name['.$check_user_deposit['User']['eve_name'].'], id['.$check_user_deposit['User']['id'].'], amount['.$entry->amount.'], total['.$check_user_deposit['User']['wallet'].']', 'eve-lotteries');
							}
						}


						$check_user_withdrawal = $this->User->findByEveId($entry->ownerID2, array('User.id', 'User.eve_name'));
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
					$this->Session->setFlash(
						'Api Updated',
						'FlashMessage',
						array('type' => 'info')
						);
				}
				//mysql_query("UPDATE config SET value = '".$response->cached_until."' WHERE id = '1'");
			}
			$this->log($transactions.' transactions imported', 'eve-lotteries');

		} catch (\Pheal\Exceptions\PhealException $e) {
			echo sprintf(
				"an exception was caught! Type: %s Message: %s",
				get_class($e),
				$e->getMessage()
				);
		}

		//debug($response);
		die();
		
	}
}
