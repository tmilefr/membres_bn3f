<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/* Lib pour JWT */ 
/*$autoload = str_replace('application','',APPPATH).'vendor/autoload.php'; //fix for Windows
require_once($autoload);
=> REPLACE BY config.php $config['composer_autoload'] = 'vendor/autoload.php';
*/
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/* FACTORY AUTH */
class Auth
{
    protected $connected_user = null;
    protected $_debug = FALSE;
    protected $msg = [];
    protected $role_famille = 2;
    protected $secretKey = null;
    public    $CI = null;


    /**
     * Constructor
     *
     * @param array $config            
     */
    public function __construct($config = array())
    {
        $this->CI = &get_instance();
        $this->CI->Loadmodel('Acl_users_model');
        //$this->CI->load->library('RestClient', $this->api);

		$this->CI->config->load('secured');
		$this->secretKey = API_KEY;
        $this->Init();
    }
    
    function Init(){
        //un utilisateur est il connecté ? on centralise les appels à ses données.
        $this->connected_user = $this->CI->session->userdata('connected_user');
        if (!isset($this->connected_user->autorize)){ //initialisation de l'objet pour la sécurité
            $this->connected_user  = new StdClass();
            $this->connected_user->autorize =  false;
            $this->connected_user->type  = "none";
            $this->connected_user->name = 'nobody';
            $this->connected_user->id = 0;     
            $this->connected_user->role_id = 0;
            $this->connected_user->msg = '';             
        }      
    }

    /**
     * Decode JWT
     *
     * @access public
     * @return user
     * 
     */
    public function EncodeJWT(){
        try{
            $issuer_claim = __CLASS__; // this can be the servername
            $audience_claim = "API access";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim; //not before in seconds
            $expire_claim = $issuedat_claim + 6000; // expire time in seconds => todo in params
            $this->connected_user->token = '';//pour éviter de ré-encoder le token sur une reprise
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => $this->connected_user
            );
            $jwt = JWT::encode($token, $this->secretKey, 'HS256');

            $this->connected_user->token = $jwt;
            $this->connected_user->expireAt = $expire_claim;
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
            http_response_code(401);
            die;
        }
    }

     /**
     * Decode JWT
     *
     * @access public
     * @return connected user from token if any
     * 
     */
    public function DecodeJWT($token){
        try{
            $decoded = JWT::decode($token,  new Key($this->secretKey, 'HS256') ); 
            //$this->ApiMode = true;
            if (isset($decoded->data)){
                $this->connected_user->autorize =  $decoded->data->autorize;
                $this->connected_user->type  = $decoded->data->type;
                $this->connected_user->name = $decoded->data->name;
                $this->connected_user->id = $decoded->data->id;    
                $this->connected_user->role_id = $decoded->data->role_id;
                $this->connected_user->msg = $this->CI->lang->line('JWT_ACCESS');
            } else {
                $this->connected_user->msg = $this->CI->lang->line('NO_JWT_ACCESS');
            }
            $this->CI->session->set_userdata('connected_user', $this->connected_user); 
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
            http_response_code(401);
            die;
        }
    }


    function Login($data){
        $row  = $this->CI->Acl_users_model->verifyLogin($data['login'], $data['password']);
        $this->msg[] = $this->CI->Acl_users_model->_get('_debug_array');
        if ($row){
            $this->connected_user->type  = "sys";
            $this->connected_user->role_id = $row['role_id'];
            $this->connected_user->name = $row['login'];
            $this->connected_user->autorize = true;
            $this->connected_user->id = $row['id'];
        } else {
            $this->connected_user->msg = Lang('ERROR_CNX_USER');
        }  
        if (isset($this->connected_user->autorize) AND  $this->connected_user->autorize == TRUE ){
            $this->CI->auth->EncodeJWT();
            $this->CI->session->set_userdata('connected_user', $this->connected_user); 
        } 
        return $this->connected_user;      
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
