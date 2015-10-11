<?php
App::uses('AppController', 'Controller');
/**
 * Wages Controller
 *
 * @property Wage $Wage
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class WagesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Wage->recursive = 0;

        $paginateVar = array(
            'conditions' => array(''),
            'order' => array(
                'Wage.created' => 'desc'
            ),
            'limit' => 20
        );
        $this->Paginator->settings = $paginateVar;
        $this->set('wages', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->loadModel('Withdrawal');
        if (!$this->Wage->exists($id)) {
            throw new NotFoundException(__('Invalid wage'));
        }
        $options = array('conditions' => array('Wage.' . $this->Wage->primaryKey => $id));
        $wage = $this->Wage->find('first', $options);

        $listWithdrawalIds = explode(",", $wage["Wage"]["withdrawals_array"]);



        $wOptions = array(
            'conditions' => array('Withdrawal.id' => $listWithdrawalIds),
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
        );

        $withdrawals = $this->Withdrawal->find('all', $wOptions);

        $this->set('wage', $wage);
        $this->set('withdrawals', $withdrawals);
    }


    /**
     * Used by a manager to claim his wages
     * @param null $id
     * @throws Exception
     */
    public function claim($id = null) {

        if (!$this->Wage->exists($id)) {
            throw new NotFoundException(__('Invalid wage'));
        }

        $options = array('conditions' => array('Wage.' . $this->Wage->primaryKey => $id));
        $wage = $this->Wage->find('first', $options);

        $wage["Wage"]["status"] = 'claimed';

        $this->Wage->save($wage, true, array('id', 'status'));

        return $this->redirect(array('action' => 'index', 'admin' => false));
    }


    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $userGlobal = $this->Auth->user();
        $this->Wage->recursive = 0;

        $params = array(
            'conditions' => array('Wage.status' => array('reserved'), 'Wage.admin_id' => $userGlobal['id']),
            'limit' => 1
        );
        $reserved_wage = $this->Wage->find('first', $params);

        $this->set('reserved_wage', $reserved_wage);

        $paginateVar = array(
            'conditions' => array('Wage.status' => array('claimed', 'unclaimed')),
            'limit' => 1
        );
        $this->Paginator->settings = $paginateVar;
        $this->set('wages', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->loadModel('Withdrawal');
        $this->Wage->recursive = 0;
        if (!$this->Wage->exists($id)) {
            throw new NotFoundException(__('Invalid wage'));
        }
        $options = array(
            'conditions' => array('Wage.' . $this->Wage->primaryKey => $id),
            'contain' => array(
                'Recipient',
                'Admin',
            ));
        $wage = $this->Wage->find('first', $options);

        $listWithdrawalIds = explode(",", $wage["Wage"]["withdrawals_array"]);



        $wOptions = array(
            'conditions' => array('Withdrawal.id' => $listWithdrawalIds),
            'contain' => array(
                'User',
                'Ticket' => array(
                    'Lottery' => array(
                        'EveItem' => array('EveCategory')
                    )
                ),
            ),
        );

        $withdrawals = $this->Withdrawal->find('all', $wOptions);

        $this->set('wage', $wage);
        $this->set('withdrawals', $withdrawals);
    }


    /**
     * Function activated when a manager tries to complete a withdrawal
     */
    public function admin_complete() {
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
    public function admin_reserve_one() {
        $manager = $this->Auth->user();

        // a manager can only have one reserved award at a time
        $params = array(
            'conditions' => array(
                'Wage.status' => 'reserved',
                'Wage.admin_id' => $manager['id']
            )
        );
        $reserved_award = $this->Wage->find('all', $params);
        if(!empty($reserved_award)){
            $this->Session->setFlash(
                'You already have a reserved wage!',
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        //search for the last withdrawal
        $params = array(
            'conditions' => array('Wage.status' => array('claimed')),
            'order' => array(
                'Wage.modified' => 'asc'
            )
        );
        $award = $this->Wage->find('first', $params);

        //if there is no withdrawal to reserve
        if(empty($award)){
            $this->Session->setFlash(
                'No wage to reserve!',
                'FlashMessage',
                array('type' => 'warning')
            );
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }

        $this->Wage->updateAll(
            array(
                'Wage.admin_id' => $manager['id'],
                'Wage.status' => "'reserved'"),
            array(
                'Wage.id' => $award['Wage']['id']
            )
        );

        $this->Session->setFlash(
            "You reserved a manager's wage.",
            'FlashMessage',
            array('type' => 'info')
        );

        return $this->redirect(array('action' => 'index', 'admin' => true));
    }

    public function admin_cancel_reservation() {
        $manager = $this->Auth->user();

        $this->Wage->updateAll(
            array(
                'Wage.admin_id' => null,
                'Wage.status' => "'claimed'"),
            array(
                'Wage.admin_id' => $manager['id'],
                'Wage.status' => "reserved"
            )
        );

        $this->Session->setFlash(
            'Reservation canceled !',
            'FlashMessage',
            array('type' => 'info')
        );

        return $this->redirect(array('action' => 'index', 'admin' => true));
    }
    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Wage->id = $id;
        if (!$this->Wage->exists()) {
            throw new NotFoundException(__('Invalid wage'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Wage->delete()) {
            $this->Session->setFlash(__('The wage has been deleted.'));
        } else {
            $this->Session->setFlash(__('The wage could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
