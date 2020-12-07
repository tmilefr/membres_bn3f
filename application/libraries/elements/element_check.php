<?php
/*
 * element.php
 * Object in page
 * 
 */

class element_check
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= null;
	protected $values 	= [];
	protected $type 	= '';
	
	public function RenderFormElement(){

		$value = json_decode($this->value);

		$input = $this->CI->bootstrap_tools->input_select($this->name.'_todo', $this->values, $value->todo);
		$input .= $this->CI->bootstrap_tools->input_select($this->name.'_have', $this->values, $value->have);

		return $input;
	}
	
	public function Render(){
		$value= json_decode($this->value);
		return 'à faire : '.((isset($this->values[$value->todo])) ? $this->values[$value->todo]: 'N/A').'<br/> en notre possession : '.((isset($this->values[$value->have])) ? $this->values[$value->have]: 'N/A');
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

