<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
//ALTER TABLE `users` ADD `role_id` INT(11) NOT NULL AFTER `created`;

class Acl
{
    protected $CI;
    protected $userId = NULL;
    protected $userRoleId = NULL;
    protected $permissions = [];
    protected $guestPages = [
        'Home/login',
        'Home/index',
        'Home'
    ];
    protected $DontCheck = false;

    /**
     * Constructor
     *
     * @param array $config            
     */
    public function __construct($config = array())
    {
        $this->CI = &get_instance();
        // Load Session library
        $this->CI->load->library('session');
        // Load ACL model
        $this->CI->load->model('Acl_roles_model');
        $this->CI->load->model('Acl_users_model');
        $this->permissions = $this->CI->Acl_roles_model->getRolePermissions();
        $this->CI->_debug($this->permissions);
    }
    
    /**
     * Check is controller/method has access for role
     *
     * @access public
     * @return bool
     * 
     */
    public function hasAccess($currentPermission = null)
    {
        if ($this->DontCheck)
            return TRUE;

        if ($this->getUserId()) {            
            if (!$currentPermission)
                $currentPermission = $this->CI->uri->rsegment(1) . '/' . $this->CI->uri->rsegment(2);
            if (isset($this->permissions[$this->getUserRoleId()]) && count($this->permissions[$this->getUserRoleId()]) > 0) {
                if (in_array($currentPermission, $this->permissions[$this->getUserRoleId()])) {
                    return TRUE;
                }
            }
        }        
        return FALSE;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Return the value of user id from the session.
     * Returns 0 if not logged in
     *
     * @access private
     * @return int
     */
    private function getUserId()
    {
        if ($this->userId == NULL) {
            if ($this->CI->session->userdata('usercheck'))
                $this->userId = $this->CI->session->userdata('usercheck')->id;
            if ($this->userId === FALSE) {
                $this->userId = NULL;
            }
        }        
        return $this->userId;
    }

    /**
     * Return user role
     *
     * @return int
     */
    private function getUserRoleId()
    {
        if ($this->userRoleId == NULL) {
            // Set the role
            if ($this->CI->session->userdata('usercheck'))
                $this->userRoleId = $this->CI->session->userdata('usercheck')->role_id;
            if ($this->userId === FALSE) 
                $this->userRoleId = $this->CI->Acl_users_model->getUserRoleId($this->getUserId());
            if (! $this->userRoleId) {
                $this->userRoleId = 0;
            }
        }
       
        return $this->userRoleId;
    }
    
    public function getGuestPages()
    {
        return $this->guestPages;
    }

    public function _set($field,$value){
		$this->$field = $value;
	}

	public function _get($field){
		return $this->$field;
	}	
}
