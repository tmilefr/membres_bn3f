<?php
defined('BASEPATH') || exit('No direct script access allowed');
require_once APPPATH.'third_party/dompdf/autoload.inc.php';
		
use Dompdf\Dompdf;
use Dompdf\Options;

class Libpdf {
	
	var $CI;
	var $pdf_path = '';
	var $filename = '';
	
	/**
	 * Constructor of class element.
	 * @return void
	 */	
	public function __construct() {
		$this->CI = & get_instance();
		$this->_init();
		$this->pdf_path = str_replace('application','data/pdf',APPPATH);
		$this->img_path = base_url().'assets/img/'; //str_replace('application','assets/img/',APPPATH);
		$this->pdf_url_path = base_url().'data/pdf';
	}
	
	public function _init(){
		$options = new Options();
		$options->set('enable_html5_parser', true);
		$options->set('debugPng',false);
		$options->set("enable_remote", true);
		$options->setTempDir($this->pdf_path); 
		
		$pdf = new Dompdf($options);

		$pdf->setPaper('A4', 'portrait');

		$this->CI->dompdf = $pdf;
	}
	
	public function reset(){
		if (isset($this->CI->dompdf))
			unset($this->CI->dompdf);
		$this->_init();
	}

	//not sure that's good place for this ... need to do invoice lib
	/**
	 * @brief Pdf Create with $pdf data and view view
	 * @param $invoice 
	 * @returns void()
	 * 
	 * 
	 */
	function DoPdf($datas,$view_pdf,$filename){
		$data_view['datas'] = $datas;
		$data_view['img_path'] = $this->_get('img_path');
		$html = $this->CI->load->view($view_pdf, $data_view, true);
		$this->filename = $filename;
		$this->makePdf($html);
	}
	
	/**
	 * @brief Create PDF File with Html content
	 * @param $html 
	 * @returns 
	 * 
	 * 
	 */
	function makePdf($html){
		try{
			$this->reset();
			$this->CI->dompdf->load_html($html);        
			$this->CI->dompdf->render();
			file_put_contents($this->pdf_path.$this->filename, $this->CI->dompdf->output()); 
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}		
	
	/**
	 * Generic set
	 * @return void
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}
	/**
	 * Generic get
	 * @return void
	 */
	public function _get($field){
		return $this->$field;
	}	
}
