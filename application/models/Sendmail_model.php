<?php
defined('BASEPATH') || exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Sendmail_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		
		$this->_set('table'	, 'sendmail');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'date');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Sendmail.json');
		$this->_init_def();
	}
	
	//SELECT status,pdf,co.user, us.name,us.email FROM `sendmail` se LEFT JOIN `contribution` co ON se.user = co.id LEFT JOIN `users` us ON co.user = us.id
	function GetLog($id){
		$datas = $this->db->select('*')
		->where('sendmail.user', $id)
		->join('contribution', 'sendmail.user = contribution.id', 'left' )
		->join('users', 'contribution.user = users.id', 'left' )
		->order_by('sendmail.id', 'ASC')
		->get($this->table)
		
		->result();

		return $datas;
	}

}
?>