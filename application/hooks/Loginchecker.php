<?php

class Loginchecker
{
    private $CI;
    private $DontCheck  = FALSE;
    private $_debug     = TRUE;
    function __construct()
    {
        $this->CI = & get_instance();
        
        $this->CI->load->helper('url');
        $this->CI->load->library('Acl');
         
        if (! isset($this->CI->session)) { 
            $this->CI->load->library('session'); 
        }    
    }

    function loginCheck()
    {
        $controller = strtolower($this->CI->uri->rsegment(1));
        $action     = strtolower($this->CI->uri->rsegment(2));
        $usercheck  = $this->CI->session->userdata('usercheck');

        if ($this->DontCheck)
            return TRUE;
        
        if ( $usercheck && $usercheck->autorize) {
            // Check for ACL
            if (!$this->CI->acl->hasAccess()) {
                if ($this->_debug){
                    echo '<p>'.$controller . '/' . $action.'</p>';
                    echo '<pre>'.print_r($this->CI->acl->getGuestPages(),TRUE).'</pre>';
                    echo '<pre>'.print_r($this->CI->acl->_get('permissions'),TRUE).'</pre>';
                }

                if (!in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
                    die();
                    return redirect('/Home/no_right');
                } 
            }
        } else {
            if (!in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
                echo "need login";
                return redirect('/Home/login');
            }
        }
    }
}

?>
