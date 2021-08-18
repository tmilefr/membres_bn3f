<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Home';  //controller name for routing
		$this->_model_name 		= 'Acl_users_model';	   //DataModel
		$this->title .= $this->lang->line($this->_controller_name);
		$this->data_view['content'] = '';
		$this->init();
	}

	public function login(){
		$error = '';
        if($this->input->server('REQUEST_METHOD') == 'POST'){
			if ($this->form_validation->run() == true) {
				$data = $this->input->post();
				$usercheck  = $this->Acl_users_model->verifyLogin($data['login'], $data['password']);
                if ($usercheck->autorize){ 
					$this->session->set_userdata('usercheck', $usercheck);  
					redirect('/Home');
				}                
			}	
        }
		$this->data_view['required_field'] = $this->{$this->_model_name}->_get('required');

		$this->_set('view_inprogress','unique/login_view');
		$this->render_view();
	}

	public function logout(){
		session_destroy();
        redirect('/Home/login');
	}

	public function account(){
		$usercheck = $this->session->userdata('usercheck');
		redirect('/Acl_users_controller/view/'.$usercheck->id);
	}

	public function index()
	{
		$this->_set('view_inprogress','unique/home_page');
		$this->render_view();
	}

	public function no_right()
	{
		$this->_set('view_inprogress','unique/no_right');
		$this->render_view();
	}


}
