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
class Acl_users_controller extends MY_Controller {

	protected $csv_path = '';

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Acl_users_controller';  //controller name for routing
		$this->_model_name 		= 'Acl_users_model';	   //DataModel
		$this->_edit_view 		= 'edition/Acl_users_form';//template for editing
		$this->_list_view		= 'unique/Acl_users_view.php';
		$this->_autorize 		= array('list'=>true,'add'=>true,'edit'=>true,'delete'=>true,'view'=>true);
		$this->title 			.= $this->lang->line('GESTION').$this->lang->line($this->_controller_name);
		$this->_set('_debug',TRUE);
		$this->init();
	}

}
