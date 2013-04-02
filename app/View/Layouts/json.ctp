<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php
	unset($this->viewVars['content_for_layout'], $this->viewVars['title_for_layout'], $this->viewVars['scripts_for_layout']);
	$this->viewVars['json'] = 'render';
	if($this->params->action == 'edit')
		$response_json = array_merge($this->viewVars, $this->params->data);
	else
		$response_json = array_merge($this->viewVars);
	
	$response_json['html'] = $this->fetch('content');
	
	$json = json_encode($response_json);
	
	//remove null values
	$json = str_replace('null', '""', $json);
	echo $json;
	echo $this->element('sql_dump');
	unset($json);
?>

