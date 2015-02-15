<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{

	public function index()
	{
		$content = $this->load->view('home',null,true);//NULL->data , true is to load into varible

		$this->load->view('master_view',array('content' => $content));
	}
}