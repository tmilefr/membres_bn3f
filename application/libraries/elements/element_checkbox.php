<?php
/*

class element_checkbox extends element
{	
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_checkbox($this->name, $this->value);
	}
	
	public function Render(){
		return (($this->value) ? LANG($this->name.'_'.$this->value):$this->name.'_NO');
	}
}
