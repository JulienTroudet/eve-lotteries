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
		$this->Auth->allow('login', 'logout', 'register', 'activate', 'password_reinit', 'initDB');
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
			if ($this->User->save($this->request->data)) {
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
		if ($this->Session->read('Auth.User')) {

			$this->Session->setFlash(
				'Already logged !',
				'FlashMessage',
				array('type' => 'info')
				);
			$this->redirect('/');
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->setFlash(
					'Login succcessfull !',
					'FlashMessage',
					array('type' => 'info')
					);
				$this->_setCookie($this->Auth->user('id'));
				return $this->redirect("/");
			}
			$this->Session->setFlash(
				'Your username or password was incorrect.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
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

	public function register(){
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash(
				'You are logged in!',
				'FlashMessage',
				array('type' => 'success')
				);
			return $this->redirect('/');
		}
		if (!empty($this->data)){
			if ($this->data['User']['password'] == $this->data['User']['password_confirm']){

				if ($this->data['User']['mail'] == $this->data['User']['mail_confirm']){
					$dataProxy = $this->data;

					$dataProxy['User']['group_id'] = 4;
					$this->log($dataProxy);
					$this->User->create();
					if($this->User->save($dataProxy, true, array('username', 'password', 'mail', 'eve_id', 'eve_name', 'group_id'))) {

						$linkActivation = array('controller'=>'users', 'action' => 'activate', $this->User->id.'__'.md5($dataProxy['User']['eve_id']));

						App::uses('CakeEmail', 'Network/Email');

						$mail = new CakeEmail();
						$mail->from('noreplay@eve-lotteries.com')
						->to($dataProxy['User']['mail'])
						->subject('EVE-Lotteries :: Registration')
						->emailFormat('html')
						->template('signup')
						->viewVars(array('username'=>$dataProxy['User']['username'], 'linkActivation' => $linkActivation))
						->send();


						$this->Session->setFlash(
							'Registration complete ! Please check your mails to activate your account.',
							'FlashMessage',
							array('type' => 'success')
							);

						$this->redirect($this->Auth->logout());
					}
					else{
						$this->Session->setFlash(
							'Error in account creation.',
							'FlashMessage',
							array('type' => 'error')
							);
					}
				}
				else{
					$this->Session->setFlash(
						'Error in Mail confirmation.',
						'FlashMessage',
						array('type' => 'error')
						);
				}
			}
			else{
				$this->Session->setFlash(
					'Error in Password confirmation.',
					'FlashMessage',
					array('type' => 'error')
					);
			}
		}
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function user_navbar() {
		$this->layout = false;
	}

	public function activate($token){

		$token = explode('__', $token);

		$this->log($token);

		$user = $this->User->find('first', array(
			'conditions' => array('id'=>$token[0], 'MD5(User.eve_id)' => $token[1], 'active' => 0)
			)
		);
		if(!empty($user)){

			$this->User->id = $user['User']['id'];
			$this->User->saveField('active', 1);

			$this->Session->setFlash(
				'Activation complete ! Please log in.',
				'FlashMessage',
				array('type' => 'success')
				);
		}
		else{
			$this->Session->setFlash(
				'Your activation link is not valid !',
				'FlashMessage',
				array('type' => 'warning')
				);
		}
		$this->Auth->login($user['User']);
		$this->redirect('/');
	}

	public function edit(){
		$userGlobal = $this->Auth->user();
		$this->User->id = $userGlobal['id'];
		$passModif = false;
		$mailModif = false;
		$passError = false;
		$mailError = false;
		


		if($this->request->is('post')){

			$dataProxy = $this->request->data;
			$dataProxy['User']['id'] = $userGlobal['id'];

			$this->log($dataProxy);

			if (!empty($dataProxy['User']['password_confirm'])){
				$passModif = true;
				if ($dataProxy['User']['password'] == $dataProxy['User']['password_confirm']){
					$dataProxy['User']['password'] = $dataProxy['User']['password'];
				}
				else{
					unset($dataProxy['User']['password']);
					$passError = true;
				}
			}

			if (!empty($dataProxy['User']['mail_confirm'])){
				$mailModif = true;
				if ($dataProxy['User']['mail'] == $dataProxy['User']['mail_confirm']){
					$dataProxy['User']['mail'] = $dataProxy['User']['mail'];
				}
				else{
					unset($dataProxy['User']['mail']);
					$mailError = true;
				}
			}
			if($passError){
				$this->User->validationErrors['password_confirm'] = array('Error in Password confirmation');
			}
			if($mailError){
				$this->User->validationErrors['mail_confirm'] = array('Error in Mail confirmation');
			}
			if(!$passError && !$mailError && ($passModif || $mailModif)){
				if($this->User->save($dataProxy['User'], true, array('id', 'password', 'mail'))) {

					$this->Session->setFlash(
						'You have successfully edited your account !',
						'FlashMessage',
						array('type' => 'success')
						);

					$this->redirect('/');
				}
				else{
					$this->Session->setFlash(
						'Error with the account edition.',
						'FlashMessage',
						array('type' => 'warning')
						);
				}
			}			
		}
		else{
			$this->request->data = $this->User->read('mail');
		}
	}

	public function password_reinit(){

		if(!empty($this->request->params['named']['token'])){
			$token = explode('__', $this->request->params['named']['token']);

			$user = $this->User->find('first', array(
				'conditions' => array('id'=>$token[0], 'MD5(User.password)' => $token[1], 'active' => 1)
				)
			);
			if(!empty($user)){

				$this->User->id = $user['User']['id'];

				$newPassword = substr(md5(uniqid(rand(), true)), 0, 8);

				$user['User']['password'] = $newPassword;

				$this->User->save($user, true, array('id', 'password'));

				App::uses('CakeEmail', 'Network/Email');
				
				$mail = new CakeEmail();
				$mail->from('noreplay@eve-lotteries.com')
				->to($user['User']['mail'])
				->subject('EVE-Lotteries :: New Password')
				->emailFormat('html')
				->template('nmdp')
				->viewVars(array('username'=>$user['User']['username'], 'newPassword' => $newPassword))
				->send();

				$this->Session->setFlash(
					'Your new password has been sent to you by email !',
					'FlashMessage',
					array('type' => 'success')
					);
			}
			else{
				$this->Session->setFlash(
					'Your recovery link is not valid !',
					'FlashMessage',
					array('type' => 'warning')
					);
			}
		}

		if($this->request->is('post')){
			$dataProxy = $this->request->data;
			$user = $this->User->find('first', array(
				'condition' => array('mail' => $dataProxy['User']['mail'], 'active' => 1),
				)
			);

			if(empty($user)){
				$this->Session->setFlash(
					'No user with this mail !',
					'FlashMessage',
					array('type' => 'warning')
					);
			}
			else{
				App::uses('CakeEmail', 'Network/Email');

				$linkRecovery = array('controller'=>'users', 'action' => 'password_reinit', 'token' => $user['User']['id'].'__'.md5($user['User']['password']));

				$mail = new CakeEmail();
				$mail->from('noreplay@eve-lotteries.com')
				->to($user['User']['mail'])
				->subject('EVE-Lotteries :: Password recovery')
				->emailFormat('html')
				->template('mdp')
				->viewVars(array('username'=>$user['User']['username'], 'linkRecovery' => $linkRecovery))
				->send();

				$this->Session->setFlash(
					'The mail has been sent !',
					'FlashMessage',
					array('type' => 'success')
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
		$this->Acl->allow($group, 'controllers');

    // allow basic users to log out
		$this->Acl->allow($group, 'controllers/Users/edit');

		$this->Acl->allow($group, 'controllers/Configs/update_api_check');
		$this->Acl->allow($group, 'controllers/Lotteries/list_lotteries');
		$this->Acl->allow($group, 'controllers/Lotteries/old_list');
		$this->Acl->allow($group, 'controllers/Tickets/buy');
		$this->Acl->allow($group, 'controllers/Transactions');
		
		$this->Acl->allow($group, 'controllers/Withdrawals/index');
		$this->Acl->allow($group, 'controllers/Withdrawals/old_list');
    // we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
	}
}
