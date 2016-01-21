<?php

class EveApiShell extends AppShell {

    public $uses = array('Transaction', 'User', 'Statistic', 'Config', 'Message', 'Award', 'UserAward', 'Withdrawal', 'Wage');

    private $pheal = null;

    public function main() {

        $this->log('STARTING CRON', 'CRON eve-lotteries');

        $corpoKeyID = $this->Config->findByName("corpoKeyID");
        $corpoKeyIDValue = $corpoKeyID['Config']['value'];
        $corpoVCode = $this->Config->findByName("corpoVCode");
        $corpoVCodeValue = $corpoVCode['Config']['value'];

        $bonusManager = $this->Config->findByName("bonusManager");
        $bonusManager = $bonusManager['Config']['value'];


        Pheal\Core\Config::getInstance()->access = new \Pheal\Access\StaticCheck();

        $ds = ConnectionManager::getDataSource('default');
        $dsc = $ds->config;
        $dsn = 'mysql:host='.$dsc['host'].';dbname='.$dsc['database'];


        Pheal\Core\Config::getInstance()->cache = new \Pheal\Cache\PdoStorage($dsn, $dsc['login'], $dsc['password']);

        $this->pheal = new Pheal\Pheal($corpoKeyIDValue, $corpoVCodeValue, "corp");

        $apiCheckTime = $this->Config->findByName("apiCheck");
        $apiCheckTimeValue = $apiCheckTime['Config']['value'];


        $response = null;
        $response2 = null;
        try {


            $response = $this->pheal->walletjournal(array(''));


            $transactions = 0;

            $startDateTime = new DateTime('NOW');
            $nextDateTime = new DateTime($apiCheckTimeValue);

            foreach($response->entries as $entry)
            {
                $check_api = $this->Transaction->findByRefid($entry->refID);

                if(empty($check_api)){

                    $check_user_deposit = $this->User->findById($entry->ownerID1, array('User.id', 'User.eve_name','User.wallet', 'User.sponsor_user_id'));
                    if(!empty($check_user_deposit)){

                        $transactions++;
                        $this->Transaction->create();
                        $newTransaction = array('Transaction'=>array(
                            'refid' =>  $entry->refID,
                            'amount' => $entry->amount,
                            'user_id' => $check_user_deposit['User']['id'],
                            'eve_date' => $entry->date,
                        ));

                        //search if there is a waiting transaction
                        $waitingTrans = $this->Transaction->findByRefidAndAmountAndUserId('waiting', $newTransaction['Transaction']['amount'], $newTransaction['Transaction']['user_id']);
                        if(isset($waitingTrans['Transaction']['id'])){
                            $newTransaction['Transaction']['id'] = $waitingTrans['Transaction']['id'];
                        }

                        $dataSource = $this->User->getDataSource();
                        $dataSource->begin();

                        if(!isset($newTransaction['Transaction']['id'])){
                            $check_user_deposit['User']['wallet'] += $entry->amount;
                        }

                        if ($this->User->save($check_user_deposit, true, array('id', 'wallet')) && $this->Transaction->save($newTransaction, true, array('id', 'refid', 'amount', 'user_id', 'eve_date'))){

                            $this->Statistic->saveStat($check_user_deposit['User']['id'], 'deposit_isk', $this->Transaction->id, $entry->amount, null);

                            $this->Message->sendMessage(
                                $check_user_deposit['User']['id'],
                                'ISK Credited',
                                ('You have deposited '.number_format($entry->amount, 00).' ISK to your EVE-Lotteries account.'),
                                'transactions',
                                'index'
                            );

                            $this->log('Wallet Update : name['.$check_user_deposit['User']['eve_name'].'], id['.$check_user_deposit['User']['id'].'], amount['.$entry->amount.'], total['.$check_user_deposit['User']['wallet'].']', 'eve-lotteries');

                            //cette section s'occupe de verser des sous au parrain
                            if(isset($check_user_deposit['User']['sponsor_user_id'])){

                                $this->User->updateWallet($check_user_deposit['User']['sponsor_user_id'], ($entry->amount*0.05));

                                $this->Statistic->saveStat($check_user_deposit['User']['sponsor_user_id'], 'sponsor_isk', $check_user_deposit['User']['id'], ($entry->amount*0.05), null);
                            }


                            $dataSource->commit();

                        }
                        else {
                            $dataSource->rollback();
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


            //ici on prend la plus haute valeur entre la prochaine date de cron et la prochaine heure ou l'api est dispo pour la sauvegarder
            $nextApiDateTime = new DateTime($response->cached_until);
            $nextCronDateTime = new DateTime('NOW');
            $nextCronDateTime->add(new DateInterval('PT' . 30 . 'M'));

            $apiCheckTime['Config']['value'] = $nextCronDateTime->format('c');


            $this->Config->save($apiCheckTime, true, array('id', 'value'));
            $this->log($transactions.' transactions imported', 'eve-lotteries');

            $responseContract = $this->pheal->contracts(array(''));

            $wallet1 = $this->pheal->walletjournal(array("accountKey" => 1000));
            $wallet2 = $this->pheal->walletjournal(array("accountKey" => 1001));
            $wallet3 = $this->pheal->walletjournal(array("accountKey" => 1002));
            $wallet4 = $this->pheal->walletjournal(array("accountKey" => 1003));
            $wallet5 = $this->pheal->walletjournal(array("accountKey" => 1004));
            $wallet6 = $this->pheal->walletjournal(array("accountKey" => 1005));
            $wallet7 = $this->pheal->walletjournal(array("accountKey" => 1006));

            $walletTransactions = array($wallet1, $wallet2, $wallet3, $wallet4, $wallet5, $wallet6, $wallet7);

            $this->verifyWithdrawalManagement($walletTransactions, $responseContract, $bonusManager);

        } catch (\Pheal\Exceptions\PhealException $e) {

            $this->log($e->getMessage(), 'CRON error');

            // $this->out( sprintf(
            // 	"an exception was caught! Type: %s Message: %s",
            // 	get_class($e),
            // 	$e->getMessage()
            // 	));
        }


        //debug($response);
        //$this->out($response->cached_until);
        //die($response->cached_until);

        $db = $this->UserAward->getDataSource();

        $params = array(
            'conditions' => array('User.last_update BETWEEN NOW() -INTERVAL 3 HOUR AND NOW()'),
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
                    $query_result = $db->fetchAll($award['Award']['request'], array($userId));
                    if(isset($query_result[0])){
                        $result = $query_result[0][0]['result'];
                        $goal = $query_result[0][0]['goal'];
                    }
                    else{
                        $result = 0;
                        $goal = 1;
                    }
                    if($result>=$goal){
                        $this->UserAward->create();
                        $newUserAward = array('UserAward'=>array('award_id'=>$award['Award']['id'], 'user_id'=>$userId, 'status'=>'unclaimed'));

                        $this->UserAward->save($newUserAward, true, array('award_id', 'user_id', 'status'));

                        $this->log('Award Update : user_id['.$userId.'], award_id['.$award['Award']['id'].']', 'CRON eve-lotteries');

                    }
                }

            }

            $newAwardsCount = $this->UserAward->find('count', array(
                'conditions' => array('UserAward.user_id =' => $userId, 'UserAward.status =' => 'unclaimed')
            ));
            $this->User->updateNbNewAwards($userId, $newAwardsCount);
        }

        //$this->out('Update complete');
        $this->log(count($users).' Users Updated', 'CRON eve-lotteries');
        $this->log('ENDING CRON', 'CRON eve-lotteries');
    }


    /**
     * This function verifies the managers work (giving withdrawals to players)
     * @param $walletTransactions
     * @param $responseContract
     * @param $bonusManager
     */
    public function verifyWithdrawalManagement($walletTransactions, $responseContract, $bonusManager) {

        //check of the contract list
        foreach($responseContract->contractList as $entry)
        {
            if($entry->type == 'ItemExchange') {
                $check_contract = $this->Withdrawal->findByTypeAndVerificationCode('award_item', $entry->contractID);

                if (empty($check_contract)) {

                    $specificContract = $this->pheal->contractItems(array("contractID" => $entry->contractID));

                    //if the contract contains a list of items
                    if(sizeof($specificContract->itemList)>0) {

                        $specificContract = $specificContract->itemList[0];

                        //rechercher le withdrawal correspondant
                        $params = array(
                            'conditions' => array(
                                'Withdrawal.status' => 'completed_unverified',
                                'Withdrawal.type' => 'award_item',
                                'Withdrawal.user_id' => $entry->acceptorID,
                            ),
                            'contain' => array(
                                'User',
                                'Admin',
                                'Ticket' => array(
                                    'Lottery' => array(
                                        'EveItem' => array(
                                            'conditions' => array('EveItem.eve_id' => $specificContract->typeID)
                                        )
                                    )
                                ),
                            ),
                        );

                        $correspondingWithdrawal = $this->Withdrawal->find('first', $params);

                        if (!empty($correspondingWithdrawal)) {

                            $correspondingWithdrawal["Withdrawal"]["verification_code"] = $entry->contractID;
                            $correspondingWithdrawal["Withdrawal"]["status"] = 'completed';


                            $dataSource = $this->User->getDataSource();
                            $dataSource->begin();

                            $wok = $this->Withdrawal->save($correspondingWithdrawal, true, array('id', 'verification_code', 'status'));

                            $uok = $this->Wage->addIskToWage(
                                $correspondingWithdrawal["Withdrawal"]["admin_id"],
                                $correspondingWithdrawal["Ticket"]["Lottery"]["value"] * $bonusManager,
                                $correspondingWithdrawal["Withdrawal"]["id"],
                                $correspondingWithdrawal["Ticket"]["Lottery"]["value"]
                            );

                            if ($wok && $uok) {
                                $dataSource->commit();
                            } else {
                                $dataSource->rollback();
                            }
                        }
                    }
                }
            }
        }

        //check of the corpo wallet
        foreach($walletTransactions as $wallet) {
            foreach ($wallet->entries as $entry) {

                if($entry->ownerID1 != $entry->ownerID2) {

                    $this->log("WALLET");
                    $check_wallet = $this->Withdrawal->findByTypeAndVerificationCode('award_isk', $entry->refID);

                    if (empty($check_wallet)) {

                        /*
                        $refid =  $entry->refID;
                        $amount = $entry->amount;
                        $ownerID1 = $entry->ownerID1;
                        $ownerName1 = $entry->ownerName1;
                        $ownerID1 = $entry->ownerID2;
                        $ownerName2 = $entry->ownerName2;
                        $eve_date = $entry->date;*/

//                        $this->log("ID1 : " . $entry->ownerID1 . " " . $entry->ownerName1);
//                        $this->log("ID2 : " . $entry->ownerID2 . " " . $entry->ownerName2);
//                        $this->log("amount : " . $entry->amount);

                        //rechercher le withdrawal correspondant
                        $params = array(
                            'conditions' => array(
                                'Withdrawal.status' => 'completed_unverified',
                                'Withdrawal.type' => 'award_isk',
                                'Withdrawal.user_id' => $entry->ownerID2,
                                'Withdrawal.value LIKE' => ($entry->amount * -1).'%'
                            ),
                            'contain' => array(
                                'User',
                                'Admin'
                            ),
                        );

                        $correspondingWithdrawal = $this->Withdrawal->find('first', $params);

                        if (!empty($correspondingWithdrawal)) {


                            $correspondingWithdrawal["Withdrawal"]["verification_code"] = $entry->contractID;
                            $correspondingWithdrawal["Withdrawal"]["status"] = 'completed';


                            $dataSource = $this->User->getDataSource();
                            $dataSource->begin();

                            $wok = $this->Withdrawal->save($correspondingWithdrawal, true, array('id', 'verification_code', 'status'));

                            $uok = $this->Wage->addIskToWage(
                                $correspondingWithdrawal["Withdrawal"]["admin_id"],
                                $correspondingWithdrawal["Withdrawal"]["value"] * $bonusManager,
                                $correspondingWithdrawal["Withdrawal"]["id"],
                                $correspondingWithdrawal["Withdrawal"]["value"]
                            );

                            if ($wok && $uok) {
                                $dataSource->commit();
                            } else {
                                $dataSource->rollback();
                            }
                        }
                    }
                }
            }
        }
    }
}