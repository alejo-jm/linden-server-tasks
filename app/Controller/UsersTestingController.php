<?php

/**
 * Testing Controller for Users
 *
 */
class UsersTestingController {
	//keep the controller track
	var $controller;

	var $loginDataValid = array(
		'User' => array(
			'email' => 'alejo.jm@gmail.com',
			'password' => '1234',
		)
	);

	var $loginDataBad = array(
		'User' => array(
			'email' => '',
			'password' => '',
		)
	);
	
	public function login($validData=true) {
		return $validData ? $this->loginDataValid : $this->loginDataBad;
	}

	public function generate($validData=true) {
		return $validData ? $this->generateDataValid : $this->generateDataBad;
	}
	
	public function addTask(){
		$data['Task']['name']='My new task';
		$data['Task']['priority_id']='2';
		$data['Task']['due_date']['month']='04';
		$data['Task']['due_date']['day']='05';
		$data['Task']['due_date']['year']='2013';
		$data['Task']['due_date']['hour']='01';
		$data['Task']['due_date']['min']='08';
		$data['Task']['due_date']['meridian']='am';
		return $data;
	}		

}

?>