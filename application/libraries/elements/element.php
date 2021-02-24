<?php
/*
 * element.php
 * Object in page
 * 
 */

class element
{
	protected $mode; //view, form.
	protected $name   	= null; //unique id ?
	protected $value  	= null;
	protected $values 	= [];
	protected $type 	= '';
	protected $mutliple	= FALSE;
	protected $parent_id= 0;
	
	public function SetMultiple($action = 'FALSE'){
		$this->name = str_replace(['[',']'],['',''], $this->name);
		$this->mutliple = $action;
		if ($this->mutliple)
			$this->name .= '[]';
	}

	public function set_name($name){
		$this->name = str_replace($name,'', $this->name);
		$this->name .= $name;
	}


	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_text($this->name , $this->CI->lang->line($this->name) , $this->value);
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
		//echo '<pre><code>'.print_r($this , 1).'</code></pre>';
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

