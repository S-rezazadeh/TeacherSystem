<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends UserLoggedIn_Controller
{

	public function index()
	{
                

            $data = array('sess' => $this->session->all_userdata());
            //$data = array('sess' => $this->input->cookie('TS_LG_Info'));
            $content = $this->load->view('admin_home',$data,true);//NULL->data , true is to load into varible

            $this->load->view('admin_master_page',array('content' => $content));
            

	}
        
        
        
        public function studentlist()
        {
            $data = array('sess' => $this->session->all_userdata());
            //$data = array('sess' => $this->input->cookie('TS_LG_Info'));
            $content = $this->load->view('admin_stlist',$data,true);//NULL->data , true is to load into varible

            $this->load->view('admin_master_page',array('content' => $content));
        }
        
        
        
        public function messagelist()
        {
            $data = array('sess' => $this->session->all_userdata());
            //$data = array('sess' => $this->input->cookie('TS_LG_Info'));
            $content = $this->load->view('admin_messages',$data,true);//NULL->data , true is to load into varible

            $this->load->view('admin_master_page',array('content' => $content));
        }
      
}
