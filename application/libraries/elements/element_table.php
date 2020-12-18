<?php
/*
 * element.php
 * Object in page
 * 
 */

class element_table
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= null;
	protected $values 	= [];
	protected $type 	= '';
	
	public function RenderFormElement(){
		//return $this->CI->bootstrap_tools->input_text($this->name, $this->CI->lang->line($this->name) , $this->value);
		$id = $this->CI->render_object->_get('id');
		

		$this->CI->{$this->model}->_set('filter', [$this->foreignkey => $id ]);
		$this->CI->{$this->model}->_set('order', $this->foreignkey);
		$datas = $this->CI->{$this->model}->get_all();
		$table = '<table class="table table-sm"><thead><tr><th scope="col">&nbsp;</th>';
	  	foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
			if ($defs->list === true){
				$table .= '<th scope="col">'.$field.'</a></th>';	
			}
		}
		$table .= '</tr></thead><tbody>';
		foreach($datas AS $key => $data){
			$table .= '<tr>';
			$table .= '<td>';
			//$table .= $this->CI->render_object->render_element_menu($data);
			$table .= '</td>';	
	
			foreach($this->CI->{$this->model}->_get('defs') AS $field=>$defs){
				if ($defs->list === true){
					switch($defs->type){
						case 'select':
						case 'select_database':
							$table .= '<td>'.$defs->values[$data->{$field}].'</td>';
						break;
						default:
							$table .= '<td>'.$data->{$field}.'</td>';
					}

					
				}
			}
			$table .= '</tr>';
		}
		$table .='</tbody></table>';
		return $table;

	}
	
	public function Render(){
		return $this->value;
	}

	/**
	 * Constructor of class element.
	 * @return void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Destructor of class element.
	 * @return void
	 */
	public function __destruct()
	{
		unset($this->CI);
		echo '<pre><code>'.print_r($this , 1).'</code></pre>';


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

