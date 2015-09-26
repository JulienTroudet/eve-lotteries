<?php
App::uses('AppController', 'Controller');
/**
 * Withdrawals Controller
 *
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class WithdrawalsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'RequestHandler', 'WalletParser');

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
        $this->loadModel('SuperLottery');
        $this->loadModel('FlashLottery');

        $userGlobal = $this->Auth->user();



        $this->_recountAllWithdrawals($userGlobal);


        //get unclaimed awards
        $paginateVar = array(
            'contain' => array(
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('new', 'claimed', 'reserved'), 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item', 'award')),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'limit' => 10
        );
        $this->Paginator->settings = $paginateVar;
        $unclaimed_awards = $this->Paginator->paginate('Withdrawal');
        $this->set('unclaimed_awards', $unclaimed_awards);

        $params = array(
            'contain' => array(
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => 'completed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item')),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'limit' => 10
        );
        $claimed_awards = $this->Withdrawal->find('all', $params);

        $this->set('claimed_awards', $claimed_awards);

        $params = array(
            'contain' => array('EveItem' => array('EveCategory'), 'SuperLotteryTicket', 'Winner'),
            'conditions' => array('SuperLottery.winner_user_id' => $userGlobal['id']),
            'order' => array('SuperLottery.created' => 'desc'),
        );
        $superWithdrawals = $this->SuperLottery->find('all', $params);
        foreach ($superWithdrawals as $key => $superLottery) {
            $superWithdrawals[$key]['SuperLotteryTicket'] = Hash::combine($superLottery['SuperLotteryTicket'], '{n}.buyer_user_id', '{n}');
        }

        $this->set('superWithdrawals', $superWithdrawals);

        $params = array(
            'contain' => array('EveItem' => array('EveCategory'), 'FlashTicket'=>array('Buyer'), 'Winner'),
            'conditions' => array('FlashLottery.winner_user_id' => $userGlobal['id']),
            'order' => array('FlashLottery.created' => 'desc'),
        );
        $flashWithdrawals = $this->FlashLottery->find('all', $params);

        $this->set('flashWithdrawals', $flashWithdrawals);

    }

    public function view($group_id = null) {

        if(isset($group_id)){
            $userGlobal = $this->Auth->user();
            $paginateVar = array(
                'contain' => array(
                    'Ticket' => array(
                        'Lottery' => array(
                            'EveItem' => array('EveCategory')
                        )
                    ),
                ),
                'conditions' => array('OR' => array('Withdrawal.group_id' => $group_id, 'Withdrawal.id' => $group_id)),
                'order' => array(
                    'Withdrawal.modified' => 'desc'
                ),
                'limit' => 10
            );
            $this->Paginator->settings = $paginateVar;
            $unclaimed_awards = $this->Paginator->paginate('Withdrawal');
            $this->set('unclaimed_awards', $unclaimed_awards);
        }
    }

    public function list_awards() {
        $this->layout = false;

        $userGlobal = $this->Auth->user();
        $paginateVar = array(
            'contain' => array(
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('new', 'claimed', 'reserved'), 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item', 'award')),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'limit' => 10
        );
        $this->Paginator->settings = $paginateVar;
        $unclaimed_awards = $this->Paginator->paginate('Withdrawal');
        $this->set('unclaimed_awards', $unclaimed_awards);

        $params = array(
            'contain' => array(
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => 'completed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item')),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'limit' => 10
        );
        $claimed_awards = $this->Withdrawal->find('all', $params);
        $this->set('claimed_awards', $claimed_awards);
    }



    public function old_list() {
        $userGlobal = $this->Auth->user();
        $paginateVar = array(
            'contain' => array(
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => 'completed', 'Withdrawal.user_id' => $userGlobal['id'], 'Withdrawal.type' => array("award_credit", "award_isk", "award_item")),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'limit' => 20
        );
        $this->Paginator->settings = $paginateVar;
        $completed_awards = $this->Paginator->paginate('Withdrawal');
        $this->set('completed_awards', $completed_awards);
    }

    public function claim() {

        $this->request->onlyAllow('ajax');


        if ($this->request->is('ajax')) {

            $this->disableCache();
            $this->loadModel('Ticket');
            $this->loadModel('User');
            $this->loadModel('Statistic');



            $withdrawalId = $this->request->query('withdrawal_id');

            $claimType = $this->request->query('claim_type');

            if (!$this->Withdrawal->exists($withdrawalId)) {
                $data = array('error' => 'Invalid Lottery.' );
            }

            if (!in_array( $claimType , array('credit', 'isk', 'item')) ){
                $data = array('error' => 'Invalid Lottery claim.' );
            }

            else{
                $params = array(
                    'contain' => array(
                        'User',
                        'Ticket' => array(
                            'Lottery',
                        ),
                    ),
                    'conditions' => array('Withdrawal.id' => $withdrawalId),
                );

                $claimedAward = $this->Withdrawal->find('first', $params);

                $claimerUser = $this->User->findById($claimedAward['Withdrawal']['user_id']);
                if($claimedAward['Withdrawal']['status'] != 'new'){
                    $data = array('error' => 'Lottery already claimed.');
                }
                else{
                    switch ($claimType) {
                        case 'credit':

                            $claimedValue = $claimedAward['Ticket']['Lottery']['value']*1.05;

                            $claimerUser['User']['wallet'] += $claimedValue;
                            $claimerUser['User']['nb_new_won_lotteries']--;

                            $claimedAward['Withdrawal']['group_id'] = $claimedAward['Withdrawal']['id'];
                            $claimedAward['Withdrawal']['status'] = 'completed';
                            $claimedAward['Withdrawal']['type'] = 'award_credit';
                            $claimedAward['Withdrawal']['value'] = $claimedValue;

                            $dataSource = $this->Withdrawal->getDataSource();
                            $dataSource->begin();


                            if (
                                $this->Withdrawal->save($claimedAward, true, array('id', 'group_id', 'status', 'type', 'value'))
                                &&
                                $this->User->save($claimerUser, true, array('id', 'wallet', 'nb_new_won_lotteries'))
                            ) {

                                $data = array (
                                    'success' => true,
                                    'message' => $claimedValue.' EVE-Lotteries Credits',
                                    'nb_new_won_lotteries'=> $claimerUser['User']['nb_new_won_lotteries'],
                                );

                                $this->Statistic->saveStat($claimerUser['User']['id'], 'withdrawal_credits', $withdrawalId, $claimedValue, $claimedAward['Ticket']['Lottery']['eve_item_id']);

                                $this->log('Lottery claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');

                                $dataSource->commit();

                            }
                            else{
                                $dataSource->rollback();
                                $data = array('error' => 'Error while processing.');
                                return $data;
                            }
                            break;

                        case 'isk':
                            $claimedValue = $claimedAward['Ticket']['Lottery']['value'];

                            $claimedAward['Withdrawal']['group_id'] = $claimedAward['Withdrawal']['id'];
                            $claimedAward['Withdrawal']['status'] = 'claimed';
                            $claimedAward['Withdrawal']['type'] = 'award_isk';
                            $claimedAward['Withdrawal']['value'] = $claimedValue;

                            $claimerUser['User']['nb_new_won_lotteries']--;

                            $dataSource = $this->Withdrawal->getDataSource();
                            $dataSource->begin();

                            if (
                                $this->Withdrawal->save($claimedAward, true, array('id', 'group_id', 'status', 'type', 'value'))
                                &&
                                $this->User->save($claimerUser, true, array('id', 'nb_new_won_lotteries'))
                            ) {

                                $data = array (
                                    'success' => true,
                                    'message' => number_format($claimedValue, 2).' ISK',
                                    'nb_new_won_lotteries'=> $claimerUser['User']['nb_new_won_lotteries'],
                                );

                                $this->Statistic->saveStat($claimerUser['User']['id'], 'withdrawal_isk', $withdrawalId, $claimedValue, $claimedAward['Ticket']['Lottery']['eve_item_id']);

                                $this->log('Lottery claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');

                                $dataSource->commit();

                            }
                            else{
                                $dataSource->rollback();
                                $data = array('error' => 'Error while processing.');
                                return $data;
                            }
                            break;
                        case 'item':
                            $claimedISK = $claimedAward['Ticket']['Lottery']['value'];

                            $claimedValue = $claimedAward['Ticket']['Lottery']['eve_item_id'];

                            $claimedAward['Withdrawal']['group_id'] = $claimedAward['Withdrawal']['id'];
                            $claimedAward['Withdrawal']['status'] = 'claimed';
                            $claimedAward['Withdrawal']['type'] = 'award_item';
                            $claimedAward['Withdrawal']['value'] = $claimedValue;

                            $claimerUser['User']['nb_new_won_lotteries']--;

                            $dataSource = $this->Withdrawal->getDataSource();
                            $dataSource->begin();

                            if (
                                $this->Withdrawal->save($claimedAward, true, array('id', 'group_id', 'status', 'type', 'value'))
                                &&
                                $this->User->save($claimerUser, true, array('id', 'nb_new_won_lotteries'))
                            ) {

                                $data = array (
                                    'success' => true,
                                    'message' => preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$claimedAward['Ticket']['Lottery']['name']),
                                    'nb_new_won_lotteries'=> $claimerUser['User']['nb_new_won_lotteries'],
                                );

                                $this->Statistic->saveStat($claimerUser['User']['id'], 'withdrawal_item', $withdrawalId, $claimedISK, $claimedAward['Ticket']['Lottery']['eve_item_id']);

                                $this->log('Lottery claimed : type['.$claimType.'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalId.'], value['.$claimedValue.']', 'eve-lotteries');

                                $dataSource->commit();

                            }
                            else{
                                $dataSource->rollback();
                                $data = array('error' => 'Error while processing.');
                                return $data;
                            }
                            break;
                    }


                }
            }
            $this->set(compact('data')); // Pass $data to the view
            $this->set('_serialize', 'data');
        }
    }

    public function admin_index() {

        $nbWithdrawalClaimed = $this->Withdrawal->find('count', array('conditions'=>array('Withdrawal.status'=>'claimed')));
        $this->set('nbWithdrawalClaimed', $nbWithdrawalClaimed);

        $this->loadModel('SuperLottery');
        $this->loadModel('FlashLottery');

        $nbSuperClaimed = $this->SuperLottery->find('count', array('conditions'=>array('SuperLottery.status'=>array('claimed_isk','claimed_item'))));
        $this->set('nbSuperClaimed', $nbSuperClaimed);

        $nbFlashClaimed = $this->FlashLottery->find('count', array('conditions'=>array('FlashLottery.status'=>array('claimed_isk','claimed_item'))));
        $this->set('nbFlashClaimed', $nbFlashClaimed);

        $this->_organize_groups();

        $this->Withdrawal->virtualFields['total_value'] = 'SUM(Withdrawal.value)';

        $paginateVar = array(
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('claimed', 'reserved'), 'Withdrawal.type' => array('award_isk', 'award_item')),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'group' => array('Withdrawal.group_id'),
            'limit' => 20
        );


        $this->Paginator->settings = $paginateVar;
        $claimed_awards = $this->Paginator->paginate('Withdrawal');

        // debug($claimed_awards);
        // die();

        $this->set('claimed_awards', $claimed_awards);
    }

    /**
     * withdrawal panel for managers and admins
     */
    public function management() {
        $userGlobal = $this->Auth->user();

        //the first part search the list of withdrawals to complete
        $paginateVar = array(
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('claimed'), 'Withdrawal.type' => array('award_isk', 'award_item')),
            'order' => array(
                'Withdrawal.modified' => 'asc'
            ),
            'limit' => 20
        );
        $this->Paginator->settings = $paginateVar;
        $claimed_awards = $this->Paginator->paginate('Withdrawal');
        $this->set('claimed_awards', $claimed_awards);

        //the second part get the withdrawal reserved by the user, if there is one

        $params = array(
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('reserved'), 'Withdrawal.admin_id' => $userGlobal['id']),
            'limit' => 1
        );
        $reserved_award = $this->Withdrawal->find('first', $params);

        $this->set('reserved_award', $reserved_award);
    }

    /**
     * Function activated when a manager tries to complete a withdrawal
     */
    public function complete() {
        $userGlobal = $this->Auth->user();

        //gets the data send via form
        $data = $this->request->data;

        //search for the corresponding withdrawal
        $withdrawalId = $data['Withdrawal']['withdrawal_id'];

        if(empty($withdrawalId)){
            $this->Session->setFlash(
                'Withdrawal not valid!',
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'management', 'admin' => false));
        }

        $params = array(
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.id' => $withdrawalId),
            'limit' => 1
        );
        $claimedWithdraw = $this->Withdrawal->find('first', $params);

        //if there is not corresponding withdrawal exit
        if(!isset($claimedWithdraw)){
            $this->Session->setFlash(
                'Withdrawal not valid!',
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'management', 'admin' => false));
        }

        $withdrawalInGameConfirmation = $data['Withdrawal']['ingame_confirmation'];

        $confirmation = $this->WalletParser->parseOneWithdrawal($withdrawalInGameConfirmation, $claimedWithdraw['Withdrawal']['type']);

        $okMessage = $this->_compareConfirmationToWithdrawal($confirmation, $claimedWithdraw);

        // if the confirmation string copied in eve correspond to the withdrawal
        if($okMessage == 'ok'){
            if($claimedWithdraw['Withdrawal']['status'] != 'reserved'){
                $this->Session->setFlash(
                    'Withdrawal not reserved.',
                    'FlashMessage',
                    array('type' => 'warning')
                );
                return $this->redirect(array('action' => 'management', 'admin' => false));
            }

            if($claimedWithdraw['Withdrawal']['admin_id'] != $userGlobal['id']){
                $this->Session->setFlash(
                    'Withdrawal not reserved or already reserved by an admin.',
                    'FlashMessage',
                    array('type' => 'warning')
                );
                return $this->redirect(array('action' => 'management', 'admin' => false));
            }

            $this->loadModel('Ticket');
            $this->loadModel('User');
            $this->loadModel('Message');

            $claimerUser = $this->User->findById($claimedWithdraw['Withdrawal']['user_id'], array('User.id', 'User.eve_name'));

            $dataSource = $this->Withdrawal->getDataSource();
            $dataSource->begin();

            $success = $this->Withdrawal->updateAll(
                array('Withdrawal.status' => '"completed_unverified"'),
                array('Withdrawal.id' => $claimedWithdraw['Withdrawal']['id'])
            );

            if ($success) {

                $this->Session->setFlash(
                    'You have completed the Withdrawal for '.$claimerUser['User']['eve_name'],
                    'FlashMessage',
                    array('type' => 'success')
                );

                $this->Message->sendLotteryMessage(
                    $claimerUser['User']['id'],
                    'Lottery Completed',
                    'Your prize for one or more lotteries has been delivered by our staff. Please check your wallet or your contracts in game.',
                    $claimedWithdraw['Withdrawal']['id']
                );
                $this->log('Withdrawal completed : user_name['.$claimerUser['User']['eve_name'].'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$claimedWithdraw['Withdrawal']['id'].']', 'eve-lotteries');

                $dataSource->commit();

            }
            else {
                $dataSource->rollback();
            }

        }
        else{
            $this->Session->setFlash(
                $okMessage,
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'management', 'admin' => false));
        }


        return $this->redirect(array('action' => 'management', 'admin' => false));
    }

    /**
     * Function used by a manager to reserve a withdrawal claimed by a player
     */
    public function reserve_one() {
        $manager = $this->Auth->user();

        // a manager can only have one reserved award at a time
        $params = array(
            'conditions' => array(
                'Withdrawal.status' => 'reserved',
                'Withdrawal.admin_id' => $manager['id']
            )
        );
        $reserved_award = $this->Withdrawal->find('all', $params);
        if(!empty($reserved_award)){
            $this->Session->setFlash(
                'You already have a reserved withdrawal!',
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'management', 'admin' => false));
        }

        //search for the last withdrawal
        $params = array(
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('claimed'), 'Withdrawal.type' => array('award_isk', 'award_item')),
            'order' => array(
                'Withdrawal.modified' => 'asc'
            )
        );
        $award = $this->Withdrawal->find('first', $params);

        //if there is no withdrawal to reserve
        if(empty($award)){
            $this->Session->setFlash(
                'No withdrawal to reserve!',
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'management', 'admin' => false));
        }

        $this->Withdrawal->updateAll(
            array(
                'Withdrawal.admin_id' => $manager['id'],
                'Withdrawal.status' => "'reserved'"),
            array(
                'Withdrawal.id' => $award['Withdrawal']['id']
            )
        );

        $this->Session->setFlash(
            "You reserved a player's claim",
            'FlashMessage',
            array('type' => 'info')
        );

        return $this->redirect(array('action' => 'management', 'admin' => false));
    }

    public function cancel_reservation() {
        $manager = $this->Auth->user();

        $this->Withdrawal->updateAll(
            array(
                'Withdrawal.admin_id' => null,
                'Withdrawal.status' => "'claimed'"),
            array(
                'Withdrawal.admin_id' => $manager['id'],
                'Withdrawal.status' => "reserved"
            )
        );

        $this->Session->setFlash(
            'Reservation canceled !',
            'FlashMessage',
            array('type' => 'info')
        );

        return $this->redirect(array('action' => 'management', 'admin' => false));
    }

    public function admin_list_awards_to_complete() {

        $this->_organize_groups();

        $this->Withdrawal->virtualFields['total_value'] = 'SUM(Withdrawal.value)';
        $paginateVar = array(
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
            'conditions' => array('Withdrawal.status' => array('claimed', 'reserved'), 'Withdrawal.type' => array('award_isk', 'award_item')),
            'order' => array(
                'Withdrawal.modified' => 'desc'
            ),
            'group' => array('Withdrawal.group_id'),
            'limit' => 20
        );


        $this->Paginator->settings = $paginateVar;
        $claimed_awards = $this->Paginator->paginate('Withdrawal');

        $this->set('claimed_awards', $claimed_awards);
    }

    protected function _organize_groups() {
        //ici lorsque l'admin se connecte on effectue un regroupement des retraits d'ISK. Ainsi on fait une première requette afin de remplir le id_group des withdrawals pour qu'un player n'aie qu'un seul retrait à son actif (simplification des versements)
        //on récupère la liste des user_id concernés.
        $params = array(
            'conditions' => array('AND' => array('Withdrawal.status' => array('claimed'), 'Withdrawal.type' => 'award_isk')),
            'fields' => array('Withdrawal.user_id'),
            'group' => array('Withdrawal.user_id')
        );

        $userIds = $this->Withdrawal->find('list', $params);
        // debug($userIds);
        // die();

        //on update pour chaque user le group_id des withdrawal claimed ISK afin de pouvoir les grouper plus tard avec cette valeur.
        //

        foreach ($userIds as $id => $userId) {
            $this->Withdrawal->updateAll(
                array('Withdrawal.group_id' => $id),
                array('AND' => array('Withdrawal.status' => 'claimed', 'Withdrawal.type' => 'award_isk', 'Withdrawal.user_id' => $userId))
            );
        }
    }

    public function admin_complete_award() {
        $userGlobal = $this->Auth->user();
        $this->request->onlyAllow('ajax');


        if ($this->request->is('ajax')) {

            $this->disableCache();
            $this->loadModel('Ticket');
            $this->loadModel('User');

            $withdrawalGroupId = $this->request->query('withdrawal_group_id');


            $claimedAwards = $this->Withdrawal->findAllByGroupId($withdrawalGroupId);
            if (count($claimedAwards)<=0) {
                $data = array('error' => 'Invalid Award.' );
                return;
            }


            else{
                $params = array(
                    'contain' => array(
                        'User',
                        'Ticket' => array(
                            'Lottery',
                        ),
                    ),
                    'conditions' => array('Withdrawal.group_id' => $withdrawalGroupId),
                );

                $claimedAwards = $this->Withdrawal->find('all', $params);



                $claimerUser = null;
                $continue = true;
                foreach ($claimedAwards as $key => $claimedAward) {
                    if($claimedAward['Withdrawal']['status'] != 'reserved'){
                        $data = array('error' => 'Withdrawal not reserved.');
                        $continue = false;
                        break;
                    }

                    if($claimedAward['Withdrawal']['admin_id'] != $userGlobal['id']){
                        $data = array('error' => 'Withdrawal not reserved or already reserved by an admin.');
                        $continue = false;
                        break;
                    }

                    if(!isset($claimerUser)){
                        $claimerUser = $this->User->findById($claimedAward['Withdrawal']['user_id'], array('User.id', 'User.eve_name', 'User.wallet'));
                    }

                }

                if($continue){

                    $this->loadModel('Message');

                    $success = $this->Withdrawal->updateAll(
                        array('Withdrawal.status' => '"completed"'),
                        array('Withdrawal.group_id' => $withdrawalGroupId)
                    );

                    if ($success) {

                        $data = array (
                            'success' => true,
                            'message' => 'You have completed the Withdrawal for '.$claimerUser['User']['eve_name'],
                        );

                        $this->Message->sendLotteryMessage(
                            $claimerUser['User']['id'],
                            'Lottery Completed',
                            'Your prize for one or more lotteries has been delivered by our staff. Please check your wallet or your contracts in game.',
                            $withdrawalGroupId
                        );

                        $this->log('Withdrawal completed : user_name['.$claimerUser['User']['eve_name'].'], user_id['.$claimerUser['User']['id'].'], withdrawal_id['.$withdrawalGroupId.']', 'eve-lotteries');
                    }
                }
            }
            $this->set(compact('data'));
            $this->set('_serialize', 'data');
        }
    }

    public function admin_reserve_award() {
        $userGlobal = $this->Auth->user();
        $this->request->onlyAllow('ajax');

        if ($this->request->is('ajax')) {

            $this->disableCache();
            $this->loadModel('Ticket');

            $withdrawalGroupId = $this->request->query('withdrawal_group_id');

            $claimedAwards = $this->Withdrawal->findAllByGroupId($withdrawalGroupId);
            if (count($claimedAwards)<=0) {
                $data = array('error' => 'Invalid Award.' );
                return;
            }
            else{
                $continue = true;
                foreach ($claimedAwards as $key => $claimedAward) {
                    if($claimedAward['Withdrawal']['status'] != 'claimed'){
                        $data = array('error' => 'Award not claimed.');
                        $continue = false;
                        break;
                    }

                    if(isset($claimedAward['Withdrawal']['admin_id'])){
                        $data = array('error' => 'Award already reserved by an admin.');
                        $continue = false;
                        break;
                    }
                }
                if($continue){
                    $success = $this->Withdrawal->updateAll(
                        array('Withdrawal.admin_id' => $userGlobal['id'], 'Withdrawal.status' => '"reserved"'),
                        array('Withdrawal.group_id' => $withdrawalGroupId)
                    );

                    if ($success) {

                        $data = array (
                            'success' => true,
                            'message' => 'You have reserved the Award',
                        );

                        $this->log('Award reserved : admin_id['.$userGlobal['id'].'], withdrawal_group_id['.$withdrawalGroupId.']', 'eve-lotteries');
                    }
                }
            }
            $this->set(compact('data')); // Pass $data to the view
            $this->set('_serialize', 'data');
        }
    }

    private function _recountAllWithdrawals($user){

        $this->loadModel('SuperLottery');
        $this->loadModel('FlashLottery');

        //maj of withdrawal number
        $parameters = array(
            'conditions' => array(
                'Withdrawal.status' => 'new',
                'Withdrawal.user_id' => $user['id'],
                'Withdrawal.type' => array('award_credit', 'award_isk', 'award_item', 'award')),
        );
        $nbNewAw = $this->Withdrawal->find('count', $parameters);
        $user['nb_new_won_lotteries'] = $nbNewAw;

        //maj of super withdrawal number
        $parameters = array(
            'conditions' => array(
                'SuperLottery.status' => 'unclaimed',
                'SuperLottery.winner_user_id' => $user['id'],
            )
        );
        $nbNewSuperAw = $this->SuperLottery->find('count', $parameters);
        $user['nb_new_won_super_lotteries'] = $nbNewSuperAw;

        //maj of flash withdrawal number
        $parameters = array(
            'conditions' => array(
                'FlashLottery.status' => 'unclaimed',
                'FlashLottery.winner_user_id' => $user['id'],
            )
        );
        $nbNewFlashAw = $this->FlashLottery->find('count', $parameters);
        $user['nb_new_won_flash_lotteries'] = $nbNewFlashAw;

        $this->User->save($user, true, array('id', 'nb_new_won_lotteries', 'nb_new_won_super_lotteries', 'nb_new_won_flash_lotteries'));
    }

    /*
     * Compares the parsed confirmation to the withdrawal fetched in the bdd
     */
    private function _compareConfirmationToWithdrawal($confirmation, $withdraw){

        if($withdraw['Withdrawal']['type'] == 'award_isk'){


            if(($withdraw['Withdrawal']['value'] + $confirmation['amount']) != 0){
                return 'Error in the ISK amount';
            }
            if($withdraw['User']['eve_name'] != $confirmation['userName']){
                return 'Error in the player name, or wrong player awarded!';
            }

        }
        else if($withdraw['Withdrawal']['type'] == 'award_item'){


            if($withdraw['Ticket']['Lottery']['EveItem']['name'] != $confirmation['name']){
                return 'Error in the Item\'s name or wrong Item!';
            }
            if($withdraw['User']['eve_name'] != $confirmation['userName']){
                return 'Error in the player name, or wrong player awarded!';
            }

            return 'ok';


        }

    }

}
