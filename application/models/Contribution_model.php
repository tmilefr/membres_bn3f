<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Contribution_model extends Core_model{

	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'contribution');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Contribution.json');
		$this->_init_def();
	}

	function get_all_ids(){
		$datas = $this->db->select('id')
		->get($this->table)
		->result();
		$ids = [];
		foreach($datas AS $data){
			$ids[] = $data->id;
		}
		return $ids;
	}

	function GetUserAndLog(){
		$datas = $this->db->select('contribution.*,users.name,users.surname,users.email,users.section')
						   ->join('users', 'contribution.user = users.id', 'left' )
						   ->order_by('users.section', 'ASC')
						   ->order_by('users.name', 'ASC')
						   ->get($this->table)
						   ->result();

		return $datas;
	}

	function UpdateAmount($id, $amount){
		$this->db->where($this->key, $id);
		$this->db->update($this->table, ['amount'=>$amount] );
		$this->_debug_array[] = $this->db->last_query();
	}

}
?>