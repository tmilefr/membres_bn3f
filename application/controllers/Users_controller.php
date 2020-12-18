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
class Users_controller extends MY_Controller {

	protected $csv_path = APPPATH.'models/csv/';

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Users_controller';  //controller name for routing
		$this->_model_name 		= 'Users_model';	   //DataModel
		$this->_edit_view 		= 'edition/Users_form';//template for editing
		$this->_list_view		= 'unique/Users_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		$this->title 			.= ' - '.$this->lang->line($this->_controller_name);
		
		$this->_set('_debug', TRUE);
		$this->init();

		$this->{$this->_model_name}->_set('_debug', FALSE);
	}

	/*
	 	Colonne I = type de cotisation		F=familiale, I= individuelle, J=jeune (220, 140 ou 100 €)
		Colonne J = Section		M= motonautiste, S=ski, V=voile, W=wake
		Colonne L = Taux à appliquer (11)		C=comité (0.5) , N=normal (1), D=demi-cotisation (anciens président+Fritz+Franck Girard)
		Colonne M = Caravane (12)		0=non  1=oui
		Colonne N = Emplacement bateau (13)		N=non AM=parc amont AV=parc aval (cette distinction n’a plus vraiment lieu d’être vu que les deux sont à 60 Euros)		
		Colonne O = Hivernage sous chapiteau (14)	(50 € , gratuit pour les membres du comité)		Colonne P = cotisation totale (hors journées de travail) (15)
		Colonne Z = Provision encaissées en 2020 
		Colonne AA = Provision à fournir pour 2021
	*/
	
	protected $subscriptionMap 		= ['F'=>7 , 'I'=>8 , 'J'=>9];
	protected $subscriptionMapVoile = ['J'=>5 , 'I'=>6,'F'=>6];
	protected $sectionMap 			= ['M'=>1,'S'=>2, 'V'=>3, 'W'=>4];
	protected $TauxMap 				= ['C'=>1 , 'N'=>2, 'D'=>3];
	protected $PlaceMap 			= ['N'=>0 , 'AM'=>2 , 'AV'=>3,'V'=>0];
	protected $WinterPLace 			= ['0'=>0,'1'=>4 ];
	protected $caravane 			= [0=>0,1=>1];
	protected $checkMap				= ['1x75'=>1,'2x75'=>2,'3x75'=>3,'4x75'=>4,'1x150'=>5,'2x150'=>6];
	
	

	public function Load($log_csv){
		$csv = array();
        try{
            $contents = $this->GetContentArray( $log_csv);
            foreach($contents AS $content){
                $csv[] = $this->prepare_json($content);
			}
			return $csv;
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
    }

	/**
    * @brief Get Content from files
    * @set array()
    */
    protected function GetContentArray($file){
        if (!$content = file($file) ){
            throw new RuntimeException('Impossible d\’ouvrir "' . $file . '"');
        }
        return $content;
    }

    function prepare_json($text){
		$text_proc = str_getcsv ( $text, ";");
        return $text_proc;
    }


	public function Import()
	{
		$this->load->model('Contribution_model');
		$this->load->model('ContributionLgn_model');
		$this->Users_model->truncate();
		$this->Contribution_model->truncate();
		$this->ContributionLgn_model->truncate();

		$members = $this->Load($this->csv_path.'membres.csv');
		$member_list = array();
		$contribution_list = array();
		foreach($members AS $key => $val)
		{
			
			$membre = new StdClass();
			switch($key){
				case 0:
				//echo '<pre>'.print_r( $val ,true).'</pre>';
				break;
				default:
				if (isset($val[1])){
					$name = preg_replace("/\s+/", " ",$val[1]);
					$txt = explode(" ", $name); //nom prénom
					$membre->name = ((isset($txt[0])) ? $txt[0] :'');
					$membre->surname = ((isset($txt[1])) ? $txt[1] :'');
					$membre->adresse = $val[2];
					if ( preg_match('/([0-9]{5})(.*)/',$val[3], $res )){
						$membre->cp = trim($res[1]);
						$membre->ville = trim($res[2]);
					} else {
						$membre->cp = '';
						$membre->ville = $val[3];        
					}
					$membre->fixe = str_replace(['.',','],['',''],$val[4]);
					$membre->mobile = str_replace(['.',','],['',''],$val[5]);
					$membre->email = $val[6];
					$membre->year =  $val[7];
					$membre->section = $this->sectionMap[$val[9]];
					
					$id_user = $this->Users_model->post($membre);
					/* Contribution */
					$contribution = new Stdclass();
					$contribution->presta = array();
					$contribution->presta['subscription'] =  $this->subscriptionMap[$val[8]];
					if ($val[9] == 'V'){
						$contribution->presta['licence'] = $this->subscriptionMapVoile[$val[8]];
					}
					$contribution->user = $id_user;
					$contribution->year = '2021';
					$contribution->taux = $this->TauxMap[$val[11]];
					$contribution->presta['caravane'] = $this->caravane[$val[12]];
					$contribution->presta['boat'] =  $this->PlaceMap[$val[13]];
					$contribution->presta['winterpLace'] = $this->WinterPLace[$val[14]];
					$contribution->amount = $val[15];
					$contribution->check = array();
					
					if ($val[15] == 'AnnÃ©e sabat.'){
						$contribution->presta['subscription'] = 10;
					} else {
						$contribution->check['encaisse'] = trim($val[25]);
						$contribution->check['todo'] = trim($val[26]);
						$contribution->check['have'] = trim($val[27]);
					}

					$contribution->presta = json_encode($contribution->presta);
					$contribution->check = json_encode($contribution->check);

					$id_cnt = $this->Contribution_model->post($contribution);
					
					/* SERVICES */
					$contribution->presta = json_decode($contribution->presta);
					$contribution->check = json_decode($contribution->check);

					foreach($contribution->presta AS $key=>$id_ser){
						if ($id_ser){
							$service = new StdClass();
							$service->id_ser = $id_ser;
							$service->id_cnt = $id_cnt;
							$service->created = date('Y-m-d H:i:s');
							$contribution->service[] = $service;
							$this->ContributionLgn_model->post($service);
						}
					}					
					$member_list[] = $membre;
					$contribution_list[] = $contribution;
				}
			}
		}
		$this->data_view['members'] = $member_list;
		$this->data_view['contributions'] = $contribution_list;

		//$this->SaveToJson('Users_data.json',$member_list);
		//$this->SaveToJson('Contribution_data.json',$contribution_list);

		$this->_set('view_inprogress','unique/import_user.php');
		$this->render_view();			
	}

}
