<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $components = array('Auth', 'Session');

/*
 * Setup AuthComponent
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			AuthComponent::ALL => array(
				'userModel' => 'User',
				'contain' => array('Role'),
				'recursive' => 1,
			),
			'Form',
		);
		$this->Auth->authError = __d('users', 'You do not have access to that section');
		$this->Auth->loginAction = array('plugin' => null, 'controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('plugin' => null, 'controller' => 'users', 'action' => 'dashboard');
		$this->Auth->logoutRedirect = array('plugin' => null, 'controller' => 'users', 'action' => 'login');
		$this->Auth->authorize = array('Controller');
	}

/**
 * Custom method to refresh the current user from the db
 *
 * @param $overwrite boolean Overwrite the current user session
 * @return array currently logged in user from db
 */
	protected function _refreshUser($overwrite = false) {
		$settings = Hash::merge(array(
			'fields' => array(
				'username' => 'username',
				'password' => 'password'
			),
			'userModel' => 'User',
			'scope' => array(),
			'recursive' => 0,
			'contain' => null,
		), $this->Auth->authenticate[AuthComponent::ALL]);

		list($plugin, $modelName) = pluginSplit($settings['userModel']);
		if (!class_exists($modelName)) {
			$this->loadModel($settings['userModel']);
		}

		$primaryKey = $this->$modelName->primaryKey;
		$user_id = $this->Auth->user($primaryKey);
		if (empty($user_id)) {
			return false;
		}

		$conditions = array_merge(array(
			"{$modelName}.{$primaryKey}" => $user_id
		), $settings['scope']);

		$result = $this->$modelName->find('first', array(
			'conditions' => $conditions,
			'recursive' => (int) $settings['recursive'],
			'contain' => $settings['contain'],
		));

		if (empty($result) || empty($result[$modelName])) {
			return false;
		}

		$user = $result[$modelName];
		unset($user[$settings['fields']['password']]);
		unset($result[$modelName]);
		$result = array_merge($user, $result);

		if ($overwrite === true) {
			$this->Session->renew();
			$this->Session->write(AuthComponent::$sessionKey, $result);
		}

		return $result;
	}

}
