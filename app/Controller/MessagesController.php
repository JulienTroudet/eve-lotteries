<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MessagesController extends AppController {

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
		$userGlobal = $this->Auth->user();
		$this->loadModel('User');

		$paginateVar = array(
			'conditions' => array('Message.user_id' => $userGlobal['id']),
			'order' => array(
				'Message.created' => 'desc'
				),
			'limit' => 20
			);
		$this->Paginator->settings = $paginateVar;
		$messages = $this->Paginator->paginate('Message');
		$this->set('messages', $messages);


		$this->Message->updateAll(
			array('Message.status' => "'read'"),
			array('Message.user_id' => $userGlobal['id'])
			);

		$this->User->id = $userGlobal['id'];
		$this->User->saveField('nb_new_messages', 0);
	}


	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$userGlobal = $this->Auth->user();
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid Message'));
		}

		$message = $this->Message->findById($id);

		if($message['Message']['user_id'] != $userGlobal['id']){
			$this->Session->setFlash(
				'This is not one of your messages.',
				'FlashMessage',
				array('type' => 'error')
				);
			return $this->redirect(array('action' => 'index', 'admin' => false));
		}

		$this->request->allowMethod('get', 'delete');
		if ($this->Message->delete()) {
			$this->Session->setFlash(
				'The message has been deleted.',
				'FlashMessage',
				array('type' => 'success')
				);
		} else {
			$this->Session->setFlash(
				'The message could not be deleted. Please, try again.',
				'FlashMessage',
				array('type' => 'error')
				);
		}
		return $this->redirect(array('action' => 'index', 'admin' => false));
	}


    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete_all() {
        $userGlobal = $this->Auth->user();


        $this->request->allowMethod('get', 'delete');

        if ($this->Message->deleteAll(array('Message.user_id' => $userGlobal["id"]), false)) {
            $this->Session->setFlash(
                'All messages have been deleted.',
                'FlashMessage',
                array('type' => 'success')
            );
        } else {
            $this->Session->setFlash(
                'The messages could not be deleted. Please, try again.',
                'FlashMessage',
                array('type' => 'error')
            );
        }
        return $this->redirect(array('action' => 'index', 'admin' => false));
    }
}
