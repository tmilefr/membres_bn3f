<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Contribution_model extends Core_model{

	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'contribution');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Contribution.json');
		$this->_init_def();
	}

	function GetUserAndLog(){
		$datas = $this->db->select('*')
						   ->join('users', 'contribution.user = users.id', 'left' )
						   ->order_by('users.name', 'ASC')
						   ->get($this->table)
						   ->result();

		return $datas;
	}

}
?>