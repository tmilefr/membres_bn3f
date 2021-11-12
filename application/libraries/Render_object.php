<?php
defined('BASEPATH') || exit('No direct script access allowed');
Class Render_object{

	protected $CI 		= NULL; //Controller instance 
	protected $datamodel= NULL; //Name of datamodel
	protected $id 		= NULL; //id of active element
	protected $dba_data = NULL; //Data from DATABASE from id element
	protected $_debug 	= FALSE;//Debug 
	protected $_model 	= [];
	protected $_ui_rules= [];
	protected $form_mod = FALSE;
	protected $notime	= TRUE;
	protected $_reset   = [];
	protected $_not_link_list = ['add','list'];

	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function _set($field,$value)
	{
		$this->$field = $value;
	}

	public function _get($field)
	{
		return $this->$field;
	}
	
	public function _reset_value($field)
	{
		$this->_reset[$field] = true;
	}	
	
	public function label($name)
	{
		return $this->CI->bootstrap_tools->label($name);
	}	
	


	public function render_element_menu($data = null, $blocked = false )
	{
		$key_value ='';
		$element_menu = '';
		if ($data){	
			$key_value = $data->{$this->_model[$this->datamodel]->_get('key')};
		} else {
			if (isset($this->dba_data)){ // try to check database
				$key_value = $this->dba_data->{$this->_model[$this->datamodel]->_get('key')};
			}
		}		
		if ($key_value)
		{
			foreach($this->_ui_rules AS $rule){
				if (!in_array($rule->term , $this->_not_link_list ) AND $rule->autorize AND  !$blocked){
					$element_menu .= $this->CI->bootstrap_tools->render_icon_link($rule->url , $key_value , $rule->icon, $rule->class);
				}
			}
		}
		return $element_menu;
	}
	
	public function render_link($field, $mode = 'list')
	{
		$filter 	= $this->CI->session->userdata($this->CI->set_ref_field('filter'));
		$direction 	= $this->CI->session->userdata($this->CI->set_ref_field('direction'));
		if ( $this->_model[$this->datamodel]->_get('defs')[$field]->dbforge->type == 'INT'){
			$null_value = 0;
		} else {
			$null_value = '';
		}
		$add_string =  '';
		if (isset($filter[$field])){
			$add_string = '<span class="badge badge-success">'.((isset($this->_model[$this->datamodel]->_get('defs')[$field]->values[$filter[$field]])) ? $this->_model[$this->datamodel]->_get('defs')[$field]->values[$filter[$field]]:$filter[$field]).'</span>';
		}
		$string_render_link = '<div class="btn-group">';
		
		$string_render_link .= $this->CI->bootstrap_tools->render_head_link($field, $direction, $this->CI->_get('_rules')[$mode]->url, $add_string);
		if (isset($this->_model[$this->datamodel]->_get('defs')[$field]->values)){
			$string_render_link .= $this->CI->bootstrap_tools->render_dropdown($field, $this->_model[$this->datamodel]->_get('defs')[$field]->values, $this->CI->_get('_rules')[$mode]->url, $null_value );
		}
		$string_render_link .= '</div>';
		return $string_render_link;
	}
	
	public function _getCi($field){
		return $this->CI->_get($field);
	}

	public function Set_Rules_elements($DataModelToUse = null)
	{
		if ($DataModelToUse == null)
			$DataModelToUse =  $this->datamodel;
		$this->_model[$DataModelToUse] = $this->CI->{$DataModelToUse};
		//set Validation Rules config by DataModel
		$config = [];
		foreach($this->_model[$DataModelToUse]->_get('defs') AS $field=>$defs){
			if (isset($defs->rules) AND $defs->rules){
				$config[] = ['field' => $field,'label' => $this->CI->lang->line($field),'rules' =>  $defs->rules];
				//$this->CI->form_validation->set_rules($field, $this->CI->lang->line($field) , $defs->rules); changed for multi-forms !
			}	
		}	
		$this->CI->form_validation->_SetRules($config,$DataModelToUse);
	}


	// design by type
	function GetDesign($type = ""){
		return $this->CI->bootstrap_tools->GetDesign($type);
	}

	//need to make a real element object.
	function RenderFormElement($field, $val = false, $DataModelToUse = null)
	{
		if ($DataModelToUse == null){ //mutli model !
			$DataModelToUse = $this->datamodel;
		}		
		$value = null;
		if ($val){
			$value = $val;
		} else {
			if (isset($this->_reset[$field]) AND  $this->_reset[$field]){
				
			} else {
				if ($value = set_value($field)){ //in first, POST data

				} else {
					if (isset($this->dba_data)){ // try to check database
						$value = $this->dba_data->{$field};
					}
				}
			}
		}
		$this->_model[$DataModelToUse]->_get('defs')[$field]->element->_set('form_mod', $this->form_mod);
		$this->_model[$DataModelToUse]->_get('defs')[$field]->element->_set('value', $value);
		return $this->_model[$DataModelToUse]->_get('defs')[$field]->element->RenderFormElement();
	}
	
	function RenderElement($field, $value = null, $parent_id = null, $DataModelToUse = null)
	{
		if ($DataModelToUse == null){ //mutli model !
			$DataModelToUse = $this->datamodel;
		}
		if (!$value) {
			if (isset($this->dba_data)){ // try to check database
				$value = $this->dba_data->{$field};
			}
		}	
		if ($parent_id){
			$this->_model[$DataModelToUse]->_get('defs')[$field]->element->_set('parent_id',$parent_id);
		}
		$this->_model[$DataModelToUse]->_get('defs')[$field]->element->_set('form_mod', $this->form_mod);	
		$this->_model[$DataModelToUse]->_get('defs')[$field]->element->_set('value', $value);
		return $this->_model[$DataModelToUse]->_get('defs')[$field]->element->Render();
	}
	
	function RenderImg($file, $alt = ""){
		return $this->CI->bootstrap_tools->RenderImg($file, $alt);
	}


	public function __destruct()
	{
		if ($this->_debug == TRUE){
			unset($this->CI);
			unset($this->_model[$this->datamodel]);
			echo debug($this, __file__ );
		}
	}
	
}
