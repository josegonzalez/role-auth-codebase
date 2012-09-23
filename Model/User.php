<?php
App::uses('AppModel', 'Model');

class User extends AppModel {

	public $hasAndBelongsToMany = array('Role');

	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A username is required'
			)
		),
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
			)
		),
		'first_name' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A first name is required'
			)
		),
		'last_name' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A last name is required'
			)
		),
	);

	public function add($data = null, $validate = true, $fieldList = array()) {
		if (!class_exists('AuthComponent')) {
			throw new InternalErrorException('AuthComponent not properly setup');
		}

		if (isset($data[$this->alias]['password'])) {
      $data[$this->alias]['password'] = AuthComponent::password($data[$this->alias]['password']);
    }

		$this->create();
		return $this->save($data, $validate, $fieldList);
	}

}
