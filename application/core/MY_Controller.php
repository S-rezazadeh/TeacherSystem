<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        
    }
    
    
    
}


class UserLoggedIn_Controller extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $login = $this->session->userdata('role');
         if($login == false || $login == 0)
         {
             $ck = $this->input->cookie('TS_LG_Info');
             if($ck)
             {
                 $vals = explode('.', $ck);
                 if(isset($vals[0]) && isset($vals[1]))
                 {
                    $this->load->model('student_model');
                    $info = $this->student_model->checkCookie($vals[0],$vals[1]);
                   if($info)
                   {
                       //cookie is correct
                        $this->session->set_userdata(array('userId'=>$info['id'] , 'name'=>$info['name'],'role'=>$info['status']));
                   }
                   else
                       redirect('member/');
                 }
                 else
                     redirect('member/');
             }
             else
                redirect('member/');
         }
        
    }
    
}
