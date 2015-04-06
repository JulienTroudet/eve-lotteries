<?php
App::uses('AppController', 'Controller');
/**
 * BannedIps Controller
 *
 * @property BannedIp $BannedIp
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BannedIpsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BannedIp->recursive = 0;
		$this->set('bannedIps', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BannedIp->exists($id)) {
			throw new NotFoundException(__('Invalid banned ip'));
		}
		$options = array('conditions' => array('BannedIp.' . $this->BannedIp->primaryKey => $id));
		$this->set('bannedIp', $this->BannedIp->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BannedIp->create();
			if ($this->BannedIp->save($this->request->data)) {
				$this->Session->setFlash(__('The banned ip has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banned ip could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->BannedIp->exists($id)) {
			throw new NotFoundException(__('Invalid banned ip'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BannedIp->save($this->request->data)) {
				$this->Session->setFlash(__('The banned ip has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banned ip could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BannedIp.' . $this->BannedIp->primaryKey => $id));
			$this->request->data = $this->BannedIp->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->BannedIp->id = $id;
		if (!$this->BannedIp->exists()) {
			throw new NotFoundException(__('Invalid banned ip'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->BannedIp->delete()) {
			$this->Session->setFlash(__('The banned ip has been deleted.'));
		} else {
			$this->Session->setFlash(__('The banned ip could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
