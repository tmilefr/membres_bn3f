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
class Taux_controller extends MY_Controller {

	protected $csv_path = APPPATH.'models/csv/';

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Taux_controller';  //controller name for routing
		$this->_model_name 		= 'Taux_model';	   //DataModel
		$this->_edit_view 		= 'edition/Taux_form';//template for editing
		$this->_list_view		= 'unique/Taux_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		$this->title 			.= ' - '.$this->lang->line($this->_controller_name);
		
		$this->_set('_debug', TRUE);
		
		$this->init();
	}
}
