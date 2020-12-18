<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Technique extends MY_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Home';  //controller name for routing
		$this->title .= ' - '.$this->lang->line($this->_controller_name);
		$this->data_view['content'] = '<h1> Technique </h1>';
		$this->init();
	}

	public function index()
	{
		$this->_set('view_inprogress','Technique_view');
		$this->render_view();
	}
}
