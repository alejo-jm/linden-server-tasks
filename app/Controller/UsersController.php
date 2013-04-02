<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	/**
	 * Authorize will manage the session and hash 
	 * @var    array
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public $components = array('Authorize');
	
	/**
	 * login some user into the system
	 * @return void 
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public function login(){
		$this->request->data = $this->Testing->login();
		$this->useJson= true;

		$response = array('success'=>false);
		// if (!$this->request->is('post') || !$this->request->is('put'))
		// 	return $this->set('response', $response);
		
		unset($this->User->validate['email']['isUnique'], $this->User->validate['repeat-password']);
		$this->User->set($this->request->data);
		
		if(!$this->User->validates())
			return $this->set('response', array_merge($response, array('validationErrors'=>$this->User->validationErrors)));
		
		$someone = $this->User->findByEmail($this->data['User']['email']);
		$password = isset($someone['User']['password']) ? $someone['User']['password'] : '';

		//pr($someone);
		if(sha1($this->data['User']['password']) === $password) {
			
			$this->User->create();
			$uid = String::uuid();
			$this->User->save(array('User'=>array('id'=>$someone['User']['id'], 'uid'=>$uid)), false);
			
			$this->Authorize->login('User', $uid);
			$response['success'] = true;
			$response['uid'] = $uid;
			$this->set('tasks', $someone['Task']);
		}

		$this->set('response', $response);
	}


	public function task(){
		// $useruid = $this->Authorize->getUser('User');
		// $this->User->contain('Task');
		// $user = $this->User->findByuid($useruid);
		// $this->set('tasks', $user['Task']);
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id), 'fields'=>array('User.id', 'User.email'));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
