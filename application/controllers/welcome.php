<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller 
{

	public function index()
	{
            $this->load->model('university_model');
            $universities = $this->university_model->getAllUniversity();
            
            $this->load->view('welcome_message',array('universities'=>$universities));
	}
        
        public function test()
	{
            echo 'test<br />';
            print_r($this->input->post());
            if($this->input->post('submit'))
            {
                echo 'submitted';
            }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
