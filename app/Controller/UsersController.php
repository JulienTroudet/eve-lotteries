<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'Auth');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow('logout', 'login', 'forbidden', 'eve_login', 'initDB');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->User->recursive = 0;
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data, true, array('group_id', 'wallet', 'tokens'))) {
				$this->Session->setFlash(
					'The user has been saved.',
					'FlashMessage',
					array('type' => 'info')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The user could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(
				'The user has been deleted.',
				'FlashMessage',
				array('type' => 'info')
				);
		} else {
			$this->Session->setFlash(
				'The user could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}

	public function login() {
		$this->Session->setFlash('Please Log in !', 'FlashMessage', array('type' => 'warning'));
		return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
	}

	public function forbidden() {
		$this->Session->setFlash('You don\'t have the right to go there !', 'FlashMessage', array('type' => 'warning'));
		return $this->redirect(array('controller' => 'lotteries', 'action' => 'index', 'admin' => false));
	}

	public function logout() {

		$this->Session->setFlash(
			'Log out done. Good bye !',
			'FlashMessage',
			array('type' => 'info')
			);
		$this->Cookie->destroy();
		$this->redirect($this->Auth->logout());
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function user_navbar() {
		$this->layout = false;
	}

	public function eve_login() {
		$code = $this->params['url']['code'];
		$state = $this->params['url']['state'];

		if(isset($code) && isset($state)){

			$sessionState = $this->Session->read('User.antiForgeryToken');
			if($state == $sessionState){

				$this->loadModel('Config');
				$this->loadModel('Statistic');

				$eveSSO_URL = $this->Config->findByName('eve_sso_url');
				$eveSSO_URL = $eveSSO_URL['Config']['value'];
				$appEveId = $this->Config->findByName('app_eve_id');
				$appEveId = $appEveId['Config']['value'];
				$appEveSecret = $this->Config->findByName('app_eve_secret');
				$appEveSecret = $appEveSecret['Config']['value'];

				App::uses('HttpSocket', 'Network/Http');

				$HttpSocket = new HttpSocket();

				$autorisation = base64_encode($appEveId.':'.$appEveSecret);

				$options = array(
					'header' => array(
					//'Content-Type' => 'application/x-www-form-urlencoded',
					//'Host' => 'login.eveonline.com',
						'Authorization' => 'Basic '.$autorisation
						),
					'version' => '1.1',
					);


				$data = array('grant_type' => 'authorization_code', 'code' => $code);

				$results = $HttpSocket->post($eveSSO_URL.'token', $data, $options);

				$obj = json_decode($results,true);

				$options = array(
					'header' => array(
					//'Content-Type' => 'application/x-www-form-urlencoded',
					//'Host' => 'login.eveonline.com',
						'Authorization' => 'Bearer '.$obj['access_token'],
						),
					'version' => '1.1',
					);

				$results = $HttpSocket->get($eveSSO_URL.'verify', null, $options);

				$responseArray = json_decode($results,true);


				$this->_connectPlayer($responseArray);
			}
			else{
				$this->Session->setFlash('Login error !', 'FlashMessage', array('type' => 'error'));
				return $this->redirect("/");
			}
		}
	}

	protected function _connectPlayer($responseArray) {

		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash(
				'Already logged !',
				'FlashMessage',
				array('type' => 'info')
				);
		}

		if (isset($responseArray)) {
			if (isset($responseArray['CharacterID'])) {
				$this->User->id = $responseArray['CharacterID'];

				if (!$this->User->exists()) {
					$this->User->create();
					$newUser = array('User' => array(
						'id' => $responseArray['CharacterID'],
						'group_id' => 4,
						'eve_name' => $responseArray['CharacterName'],
						'wallet' => 0,
						'tokens' => 0,
						'owner_hash' => $responseArray['CharacterOwnerHash'],
						)
					);
					$this->User->save($newUser, true, array('id', 'eve_name', 'group_id', 'wallet', 'tokens', 'owner_hash' ));
					if ($this->Auth->login($newUser['User'])) {

						$this->Statistic->saveStat($newUser['User']['id'], 'connection', 'first', null, null);

						$this->Session->setFlash(
							'First Login succcessfull !',
							'FlashMessage',
							array('type' => 'success')
							);
						//$this->_setCookie($this->Auth->user('id'));
						return $this->redirect("/");
					}
				}
				else{
					$user = $this->User->findById($responseArray['CharacterID']);
					if ($this->Auth->login($user['User'])) {

						$this->Statistic->saveStat($user['User']['id'], 'connection', null, null, null);

						$this->Session->setFlash(
							'Login succcessfull !',
							'FlashMessage',
							array('type' => 'info')
							);
						//$this->_setCookie($this->Auth->user('id'));
						return $this->redirect("/");
					}
				}
				//
				return $this->redirect("/");
			}

			else if (isset($responseArray['error'])) {
				$this->Session->setFlash(
					'Error with the authentification : '.$responseArray['error_description'],
					'FlashMessage',
					array('type' => 'error')
					);
			}
		}
	}

	protected function _setCookie($id) {

		if (!$this->request->data('User.remember_me')) {
			return false;
		}

		$loggedUser = $this->User->findById($id);
		$date = new DateTime();

		$token = Security::hash($loggedUser['User']['username'].$date->format('Y-m-d H:i:s'), 'sha1', true);

		$loggedUser['User']['cookie_value'] = $token;

		if( $this->User->save($loggedUser, true, array('id', 'cookie_value')) ){

			$data = array(
				'user' => $id,
				'token' => $token
				);

			$this->Cookie->write('User', $data, true, '+2 week');
			return true;
		}
		return false;	
	}


	public function initDB() {

		$group = $this->User->Group;

		$this->log($group);

    // Allow admins to everything
		$group->id = 3;
		$this->Acl->allow($group, 'controllers');


    // allow users to only add and edit on posts and widgets
		$group->id = 4;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Users/user_navbar');
		$this->Acl->allow($group, 'controllers/Lotteries/list_lotteries');
		$this->Acl->allow($group, 'controllers/Messages/index');
		$this->Acl->allow($group, 'controllers/Messages/delete');
		$this->Acl->allow($group, 'controllers/Tickets/buy');
		$this->Acl->allow($group, 'controllers/Tickets/buy_firsts');
		$this->Acl->allow($group, 'controllers/SuperLotteryTickets/buy');
		$this->Acl->allow($group, 'controllers/SuperLotteries/claim');
		$this->Acl->allow($group, 'controllers/Transactions/index');
		$this->Acl->allow($group, 'controllers/Withdrawals/index');
		$this->Acl->allow($group, 'controllers/Withdrawals/view');
		$this->Acl->allow($group, 'controllers/Withdrawals/list_awards');
		$this->Acl->allow($group, 'controllers/Withdrawals/list_super_awards');
		$this->Acl->allow($group, 'controllers/Withdrawals/old_list');
		$this->Acl->allow($group, 'controllers/Withdrawals/claim');
		$this->Acl->allow($group, 'controllers/Awards/index');
		$this->Acl->allow($group, 'controllers/UserAwards/claim');

		// $group->id = 5;
		// $this->Acl->deny($group, 'controllers');
		// $this->Acl->allow($group, 'controllers/Users/user_navbar');
		// $this->Acl->allow($group, 'controllers/Lotteries/list_lotteries');
		// $this->Acl->allow($group, 'controllers/Tickets/buy');
		// $this->Acl->allow($group, 'controllers/Tickets/buy_firsts');
		// $this->Acl->allow($group, 'controllers/SuperLotteryTickets/buy');
		// $this->Acl->allow($group, 'controllers/Transactions/index');
		// $this->Acl->allow($group, 'controllers/Withdrawals/index');
		// $this->Acl->allow($group, 'controllers/Withdrawals/list_awards');
		// $this->Acl->allow($group, 'controllers/Withdrawals/old_list');
		// $this->Acl->allow($group, 'controllers/Withdrawals/claim');
		// $this->Acl->allow($group, 'controllers/Awards/index');
		// $this->Acl->allow($group, 'controllers/UserAwards/claim');

		// $this->Acl->allow($group, 'controllers/Withdrawals/list_awards');
		// $this->Acl->allow($group, 'controllers/Withdrawals/old_list');
		
    // we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
	}
}
