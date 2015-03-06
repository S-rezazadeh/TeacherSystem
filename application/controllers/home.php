<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends UserLoggedIn_Controller
{

	public function index()
	{
            
            $data = array('sess' => $this->session->all_userdata());

            $content = $this->load->view('home',$data,true);//NULL->data , true is to load into varible

            $this->load->view('master_view',array('content' => $content));
            

	}

        
        
        
        
        
      
}
