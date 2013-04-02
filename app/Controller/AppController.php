<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	/**
	 * render the response as json without the url
	 * @var    boolean
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public $useJson = false;
	
	/**
	 * clean all incoming data
	 * @return void 
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	public function beforeFilter(){
		App::uses('Sanitize', 'Utility');
		$this->request->query  = Sanitize::clean($this->request->query);
		$this->request->data   = Sanitize::clean($this->request->data);
		$this->request->params = Sanitize::clean($this->request->params);

		//check if we have testing controller in deployment mode
		if(Configure::read('debug')){
			$className = $this->name.'TestingController';
			$pathFileName = APP.'Controller/'.$className.'.php';

			if(is_file($pathFileName)){
				if(!class_exists($className))
					require $pathFileName;

				$this->Testing = new $className();
				$this->Testing->controller = $this;
			}
		}	
	}


	/**
	 * if the url have the json string render the view as json 
	 * @return void 
	 * @author Alejo JM <alejo.jm@gmail.com>
	 */
	function beforeRender(){
		if (strpos($this->params->url, 'json') !== false || $this->useJson) {
			$this->layout = 'json';

			if(!is_file(APP.'View'.DS.$this->name.DS.$this->view.'.ctp'))
				$this->view = '/empty';
		}

	}
}
