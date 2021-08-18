<?php

class Loginchecker
{
    private $CI;
    private $dontcheck = TRUE;

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
        $controller = $this->CI->uri->rsegment(1);
        $action     = $this->CI->uri->rsegment(2);
        $usercheck  = $this->CI->session->userdata('usercheck');
        
        if ( $usercheck && $usercheck->autorize) {
            // Check for ACL
            if (!$this->CI->acl->hasAccess() AND !$this->dontcheck) {
                //echo '<pre>'.print_r($this->CI->acl->getGuestPages(),TRUE).'</pre>';
                if (!in_array($controller . '/' . $action, $this->CI->acl->getGuestPages())) {
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
