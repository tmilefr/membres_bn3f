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
class Contribution_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->_controller_name = 'Contribution_controller';  //controller name for routing
		$this->_model_name 		= 'Contribution_model';	   //DataModel
		$this->_edit_view 		= 'edition/Contribution_form';//template for editing
		$this->_list_view		= 'unique/Contribution_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		
		
		$this->title .= ' - '.$this->lang->line($this->_controller_name);
		
		$this->_set('_debug', TRUE);
		$this->init();

		$this->load->model('Users_model');
		$this->load->model('ContributionLgn_model');
		$this->load->model('Service_model');	
		$this->load->model('Taux_model');
		$this->load->library('Libpdf');
		
	}

	Public function view($id){

		if ($id){
			$this->render_object->_set('id',		$id);
			$this->{$this->_model_name}->_set('key_value',$id);
			$dba_data = $this->{$this->_model_name}->get_one();
			//get Taux
			$this->Taux_model->_set('key_value',$dba_data->taux);
			$dba_data->taux = $this->Taux_model->get_one();

			//get User
			$this->Users_model->_set('key_value',$dba_data->user);
			$dba_data->user = $this->Users_model->get_one();
			$trad_section = $this->Users_model->_get('defs')['section']->values;
			$dba_data->user->section = $trad_section[$dba_data->user->section];
			//get services
			$this->ContributionLgn_model->_set('filter', ['id_cnt'=> $dba_data->id ]);
			$this->ContributionLgn_model->_set('order', 'id_cnt');
			$presta = $this->ContributionLgn_model->get_all();
			
			$dba_data->real = 0;
			$dba_data->services = array();
			foreach($presta AS $service){
				$this->Service_model->_set('key', 'id');
				$this->Service_model->_set('key_value', $service->id_ser );
				$detail = $this->Service_model->get_one();

				switch($dba_data->taux->code){
					case 'N':
					case 'H':
					case 'C':
						if ($detail->code =='WI' && $dba_data->taux->code == 'C'){ //hivernage offert au comité
							$detail->taux = 0;
							$detail->total = $detail->taux*$detail->amount;	
						} else {
							$detail->taux = $dba_data->taux->taux;
							$detail->total = $detail->taux*$detail->amount;
						}
					break;
					case 'D':
						$detail->taux = $dba_data->taux->taux;
						$detail->total = $detail->taux*$detail->amount;
					break;
				}
				$dba_data->real += $detail->total;
				
				$dba_data->services[] = $detail;


			}
			$values = json_decode($dba_data->check);
			//$trad_check = $this->Contribution_model->_get('defs')['check']->values;
			//$this->data_view['trad_check'] 	= $trad_check;

			$dba_data->check = $values;
			/*
			if (isset($dba_data->check->todo)) 
				$dba_data->check->todo = ((isset($trad_check[$dba_data->check->todo])) ? $trad_check[$dba_data->check->todo]:$dba_data->check->todo);
			else
				$dba_data->check->todo = 'N/A';
			if (isset($dba_data->check->have))
				$dba_data->check->have = ((isset($trad_check[$dba_data->check->have])) ? $trad_check[$dba_data->check->have]:$dba_data->check->have);
			else
				$dba_data->check->have = 'N/A';
			*/
			
			$this->data_view['datas'] 	= $dba_data;

			$pdf = NameToFilename('Cotisation_'.$dba_data->user->name.'_'.$dba_data->year).'.pdf';
			//if (!is_file($this->libpdf->_get('pdf_path').$pdf)){
				$this->libpdf->DoPdf($dba_data,'unique/Contribution_view_pdf',$pdf);
			//} 
			$this->data_view['url_pdf'] = '<a target="_new" href="'.$this->libpdf->_get('pdf_url_path').'/'.$pdf.'"><span class="oi oi-file"></span> '.$pdf.'</a>';
		}	
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();	
		//$this->load->view('unique/Contribution_view_pdf',	$this->data_view);

		//
	}

}
