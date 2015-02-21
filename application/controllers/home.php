<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
           $login = $this->session->userdata('role');
            if($login == false || $login == 0)
            {
                redirect('member/');
            }
            else
            {
                $data = array('sess' => $this->session->all_userdata());
                $content = $this->load->view('home',$data,true);//NULL->data , true is to load into varible

                $this->load->view('master_view',array('content' => $content));
            }
            

	}
}
