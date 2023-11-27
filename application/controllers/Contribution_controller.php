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
		$this->_autorize 		= array('list'=>true,'add'=>true,'edit'=>true,'delete'=>true,'view'=>true,'sendbymail'=>true,'recap'=>true);
		$this->_search 			= true;

		$this->_set('_debug', FALSE);
		
		$this->title .= $this->lang->line('GESTION').$this->lang->line($this->_controller_name);

		$this->init();

		$this->load->model('Users_model');
		$this->load->model('ContributionLgn_model');
		$this->load->model('Service_model');	
		$this->load->model('Taux_model');
		$this->load->model('Sendmail_model');
		$this->load->library('Libpdf');
		
		$this->_mail_txt = $this->lang->line('_mail_txt');

		$this->render_object->_set('_not_link_list', ['add','list','sendbymail','recap']);
	}

	Public function view($id){
		$dba_data = $this->MakePdf($id);
		$this->data_view['datas'] 	= $dba_data;
		$this->data_view['url_pdf'] = '<a target="_new" href="'.$this->libpdf->_get('pdf_url_path').'/'. $dba_data->pdf.'"><span class="oi oi-file"></span> '. $dba_data->pdf.'</a>';
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();	
	}

	Public function recap(){
		$this->data_view['FieldSection'] = $this->Users_model->_get('defs')['section']->values;
		
		$list_recap = [];
		$dba_data = $this->{$this->_model_name}->GetUserAndLog();
		foreach($dba_data AS $key=>$user){
			$list_recap[$dba_data[$key]->section][] = $this->MakeCotisation($user->id);
		}
		$this->data_view['datas'] = $list_recap;
		$this->_set('view_inprogress','unique/Recap');
		$this->render_view();		
	}

	function SendByMail()
	{
		$this->load->library('email');
		
		$this->bootstrap_tools->_SetHead('assets/js/checkall.js','js');

		$this->data_view['FieldSection'] = $this->Users_model->_get('defs')['section']->values;
		$subject = 'Appel à cotisation BN3F '.$this->config->item('year_inprogress');

		if (isset($_POST['ids'])){
			foreach($_POST['ids'] AS $key=>$val){
				$ref = explode('|', $val);
				$id = $ref[0];
				$email = $ref[1];
				$dba_data = $this->MakePdf($id, true);
				if (is_file($this->libpdf->_get('pdf_path').$dba_data->pdf)){
					$this->email->from('info@bn3f.fr', 'BN3F');
					$this->email->to($email);
					$this->email->subject($subject);
					$this->email->message($this->_mail_txt);
					$this->email->set_alt_message($this->_mail_txt);
					$this->email->attach($this->libpdf->_get('pdf_path').$dba_data->pdf);
					//log send mail
					/* LOG */
					$log = new StdClass();
					$log->date = date('Y-m-d H:i:s');
					$log->user = $id;
					$log->to = $email;
					$log->subject = $subject;
					$log->msg = $this->_mail_txt;
					$log->pdf = $dba_data->pdf;				
					$log->status = (($this->email->send()) ? 'sended':'not-sended');
					$log->log = $this->email->print_debugger();
					$this->Sendmail_model->post($log);				
					//re-init e-mail before send another e-mail.
					$this->email->clear(TRUE);
				} else {
					$this->data_view['sendmail'][] = $this->libpdf->_get('pdf_path').$dba_data->pdf. ' not exist';
				}
			}
		}

		$dba_data = $this->{$this->_model_name}->GetUserAndLog();

		$list_sendmail = [];
		foreach($dba_data as $key=>$data){
			

			$dba_data[$key]->log = $this->Sendmail_model->GetLog($data->id);

			$list_sendmail[$dba_data[$key]->section][] = $dba_data[$key];
		}



		$this->data_view['datas'] = $list_sendmail;
		$this->_set('view_inprogress','unique/Contribution_view_send.php');
		$this->render_view();	
	}

	/**
	 * @brief Edition Method
	 * @param $id 
	 * @returns 
	 * 
	 */
	public function edit($id = 0)
	{		
		$this->_redirect = false;
		$this->_set('render_view',false);
		$this->session->set_flashdata('state',  '' );
		if (!$id){
			if ($this->input->post('id') ){
				$id = $this->input->post('id');
			}
		}
		$ids =  $this->{$this->_model_name}->get_all_ids();
		$key = array_search($id , $ids);

		$this->data_view['id_prec'] =  ((isset($ids[$key-1])) ? $ids[$key-1]:-1);
		$this->data_view['id_suiv'] =  ((isset($ids[$key+1])) ? $ids[$key+1]:-1);

		parent::edit($id);

		if ($id){
			$this->MakeCotisation($id);
			$dba_data = $this->MakePdf($id);
			$this->data_view['url_pdf'] = '<a target="_new" href="'.$this->libpdf->_get('pdf_url_path').'/'. $dba_data->pdf.'"><span class="oi oi-file"></span> '. $dba_data->pdf.'</a>';
		}
		$this->render_view();
	}



	function MakeCotisation($id){
		if ($id){
			$this->render_object->_set('id',		$id);
			$this->{$this->_model_name}->_set('key_value',$id);
			$dba_data = $this->{$this->_model_name}->get_one();
			if (isset($dba_data)){
				//get Taux
				$this->Taux_model->_set('key_value',$dba_data->taux);
				$dba_data->taux = $this->Taux_model->get_one();
				if (!isset($dba_data->taux))
					debug($dba_data);
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
					if (isset($detail->code)){
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
				}
				$values = json_decode($dba_data->check);
				$dba_data->check = $values;
				//maj amount
				$this->{$this->_model_name}->UpdateAmount($id,$dba_data->real);
			}
			return $dba_data;
		}
	}


	function MakePdf($id = null, $override = true){
		if ($dba_data = $this->MakeCotisation($id)){
			$dba_data->pdf = NameToFilename('Cotisation_'.$dba_data->user->name.'_'.$dba_data->user->surname.'_'.$this->config->item('year_inprogress')).'.pdf';
			if (!is_file($this->libpdf->_get('pdf_path').$dba_data->pdf) OR $override){
				$this->libpdf->DoPdf($dba_data,'unique/Contribution_view_pdf', $dba_data->pdf);
			} 		
			return $dba_data;
		}
	}

}
