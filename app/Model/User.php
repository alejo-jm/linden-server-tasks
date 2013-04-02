<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Task $Task
 */
class User extends AppModel {

/**
 * containable behavior
 * @var    array
 * @author Alejo JM <alejo.jm@gmail.com>
 */
	var $actsAs=array('Containable');
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';

/**
 * Validatations rules
 * @var array
 * @author Alejo JM <alejo.jm@gmail.com>
 */
	public $validate = array(
		'email' => array(
		  'isUnique' => array(
			'rule'     => 'isUnique',
			'required' => true,
			'message'  => 'the email exists, try with another one'
		  ),
		  'email' => array(
			'rule'     => 'email',
			'required' => true,
			'message'  => 'this field is required'
		  )
		),
		'password' => array(
		  'notEmpty' => array(
			'rule'     => 'notEmpty',
			'required' => true,
			'message'  => 'this field is required'
		  ),
		),
		'repeat-password' => array(
		  'notEmpty' => array(
			'rule'     => 'notEmpty',
			'required' => true,
			'message'  => 'this field is required'
		  ),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

		/**
	 * hash the password using sha1 
	 * @return [type] [description]
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	function beforeSave(){

		if(@$this->data[$this->name]['password'] != @$this->data[$this->name]['repeat-password']){
			$this->invalidate('repeat-password', 'The passwords are different');
			$this->invalidate('password', 'The passwords are different');
			return false;
		}

		if (!empty($this->data[$this->name]['password']) && $this->data[$this->name]['password'] == $this->data[$this->name]['repeat-password']) {
			$this->data[$this->name]['password'] = sha1($this->data[$this->name]['password']);
			$this->data[$this->name]['uid'] = String::uuid();
		} else
			unset($this->data[$this->name]['password']);

		return true;
	}

}
