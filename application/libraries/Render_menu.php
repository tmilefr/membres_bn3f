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

	function Get($position, $name = null){
		if (isset($this->def_menus[$position])){
			$def_menu = $this->def_menus[$position];
			$have_right = false;
			$menu = '';
			switch($def_menu->type){
				case 'li':
					foreach($def_menu->items AS $element){
						$menu .= '<li class="'.$element->color.'">';
						if ($this->CI->acl->hasAccess(strtolower($element->url)) OR $element->noright){
							$have_right = true; 
							$menu .= '<a class="dropdown-item" href="'.(($element->noright) ? $element->url:base_url($element->url)).'">'.Lang($element->name.(($element->opt) ? '_'.$this->CI->acl->getType():'')).'</a>';
						}
						//sous menu
						$submenu = '<ul class="sub-menu">';
						$have_subright = false; 
						foreach($element->items AS $sub_element){
							if ($this->CI->acl->hasAccess(strtolower($sub_element->url))){
								$submenu .= '<li><a class="dropdown-item" href="'.base_url($sub_element->url).'">'.Lang($sub_element->name).'</a></li>';
								$have_subright = true; 
							}
						}
						$submenu .='</ul>';
						//si un sous-menu a des droits...
						if ($have_subright)
							$menu .= $submenu;
						$menu .= '</li>';
					}
				break;
				case 'link':
					foreach($def_menu->items AS $element){
						switch($element->type){
							case "link":
								if ($this->CI->acl->hasAccess(strtolower($element->url))){
									$have_right = true; 
									$menu .= '<li class="nav-item '.((isset($element->active)) ? 'active':'').'"><a class="nav-link" href="'.base_url($element->url).'">'.((isset($element->icon)) ? '<span class="oi '.$element->icon.'"></span> ':'').Lang($element->name).'</a></li>';
								} else {
									$this->CI->_debug(strtolower($element->url.':FALSE'));
								}
							break;
							case "divider":
								$menu .= '<li class="nav-item"><div class="dropdown-divider"></div></li>';
							break;
						}
					}
				break;
				case 'dropdown':
					if (!$name)
						$name = '<span class="oi '.$def_menu->icon.'">';
					if (count($def_menu->items) && $this->CI->acl->Islog()){
						$menu = '<div class="dropdown">';
						$menu .= '<a class="btn dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">'.$name.'</a>';
						$menu .= '<div class="dropdown-menu '.((isset($def_menu->align)) ? $def_menu->align:'').'">';
						foreach($def_menu->items AS $element){
							switch($element->type){
								case "link":
									if ($this->CI->acl->hasAccess(strtolower($element->url))){ 
										$have_right = true;
										$menu .= '<a class="dropdown-item" href="'.base_url($element->url).'">'.((isset($element->icon)) ? '<span class="oi '.$element->icon.'"></span> ':'').Lang($element->name).'</a>';
									} else {
										$this->CI->_debug(strtolower($element->url.':FALSE'));
									}
								break;
								case "divider":
									$menu .= '<hr class="dropdown-divider">';
								break;
							}
						}
						$menu .= '</div>';
					}
				break;
			}
			if ($have_right)
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
