<?php
defined('BASEPATH') || exit('No direct script access allowed');

CONST PASSWORD_SALT = '6245nnx/OCIN';
CONST SITE_CAPTCHA_KEY = '6Lc7VAwcAAAAALPIYowkfQ65CSintUBXB4SdtAYX';
CONST SITE_CAPTCHA_SECRET_KEY = '6Lc7VAwcAAAAAIQmE8iugh2UemgtXkMCFHt478I5';

/* APP STUFF */
$config['app_name'] = 'Membres BN3F';
$config['slogan'] 	= 'Outil de gestion des membres de la BN3F';
$config['about'] 	= 'By NL';
$config['debug_app']= 'none'; //none,debug,profiler
$config['sidebar'] = 'on';

$config['crlf'] = '';

/* EMAIL */
$config['protocol'] = "smtp";
$config['smtp_host'] = "smtp.1and1.com";
$config['smtp_port'] = "587";
$config['smtp_user'] = "noreply@domain.com";
$config['smtp_pass'] = "noreply";
$config['smtp_crypto'] = 'tls';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";


