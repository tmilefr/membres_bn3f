<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
//ALTER TABLE `users` ADD `role_id` INT(11) NOT NULL AFTER `driver`;
class Acl
{
    protected $CI;

    protected $userId = NULL;

    protected $userRoleId = NULL;
    protected $permissions = [];

    protected $guestPages = [
        'Home/login'
    ];

    protected $_config = [
        'acl_user_session_key' => 'user_id'
    ];

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
    }

    public function getAclConfig($key = NULL)
    {
        if ($key) {
            return $this->_config[$key];
        }
        
        return $this->_config;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Check is controller/method has access for role
     *
     * @access public
     * 
     * @return bool
     */
    public function hasAccess($currentPermission = null)
    {
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
    
    // --------------------------------------------------------------------
    
    /**
     * Return user role
     *
     * @return int
     */
    private function getUserRoleId()
    {
        if ($this->userRoleId == NULL) {
            // Set the role
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
}
