<?php


/**
 * Create unique hash by user login
 *
 * @package default
 * @author Alejandro jiménez alejo.jm@gmail.com
 */
class AuthorizeComponent extends Component
{
	var $secret = '';
	var $desc  = array();
	var $components = array('Session');
	var $Model = 'User';
	var $field = 'uid';
	var $superUser = 'Admin';

	function initialize() 
	{
		$this->desc = array('host'=>$_SERVER['SERVER_NAME'], 'br'=>$_SERVER['HTTP_USER_AGENT'], 'ip'=>$_SERVER['REMOTE_ADDR']);
		$this->secret = Configure::read('Security.salt');
		$this->Model = ClassRegistry::init($this->Model);
	}
	
	function login($name, $value)
	{
		//write session, the name and value is only one is not hashed
		$this->Session->write($name, $value);
		
		//one by one
		$s['name']   = sha1($value);
		$s['host']   = sha1($this->desc['host']);
		$s['br']     = sha1($this->desc['br']);
		$s['ip']     = sha1($this->desc['ip']);
		$s['secret'] = sha1($this->secret);
		
		$this->Session->write('hash'.$name, sha1($s['name'].$s['host'].$s['br'].$s['ip'].$s['secret']));
	}
	
	function loggedIn($name)
	{
		if($this->isSuper())
			return true;
		
		if(!$this->Session->read('hash'.$name))
			return false;

		if(!$this->Session->read($name))
			return false;
		
		//find the user
		$find = 'findBy'.ucFirst($this->field);
		$someone = $this->Model->$find($this->Session->read($name));
		if(!isset($someone[$this->Model->name][$this->field]))
			return false;
		
		$sField = $someone[$this->Model->name][$this->field];

		//one by one
		$s['name']   = sha1($sField);
		$s['host']   = sha1($this->desc['host']);
		$s['br']     = sha1($this->desc['br']);
		$s['ip']     = sha1($this->desc['ip']);
		$s['secret'] = sha1($this->secret);

		//all hash in the session
		$hash = $this->Session->read('hash'.$name);
		
		//they most be the same
		if($hash != sha1($s['name'].$s['host'].$s['br'].$s['ip'].$s['secret']))
			return false;

		return true;
	}
	
	
	function getUser($name){
		
		$someone = $this->Session->read($name);

		//maybe is a superUser
		if(empty($someone))
			$someone = $this->Session->read($this->superUser);
		
		if(empty($someone))
			return false;
		
		return $someone;
	}

	function isSuper()
	{
		if(!$this->Session->read('hash'.$this->superUser))
			return false;

		if(!$this->Session->read($this->superUser))
			return false;
		
		//find the user
		$find = 'findBy'.ucFirst($this->field);
		$someone = $this->Model->$find($this->Session->read($this->superUser));
		if(!isset($someone[$this->Model->name][$this->field]))
			return false;
		
		$sField = $someone[$this->Model->name][$this->field];

		//one by one
		$s['name']   = sha1($sField);
		$s['host']   = sha1($this->desc['host']);
		$s['br']     = sha1($this->desc['br']);
		$s['ip']     = sha1($this->desc['ip']);
		$s['secret'] = sha1($this->secret);

		//all hash in the session
		$hash = $this->Session->read('hash'.$this->superUser);
		
		//they most be the same
		if($hash != sha1($s['name'].$s['host'].$s['br'].$s['ip'].$s['secret']))
			return false;

		return true;
	}
	
	function logout(){

		$this->Session->delete($this->superUser);
		$this->Session->destroy();

	}

}

?>