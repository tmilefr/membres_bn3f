<?php
/*
 * element.php
 * Object in page
 * 
 */

class element_table extends element
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= NULL;
	protected $values 	= [];
	protected $type 	= '';
	protected $model	= '';
	protected $foreignkey = '';
	protected $action = '';

	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
			$this->CI->bootstrap_tools->_SetHead('assets/js/dynamic_row.js','js');
		}
		if ($this->model)
			$this->CI->load->model($this->model);
	}	

	public function AfterExec($id){
		$this->CI->{$this->model}->SetLink($id);
	}

	public function PrepareForDBA($value){
		//echo debug($_POST);
		$this->CI->{$this->model}->_set('debug',TRUE);

		$id_parent = $this->CI->render_object->_get('id');
		$obj = [];
		$datas = [];
		//return json_encode($obj);
		if (method_exists($this->CI->{$this->model},'DeleteLink'))
			$this->CI->{$this->model}->DeleteLink($id_parent);

		foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
			$datas[$field] = $this->CI->input->post($field.'_'.$this->model);
		}	
		foreach($datas[$this->ref] AS $key=>$value){
			$lgn = new Stdclass();
			foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
				$lgn->$field = $datas[$field][$key];
			}
			if ($lgn->{$this->ref}){
				if ($id_parent){
					$lgn->{$this->foreignkey} = $id_parent;
				} else {
					$lgn->{$this->foreignkey} = 'tmp';
				}					
				$this->CI->{$this->model}->post($lgn);
				$obj[] = $lgn->{$this->ref};
			}
		}
		//echo debug($obj);
		//die();
		return json_encode($obj);
	}

	public function RenderFormElement(){
		//return $this->CI->bootstrap_tools->input_text($this->name, $this->CI->lang->line($this->name) , $this->value);
		$id = $this->CI->render_object->_get('id');
		$ref = [];
		$table = '<div class="Dynamic_row">';
		if ($id){
			$this->CI->{$this->model}->_set('filter', [$this->foreignkey => $id ]);
			$this->CI->{$this->model}->_set('order', $this->foreignkey);
			$datas = $this->CI->{$this->model}->get_all();
			if (count($datas)){
				foreach($datas AS $key => $data){
					$table .= '<div class="input-group mb-3">';
					foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
						//echo debug($this->CI->render_object->_get('form_mod'), __file__.' '.__line__);
						$defs->element->_set('form_mod', $this->CI->render_object->_get('form_mod'));
						$defs->element->_set('value', $data->{$field});
						
						$defs->element->set_name('_'.$this->model);
						$defs->element->SetMultiple(TRUE);
						

						if (in_array( $field , ['id',$this->foreignkey])){							
							$table .= '<input type="hidden" value="'.$data->{$field}.'" name="'.$field.'_'.$this->model.'[]">';
						} else {
							$table .= $defs->element->RenderFormElement();
						}				
					}
					$table .= '<div class="input-group-append"><button id="removeRow'.$data->id.'" type="button" class="removeRow btn btn-danger">Remove</button></div></div>';
				}
			}
		}
		$table .= '<div class="d-none" id="model"><div class="input-group mb-3">';
		foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
			$defs->element->_set('value', '');
			$defs->element->set_name('_'.$this->model);
			$defs->element->SetMultiple(TRUE);

			if (in_array( $field , ['id',$this->foreignkey])){							
				$table .= '<input type="hidden" value="" name="'.$field.'_'.$this->model.'[]">';
			} else {
				$table .= $defs->element->RenderFormElement();
			}			
		}
		$table .= '<div class="input-group-append"><button id="removeRow" type="button" class="removeRow btn btn-danger">Remove</button></div></div></div>';
		$table .= '</div><button id="addRow" type="button" class="btn btn-info">Add Row</button>';
		return form_hidden($this->name , $this->value ).$table;

	}
	
	public function Render(){
		//return $this->value;
		$render = [];
		//echo debug($this->parent_id);
		if ($this->parent_id){
			$this->CI->{$this->model}->_set('filter', [$this->foreignkey => $this->parent_id ]);
			$this->CI->{$this->model}->_set('order', $this->foreignkey);
			$datas = $this->CI->{$this->model}->get_all();
			if (count($datas)){
				//echo debug($datas);
				foreach($datas AS $key => $data){
					foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
						$defs->element->_set('form_mod', $this->CI->render_object->_get('form_mod'));
						$defs->element->_set('value', $data->{$field});
						if ( $field != 'id' AND $defs->element->_get('list') == true AND $string =  $defs->element->Render()){
							$render[] = $string;
						}				
					}
				}
			}
		}
		return implode(',', $render);
	}

	/**
	 * Destructor of class element.
	 * @return void
	 */
	public function __destruct()
	{
		unset($this->CI);
		//echo '<pre><code>'.print_r($this , 1).'</code></pre>';
		//echo debug($this);
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

