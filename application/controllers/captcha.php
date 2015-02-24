<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller
{

	public function index()
	{
            $this->load->model('university_model');
            $universities = $this->university_model->getAllUniversity();
            
            $capCode = rand(100000 , 999999);
            
            //echo $this->session->userdata['captcha'];

            $this->load->helper('captcha');
            $vals = array(
                'word' => $capCode ,
                'img_path' => CAPTCHA_PATH,
                'img_url' => base_url().CAPTCHA_PATH,
                //'font_path' => './path/to/fonts/texb.ttf',
                'img_width' => '150',
                'img_height' => 40,
                'expiration' => 800
                );

            $cap = create_captcha($vals);
            
            $this->session->set_userdata(array('captcha'=>$capCode , 'capimg'=>$cap['time'].'.jpg'));
            
            
            echo $cap['image'];
            
	}
        

        
}
