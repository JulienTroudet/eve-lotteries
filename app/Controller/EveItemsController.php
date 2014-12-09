<?php
App::uses('AppController', 'Controller', 'Xml', 'Utility');

/**
 * EveItems Controller
 *
 * @property EveItem $EveItem
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EveItemsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->EveItem->recursive = 0;
		$this->set('eveItems', $this->Paginator->paginate());
	}

	/**
	 * chooseItem method
	 *
	 * @return void
	 */
	public function chooseItem() {
		$this->EveItem->recursive = 0;
		$this->set('eveItems', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->EveItem->exists($id)) {
			throw new NotFoundException(__('Invalid eve item'));
		}
		$options = array('conditions' => array('EveItem.' . $this->EveItem->primaryKey => $id));
		$this->set('eveItem', $this->EveItem->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EveItem->create();
			if ($this->EveItem->save($this->request->data)) {
				$this->Session->setFlash(__('The eve item has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eve item could not be saved. Please, try again.'));
			}
		}
		$eveCategories = $this->EveItem->EveCategory->find('list');
		$this->set(compact('eveCategories'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->EveItem->exists($id)) {
			throw new NotFoundException(__('Invalid eve item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EveItem->save($this->request->data)) {
				$this->Session->setFlash(__('The eve item has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eve item could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EveItem.' . $this->EveItem->primaryKey => $id));
			$this->request->data = $this->EveItem->find('first', $options);
		}
		$eveCategories = $this->EveItem->EveCategory->find('list');
		$this->set(compact('eveCategories'));
		$this->set('eveItem', $this->EveItem->find('first', $options));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->EveItem->id = $id;
		if (!$this->EveItem->exists()) {
			throw new NotFoundException(__('Invalid eve item'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EveItem->delete()) {
			$this->Session->setFlash(__('The eve item has been deleted.'));
		} else {
			$this->Session->setFlash(__('The eve item could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function update_prices() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {

			$idItem = $this->request->query('idItem');

			$this->disableCache();

			if (!$this->EveItem->exists($idItem)) {
				$data = array('error' => 'Invalid Item.' );
			}
			
			$currentItem = $this->EveItem->findById($idItem);

			$eveId = $currentItem['EveItem']['eve_id'];

			$xml = Xml::build('http://api.eve-central.com/api/marketstat?typeid='.$eveId, array('return' => 'simplexml'));

			$currentItem['EveItem']['eve_value'] = (string) $xml->marketstat->type->sell->avg;

			if ($this->EveItem->save($currentItem)) {
				$data = array (
						'success' => true,
						'message' => 'Ticket bought.',
						'itemValue' => number_format($currentItem['EveItem']['eve_value'], 0),
						);
			}

			$this->set(compact('data')); // Pass $data to the view
			$this->set('_serialize', 'data');

		}


	}

	// public function updateAllPrices() {
	// 	$params = array(
	// 		'recursive' => -1, 
	// 		'fields' => array('EveItem.id', 'EveItem.eve_id'),
	// 		'limit' => 10,
	// 		);
	// 	$listIds = $this->EveItem->find('list', $params);
	// 	foreach ($listIds as $id => $eveId) {
	// 		$currentItem = $this->EveItem->findById($id);
	// 		$xml = Xml::build('http://api.eve-central.com/api/marketstat?typeid='.$eveId, array('return' => 'simplexml'));
	// 		$currentItem['EveItem']['eve_value'] = (string) $xml->marketstat->type->all->median;
	// 		if ($this->EveItem->save($currentItem)) {
	// 			debug($currentItem); 
	// 		}
	// 	}
	// 	die();
	// }
}
