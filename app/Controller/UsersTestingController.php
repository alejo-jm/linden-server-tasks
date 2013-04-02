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
	
	public function addFavorite(){
		return array('UsersDeals'=>array(
				'user_uid' => '4fdb9398-e610-4ad9-9710-01399608dbc9',
				'deal_id' => '1',
			)
		);
	}

}

?>