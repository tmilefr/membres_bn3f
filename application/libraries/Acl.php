<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
//ALTER TABLE `users` ADD `role_id` INT(11) NOT NULL AFTER `created`;

class Acl
{
    protected $is_log = false;
    protected $CI;
    protected $userId = NULL;
    protected $userRoleId = NULL;
    protected $controller = NULL;
    protected $action = NULL;
    protected $permissions = [];
    protected $guestPages = [
        'home/logout',
        'home/login',
        'home/no_right',
        'home/index',
        'home'
    ];
    protected $DontCheck = FALSE;
    protected $_debug = FALSE;
    protected $_debug_array = [];
    /**
     * Constructor
     *
     * @param array $config            
     */
    public function __construct($config = array())
    {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('url');
        $this->CI->load->model('Acl_roles_model');
        $this->CI->load->model('Acl_users_model');

        $this->controller = strtolower($this->CI->uri->rsegment(1));
        $this->action     = strtolower($this->CI->uri->rsegment(2));
        $this->routes_hisory = [];
        $this->IsLog();

        $this->permissions = $this->CI->Acl_roles_model->getRolePermissions();
     }
    
    /**
     * Check if user is connected
     *
     * @access public
     * @return bool
     * 
     */
    public function IsLog(){
        $usercheck  = $this->CI->session->userdata('usercheck');
        if ( isset($usercheck) && $usercheck->autorize ){
            $this->is_log = true;  
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Check is current controller/method has access in role
     *
     * @access public
     * @return bool
     * 
     */
    public function hasAccess($currentPermission = null)
    {
        //echo debug($this->permissions);
        if ($this->DontCheck)
            return TRUE;
        if ($this->getUserId()) {            
            if (!$currentPermission)
                $currentPermission =  $this->controller . '/' . $this->action;
            if (isset($this->permissions[$this->getUserRoleId()]) && count($this->permissions[$this->getUserRoleId()]) > 0) {
                if (in_array( strtolower($currentPermission) , $this->permissions[$this->getUserRoleId()])) {
                    return TRUE;
                } else {
                    $this->_debug_array[] = $currentPermission.' NOT GRANTED';
                }
            }
        }        
        return FALSE;
    }
    
    /**
     * Check if current controller/method has access
     *
     * @access public
     * @return bool
     * 
     */
    public function Route(){
        if ($this->DontCheck)
            return TRUE;
       
        if ( $this->_get('is_log') ) {
            
            /*if ($this->action == 'index')
                return TRUE;*/
            // Check for ACL
            if (!$this->CI->acl->hasAccess()) {
                if ($this->controller . '/' . $this->action != '/home/no_right' && !in_array($this->controller . '/' . $this->action, $this->CI->acl->getGuestPages())) {
                    $this->routes_hisory[] = $this->controller . '/' . $this->action;
                    $this->CI->session->set_userdata('routes',  $this->routes_hisory); 
                    return redirect('/Home/no_right');
                } 
            } else {
                $this->_debug_array[] = $this->controller . '/' . $this->action.' GRANTED';
            }
        } else {
            if ($this->controller . '/' . $this->action != 'home/login')
                return redirect('/Home/login');
        }
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

	function __destruct(){
		if ($this->_debug){
			unset($this->CI);
			echo debug($this, __file__);
		}
	}
    
}
