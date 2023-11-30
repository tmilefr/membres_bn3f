<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Home';  //controller name for routing
		$this->_model_name 		= 'Acl_users_model';	   //DataModel
		$this->title .= $this->lang->line($this->_controller_name);
		$this->data_view['content'] = '';
		$this->load->library('Acl');
		//$this->load->model('Acl_users_model');
		$this->init();
	}

	public function login(){
		$captcha_error = '';
		$login_error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if ($this->config->item('captcha')){
				$captcha = json_decode($this->{$this->_model_name}->_get('defs')['recaptchaResponse']->PrepareForDBA($this->input->post("g-recaptcha-response")));
			} else {
				//echo '<pre>'.print_r($captcha, TRUE).'</pre>';
				$captcha = new StdClass();
				$captcha->success = true;
			}
			if (isset( $captcha->{'error-codes'}))
				$captcha_error = implode('<br/>', $captcha->{'error-codes'});

			if ($this->form_validation->run('Acl_users_model') == true AND isset($captcha) AND $captcha->success == true) {
				$data = $this->input->post();
				/* on force le login en admin */
				if ($data['login'] == 'admin' )
					$data['type_cnx'] = 'NORM';

				$login_error = $this->acl->CheckLogin($data);
				//$this->session->set_flashdata('login_error', $this->acl->CheckLogin($data));
				if ($this->acl->IsLog()){ 
					redirect('/Home');
				}
			}	
        }
		//BUG d'appel � l'objet, compensation
		$this->{$this->_model_name}->_get('defs')['recaptchaResponse']->_set('captcha',  $this->config->item('captcha') );
		$this->data_view['required_field'] = $this->{$this->_model_name}->_get('required');
		$this->data_view['captcha_error'] = $captcha_error;
		$this->data_view['login_error'] = $login_error;
		$this->_set('view_inprogress','unique/login_view');
		$this->render_view();
	}

	public function About(){
		$this->_set('view_inprogress','unique/about');
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
		$this->load->model('Users_model');

		$this->data_view['FieldSection'] = $this->Users_model->_get('defs')['section']->_get('values');

		$membres = [];
		foreach( $this->Users_model->GetUserBySection() AS $membre){
			$membres[$membre->section][] = $membre;
		}
		$this->data_view['list_membres'] = $membres;


		$this->render_view();
	}

	public function no_right()
	{
		$this->_set('view_inprogress','unique/no_right');
		$routes = $this->session->userdata('routes');
		$this->data_view['routes_history'] = $routes;
		$this->render_view();
	}


}
