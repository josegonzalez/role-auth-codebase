<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('logout'));
	}

	public function isAuthorized() {
		return true;
	}

	public function login() {
		if (!$this->request->is('post')) {
			return;
		}

		if (!$this->Auth->login()) {
			return $this->Session->setFlash(__('Username or password is incorrect'));
		}

		return $this->redirect($this->Auth->redirect());
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function dashboard() {
		$actions = array('index', 'view', 'add', 'edit', 'delete');
		$this->set(compact('actions'));
	}

	public function add() {
		if (!$this->request->is('post')) {
			return;
		}

		if ($this->User->add($this->request->data)) {
			$this->Session->setFlash(__('The user has been saved'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
	}

}
