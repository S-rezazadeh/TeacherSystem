<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends UserLoggedIn_Controller
{

	public function index()
	{
                
            echo $this->input->server('REMOTE_ADDR');

            $data = array('sess' => $this->session->all_userdata());
            //$data = array('sess' => $this->input->cookie('TS_LG_Info'));
            $content = $this->load->view('home',$data,true);//NULL->data , true is to load into varible

            $this->load->view('master_view',array('content' => $content));
            

	}
        
        
      
}
