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
	
	public $secureActions = array('task'=>true, 'deletetask'=>true, );

	function beforeFilter(){
		parent::beforeFilter();
		
		if(isset($this->secureActions[$this->action]) && !$this->Authorize->loggedIn('User')){
			$this->_stop('{"success":false, "notlogged":true}');
		}
	}


	/**
	 * load tasks if the user is logged in
	 * @return void
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public function isLogged(){
		$useruid = $this->Authorize->getUser('User');
		$useruid = $useruid ? $useruid : '';
		$response['isLogged'] = false;
		$this->User->contain();
		$user = $this->User->findByUid($useruid, array('id'));

		if(isset($user['User']['id'])){
			$this->User->contain(array('Task'=>array('order'=>'Task.due_date DESC', 'Priority')));
			$someone = $this->User->findById($user['User']['id']);
			$response['isLogged'] = true;
			$this->set('tasks', $someone['Task']);
			$this->set('response', $response);
			$this->render('tasks');
		}
		$this->set('response', $response);
	}


	/**
	 * login some user into the system, response tasks for the logged in user 
	 * @return void 
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public function login(){
		// $this->request->data = $this->Testing->login();
		// $this->useJson= true;

		$response = array('success'=>false);
		if (!$this->request->is('post') && !$this->request->is('put')){
			return $this->set('response', $response);
		}
		
		unset($this->User->validate['email']['isUnique'], $this->User->validate['repeat-password']);
		$this->User->set($this->request->data);
		
		if(!$this->User->validates())
			return $this->set('response', array_merge($response, array('validationErrors'=>$this->User->validationErrors)));
		
		$this->User->contain(array('Task'=>array('order'=>'Task.due_date DESC', 'Priority')));
		$someone = $this->User->findByEmail($this->data['User']['email']);
		$password = isset($someone['User']['password']) ? $someone['User']['password'] : '';

		if(sha1($this->data['User']['password']) === $password) {
			
			$this->User->create();
			$uid = String::uuid();
			$this->User->save(array('User'=>array('id'=>$someone['User']['id'], 'uid'=>$uid)), false);
			
			$this->Authorize->login('User', $uid);
			$response['success'] = true;
			$this->set('tasks', $someone['Task']);
			$this->set('response', $response);
			$this->render('tasks');
		}
		else
			$this->set('response', $response);
	}


	/**
	 * view for create task for the current logged in user
	 * @return void
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public function task($task_id=null){

		//$this->request->data = $this->Testing->addTask();
		//$this->useJson= true;
		
		$response = array('success'=>false);
		
		$priorities = $this->User->Task->Priority->find('list', array('order'=>'Priority.id ASC'));
		$this->set(compact('priorities'));

		if (!empty($this->data) || $this->request->is('post') || $this->request->is('put')){
			$useruid = $this->Authorize->getUser('User');
			$this->User->contain();
			$user = $this->User->findByUid($useruid, array('id'));
			$this->request->data['Task']['user_id'] = $user['User']['id'];
			$this->User->Task->set($this->data);

			if(!$this->User->Task->validates())
				return $this->set('response', array_merge($response, array('validationErrors'=>$this->User->Task->validationErrors)));

			$this->User->Task->save($this->data);
			$this->User->contain(array('Task'=>array('order'=>'Task.due_date DESC', 'Priority')));
			$someone = $this->User->findById($user['User']['id']);
			
			$response['success'] = true;
			$this->set('tasks', $someone['Task']);
			$this->set('response', $response);
		
			$this->render('tasks');
		}
		else
		{
			if(!empty($task_id) && $this->User->Task->exists($task_id)){
				$useruid = $this->Authorize->getUser('User');
				$this->User->contain();
				$user = $this->User->findByUid($useruid, array('id'));				
				$options = array('conditions' => array('Task.' . $this->User->Task->primaryKey => $task_id, 'Task.user_id'=>$user['User']['id']));
				$this->request->data = $this->User->Task->find('first', $options);
			}
		}
	}


	/**
	 * delete Task for the current user logged in
	 * @param  string $task_id 
	 * @return void          
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public function deletetask($task_id=null){
		if(!empty($task_id) && $this->User->Task->exists($task_id)){
			$useruid = $this->Authorize->getUser('User');
			$this->User->contain();
			$user = $this->User->findByUid($useruid, array('id'));				
			$this->User->Task->deleteAll('Task.id = '.$task_id.' AND Task.user_id = '.$user['User']['id']);
		}
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
