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
	public function admin_index() {
		$this->EveItem->recursive = 0;
		$eveItems = $this->EveItem->find('all');
		$this->set('eveItems', $eveItems);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->EveItem->recursive = 1;
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
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->EveItem->create();
			if ($this->EveItem->save($this->request->data)) {
				$this->Session->setFlash(
					'The eve item has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The eve item could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
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
	public function admin_edit($id = null) {
		$this->EveItem->recursive = 0;
		if (!$this->EveItem->exists($id)) {
			throw new NotFoundException(__('Invalid eve item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EveItem->save($this->request->data)) {
				$this->Session->setFlash(
					'The eve item has been saved.',
					'FlashMessage',
					array('type' => 'success')
					);
				return $this->redirect(array('action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(
					'The eve item could not be saved. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
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
	public function admin_delete($id = null) {
		$this->EveItem->id = $id;
		if (!$this->EveItem->exists()) {
			throw new NotFoundException(__('Invalid eve item'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EveItem->delete()) {
			$this->Session->setFlash(
					'The eve item has been deleted.',
					'FlashMessage',
					array('type' => 'warning')
					);
		} else {
			$this->Session->setFlash(
					'The eve item could not be deleted. Please, try again.',
					'FlashMessage',
					array('type' => 'error')
					);
		}
		return $this->redirect(array('action' => 'index', 'admin' => true));
	}

	public function admin_update_prices() {

		$this->request->onlyAllow('ajax');

		if ($this->request->is('ajax')) {

			$idItem = $this->request->query('idItem');

			$this->disableCache();

			if (!$this->EveItem->exists($idItem)) {
				$data = array('error' => 'Invalid Item.' );
			}
			
			$currentItem = $this->EveItem->findById($idItem);

			$eveId = $currentItem['EveItem']['eve_id'];

			if($currentItem['EveItem']['eve_category_id'] == '69' || $currentItem['EveItem']['eve_category_id'] == '67' || $currentItem['EveItem']['eve_category_id'] == '56'){
				$xml = Xml::build('http://api.eve-central.com/api/marketstat?typeid='.$eveId, array('return' => 'simplexml'));
			}
			else{
				$xml = Xml::build('http://api.eve-central.com/api/marketstat?usesystem=30000142&typeid='.$eveId, array('return' => 'simplexml'));
			}
			

			$currentItem['EveItem']['eve_value'] = (string) $xml->marketstat->type->sell->avg;

			if($currentItem['EveItem']['eve_value'] != 0){
				if ($this->EveItem->save($currentItem)) {
				$data = array (
						'success' => true,
						'message' => 'Item Updated.',
						'itemValue' => number_format($currentItem['EveItem']['eve_value'], 0),
						);
				}
			}
			else{
				$data = array (
						'success' => false,
						'message' => 'Item not Updated.',
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
