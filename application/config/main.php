<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['failed_login_timeout'] = 3600;//in second
$config['failed_login_allowed'] = 5;
$config['login_cookie_name'] = 'TS_LG_Info';
$config['login_cookie_expire'] = '8400000';//for who using remmeber me -- in second



$config['send_mail_from'] = 'test@arashdn.ir';
$config['send_mail_name'] = 'Arashdn';



//ًRegistration settings
$config['need_mail_verification'] = true;
$config['need_teacher_verification'] = false;








// Roles
//NOTE: DO NOT Change this.
$config['user_role']['unregistered'] = 0;


$config['user_role']['admin'] = 1;



$config['user_role']['email_not_validated'] = 10;
$config['user_role']['teacher_not_activated'] = 11;
$config['user_role']['registered'] = 12;

?>