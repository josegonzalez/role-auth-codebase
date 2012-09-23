<?php
App::uses('AppModel', 'Model');

class Role extends AppModel {

	public $hasAndBelongsToMany = array('User');

}
