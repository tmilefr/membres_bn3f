<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Service_model extends Core_model{

	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'service');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Service.json');
		$this->_init_def();
	}

}
?>