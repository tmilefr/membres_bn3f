<?php
defined('BASEPATH') || exit('No direct script access allowed');
Class Render_menu{

	protected $CI 		= NULL; //Controller instance 
	protected $json_path= APPPATH.'models/json/';
	protected $json 	= 'Menus.json';
	protected $def_menus= [];
	protected $_debug = false;

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
	
	public function init(){
		$json = file_get_contents($this->json_path.$this->json);
		$json = json_decode($json);

		//echo '<pre>'.print_r($json, TRUE).'</pre>';
		foreach($json AS $position=>$element){
			$this->def_menus[$position]=$element;
		}
		//echo debug($this->def_menus);
	}

	function Get($position){
		if (isset($this->def_menus[$position])){
			$def_menu = $this->def_menus[$position];
			$menu = '';
			switch($def_menu->type){
				case 'link':
					$menu = '<nav class="navbar navbar-dark bg-dark">';
					$menu .= '<ul class="navbar-nav mr-auto flex-column">';
					foreach($def_menu->items AS $element){
						switch($element->type){
							case "link":
								if ($this->CI->acl->hasAccess(strtolower($element->url))){ 
									$menu .= '<li class="nav-item"><a class="nav-link" href="'.base_url($element->url).'"><span class="oi '.$element->icon.'"></span> '.Lang($element->name).'</a></li>';
								} else {
									$this->CI->_debug(strtolower($element->url.':FALSE'));
								}
							break;
							case "divider":
								$menu .= '<div class="dropdown-divider"></div>';
							break;
						}
					}
					$menu .= '</ul></nav>';
				break;
				case 'dropdown':
					$menu = '<li class="nav-item dropdown">';
					$menu .= '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="oi '.$def_menu->icon.'"></span></a>';
					$menu .= '<div class="dropdown-menu">';
					foreach($def_menu->items AS $element){
						switch($element->type){
							case "link":
								if ($this->CI->acl->hasAccess(strtolower($element->url))){ 
									$menu .= '<a class="dropdown-item" href="'.base_url($element->url).'">'.Lang($element->name).'</a>';
								} else {
									$this->CI->_debug(strtolower($element->url.':FALSE'));
								}
							break;
							case "divider":
								$menu .= '<div class="dropdown-divider"></div>';
							break;
						}
					}
					$menu .= '</div></li>';
				break;
			}
			return $menu;
		} else {
			return 'position inconnue';
		}
	}


	function __destruct(){
		if ($this->_debug){
			unset($this->CI);
			echo debug($this, __file__);
		}
	}
	
}
