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
		if (!$this->Wage->exists($id)) {
			throw new NotFoundException(__('Invalid wage'));
		}
		$options = array('conditions' => array('Wage.' . $this->Wage->primaryKey => $id));
		$this->set('wage', $this->Wage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function claim() {

        return $this->redirect(array('action' => 'index', 'admin' => false));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Wage->recursive = 0;
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
		if (!$this->Wage->exists($id)) {
			throw new NotFoundException(__('Invalid wage'));
		}
		$options = array('conditions' => array('Wage.' . $this->Wage->primaryKey => $id));
		$this->set('wage', $this->Wage->find('first', $options));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_complete($id = null) {
		if (!$this->Wage->exists($id)) {
			throw new NotFoundException(__('Invalid wage'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Wage->save($this->request->data)) {

			} else {

			}
		}


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
