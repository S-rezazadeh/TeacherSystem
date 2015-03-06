<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        
    }
    
    function isLoggedIn()
    {
        $login = $this->session->userdata('role');
        if($login == false || $login == $this->config->item('unregistered', 'user_role'))
            return false;
        else
            return true;
    }
    
    function getUserRole()
    {
        return $this->session->userdata('role');
    }
    
    
    
}


class UserLoggedIn_Controller extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $login = $this->session->userdata('role');
         if($login == false || $login == $this->config->item('unregistered', 'user_role'))
         {
             $ck = $this->input->cookie($this->config->item('login_cookie_name'));
             if($ck)
             {
                 $vals = explode('.', $ck);
                 if(isset($vals[0]) && isset($vals[1]))
                 {
                    $this->load->model('student_model');
                    $info = $this->student_model->checkCookie($vals[0],$vals[1]);
                    if ($info) 
                    {
                        //cookie is correct
                        $this->session->set_userdata(
                                array('userId' => $info['id'],
                                    'name' => $info['name'],
                                    'role' => $info['status'],
                                    'mail' => $info['email'])
                        );
                        $login = $info['status'];
                    } 
                    else 
                    {
                        redirect('member/');
                        return;
                    }
                }
                 else
                 {
                     redirect('member/');
                     return;
                 }
             }
             else
             {
                redirect('member/');
                return;
             }
         }
        
         
         if($login==$this->config->item('email_not_validated', 'user_role'))
            redirect('member/emailverify');
         else if($login==$this->config->item('teacher_not_activated', 'user_role'))
            redirect('member/teacherverify');
        
    }
    
}
