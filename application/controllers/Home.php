<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Home';  //controller name for routing
		$this->title .= ' - '.$this->lang->line($this->_controller_name);
		$this->data_view['content'] = '<h1> Home </h1>';
		$this->init();
	}

	public function index()
	{
		$this->_set('view_inprogress','unique/home_page');
		$this->render_view();
	}
}
