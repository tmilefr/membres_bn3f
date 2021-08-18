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
class Service_controller extends MY_Controller {


	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Service_controller';  //controller name for routing
		$this->_model_name 		= 'Service_model';	   //DataModel
		$this->_edit_view 		= 'edition/Service_form';//template for editing
		$this->_list_view		= 'unique/Service_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		$this->title 			.=  $this->lang->line('GESTION').$this->lang->line($this->_controller_name);
	
		$this->init();
	}
}
