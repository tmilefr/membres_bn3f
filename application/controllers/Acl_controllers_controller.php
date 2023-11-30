<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */
class Acl_controllers_controller extends MY_Controller {
	
	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct(){
		parent::__construct();
		
		$this->_controller_name = 'Acl_controllers_controller';  //controller name for routing
		$this->_model_name 		= 'Acl_controllers_model';	   //DataModel
		$this->_edit_view 		= 'edition/Acl_controllers_form';//template for editing
		$this->_list_view		= 'unique/Acl_controllers_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>false);
		
		
		$this->title 			= $this->lang->line('GESTION_'.$this->_controller_name);
		$this->init();
		
		$this->LoadModel('Acl_actions_model');
		
	}

}
