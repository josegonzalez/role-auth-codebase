<?php
App::uses('AppController', 'Controller');

class PostsController extends AppController {

/*
 * Turn on scaffold so I don't have to fake out all those actions
 */
	public $scaffold = true;

/*
 * In CakePHP 2.x, you can define a _getScaffold() method that is
 * triggered when the action does not exist on the controller. Just
 * set `public $scaffold = true` to make it all work :)
 */
	protected function _getScaffold(CakeRequest $request) {
		echo json_encode(array(
			'access' => 'allowed',
			'controller' => $request->params['controller'],
			'action' => $request->params['action'],
		));
		return $this->_stop();
	}

/*
 * Our custom rules are as follows:
 * - Posts::index
 * - Posts::view
 * - Posts::add
 * - Posts::edit
 * - Posts::delete
 */
	public function isAuthorized() {
		$currentUser = $this->_refreshUser(true);
		if (!$currentUser) {
			return false;
		}

		$roles = Hash::extract((array) $currentUser, 'Role.{n}.name');
		$check = "{$this->params['controller']}::{$this->params['action']}";
		$user = $this->_refreshUser();
		return in_array($check, $roles);
	}

}
