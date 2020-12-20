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
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true,'sendbymail'=>true);
		
		
		$this->title .= ' - '.$this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		$this->init();

		$this->load->model('Users_model');
		$this->load->model('ContributionLgn_model');
		$this->load->model('Service_model');	
		$this->load->model('Taux_model');
		$this->load->model('Sendmail_model');
		$this->load->library('Libpdf');
		
		$this->_mail_txt = "Chers membres, liebe mitglieder, \n
Veuillez trouver ci-joint votre facture personnelle pour le renouvellement de votre adhésion à la BN3F pour l’année 2021. \n
Comme vous le constaterez, il y aura quelques changements mineurs : \n
-	Les tarifs (sauf parc à bateaux) restent inchangés \n
-	Les emplacements bateau passent tous à 60 Euros\n
-	Les journées de travail passent de 4 fois 75 Euros à 2 fois 150 euros à titre d’essai. Ceci devrait favoriser les personnes désireuses de prêter main forte à la base, sans pénaliser ceux qui ne viennent jamais. Par contre : Ces 2 journées de travail devront, à de rares exceptions près, être consacrées à l’intérêt général de la base, à l’exclusion de tous travaux internes aux sections. \n
-	La date limite de payement est fixée au 28 février. Au-delà de cette date, une majoration de 20€ (10€ pour une cotisation individuelle) sera appliquée pour chaque mois entamé. A compter du 1er juin tout membre dont la cotisation ne sera pas réglée sera considéré comme démissionnaire et un nouveau droit d’entrée sera demandé pour une réinscription. \n

Pour toute demande/réclamation/modification : info@bn3f.fr \n
En vous souhaitant une belle saison 2021\n\n

In der Beilage, finden Sie bitte eure persönliche Rechnung bezüglich der Erneuerung eurer Mitgliedschaft für die Saison 2021. Wie Ihr sehen könnt, gibt es ein Paar kleine Neuigkeiten: \n
-	Die Preise bleiben unverändert (mit Ausnahme der Bootsplätzen) \n
-	Die Bootsplätze werden alle auf 60 Euros gesetzt\n
-	Die Arbeitstage werden, versuchsweise, von 4 auf 2 reduziert. (2x150 Euros statt 4x75 Euros). Diese 2 Arbeitstage sollten jedoch exklusiv zur gemeinsamen Interessen genutzt werden. Sektionentätigkeiten werden nicht mehr anerkannt. \n
-	Letzter Einzahlungstermin ist der 28. Februar. Danach wird jeder angefangener Monat um 20€ (10 Euros für Einzelbeiträge) erhöht. Ab dem 1. Juni werden die nicht erneuerten Mitglieder als austeigend betrachtet und müssen sich ggf. neu-eischreiben (Inklusive Eintragsgebühr) \n
Für Fragen/Reklamationen/ Änderungen: info@bn3f.fr \n
Wir wünschen Ihnen eine schöne Saison 2021 \n
Pour le comité, Für das Komitee				\n";
	}

	Public function view($id){
		$dba_data = $this->MakePdf($id);
		$this->data_view['datas'] 	= $dba_data;
		$this->data_view['url_pdf'] = '<a target="_new" href="'.$this->libpdf->_get('pdf_url_path').'/'. $dba_data->pdf.'"><span class="oi oi-file"></span> '. $dba_data->pdf.'</a>';
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();	
	}

	function SendByMail()
	{
		$this->load->library('email');
		
		if (isset($_POST['ids'])){
			foreach($_POST['ids'] AS $key=>$val){
				$ref = explode('|', $val);
				$id = $ref[0];
				$email = $ref[1];
				$dba_data = $this->MakePdf($id);
				if (is_file($this->libpdf->_get('pdf_path').$dba_data->pdf)){
					$this->email->from('info@bn3f.fr', 'BN3F');
					$this->email->to($email);
					$this->email->subject('Appel à cotisation BN3F 2021 (correction)');
					$this->email->message($this->_mail_txt);
					$this->email->set_alt_message($this->_mail_txt);
					$this->email->attach($this->libpdf->_get('pdf_path').$dba_data->pdf);
					//log send mail
					$log = new StdClass();
					$log->date = date('Y-m-d H:i:s');
					$log->user = $id;
					$log->pdf = $dba_data->pdf;				
					$log->status = (($this->email->send()) ? 'sended':'not-sended');
					$log->log = $this->email->print_debugger(array('headers'));
					$this->Sendmail_model->post($log);				
					$this->email->clear(TRUE);
				} else {
					$this->data_view['sendmail'][] = $this->libpdf->_get('pdf_path').$dba_data->pdf. ' not exist';
				}
			}
		}

		$dba_data = $this->{$this->_model_name}->GetUserAndLog();

		foreach($dba_data as $key=>$data){
			$dba_data[$key]->log = $this->Sendmail_model->GetLog($data->user);
		}

		$this->data_view['datas'] = $dba_data;
		$this->_set('view_inprogress','unique/Contribution_view_send.php');
		$this->render_view();	
	}

	/**
	 * @brief Edition Method
	 * @param $id 
	 * @returns 
	 * 
	 * 
	 */
	public function edit($id = 0)
	{		
		$this->_redirect = true;
		if ($this->form_validation->run() === FALSE){


		} else {
			$this->data_view['id'] = '';
			if (!$id){
				if ($this->input->post('id') ){
					$id = $this->input->post('id');
				}
			}
			if ($id){
				$this->ContributionLgn_model->DeleteLink($id);
				foreach( $this->input->post('id_ser') AS $key=>$id_ser){
					if ($id_ser != '...'){
						$lgn = new Stdclass();
						$lgn->id_cnt = $id;
						$lgn->id_ser = $id_ser;
						$lgn->created = date('Y-m-d H:i:s');
						$this->ContributionLgn_model->post($lgn);
					}
				}
			}			
		}
		
		parent::edit($id);
	}


	function MakePdf($id = null, $override = true){
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
			$dba_data->check = $values;
			$dba_data->pdf = NameToFilename('Cotisation_'.$dba_data->user->name.'_'.$dba_data->year).'.pdf';
			if (!is_file($this->libpdf->_get('pdf_path').$dba_data->pdf) OR $override){
				$this->libpdf->DoPdf($dba_data,'unique/Contribution_view_pdf', $dba_data->pdf);
			} 
			return $dba_data;
		}	
	}

}
