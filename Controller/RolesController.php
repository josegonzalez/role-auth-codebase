<?php
App::uses('AppController', 'Controller');

class RolesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function index() {
		$this->set('users', $this->paginate());
	}

	public function view($id = null) {
		$role = $this->_getUser($id);
		$this->set(compact('role'));
	}

	public function add() {
		if (!$this->request->is('post')) {
			return;
		}

		$this->Role->create();
		if ($this->Role->save($this->request->data)) {
			$this->Session->setFlash(__('The user has been saved'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
	}

	public function edit($id = null) {
		$role = $this->_getUser($id);

		if (!$this->request->is('post') && !$this->request->is('put')) {
			return $this->request->data = $role;
		}

		if ($this->Role->save($this->request->data)) {
			$this->Session->setFlash(__('The user has been saved'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$role = $this->_getUser($id);
		if ($this->Role->delete($role['Role']['id'])) {
			$this->Session->setFlash(__('Role deleted'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('Role was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

	protected function _getUser($id = null) {
		if (empty($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		$role = $this->Role->findById($id);
		if (empty($role)) {
			throw new NotFoundException(__('Invalid user'));
		}

		return $role;
	}

}
