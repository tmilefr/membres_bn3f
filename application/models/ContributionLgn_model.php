<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class ContributionLgn_model extends Core_model{

	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'contributionlgn');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'ContributionLgn.json');
		$this->_init_def();
	}

	function DeleteLink($id_cnt = null){
		if ($id_cnt){
			$this->db->where_in('id_cnt', $id_cnt)
				 ->delete($this->table);
		}
	}
}
?>