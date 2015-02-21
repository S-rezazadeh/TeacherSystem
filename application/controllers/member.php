<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller
{

	public function index()
	{
            $this->load->model('university_model');
            $universities = $this->university_model->getAllUniversity();
            
            
            $this->load->helper('captcha');
            $vals = array(
                'word' => rand(100000, 999999),
                'img_path' => 'tmp/captcha/',
                'img_url' => base_url().'tmp/captcha/',
                //'font_path' => './path/to/fonts/texb.ttf',
                'img_width' => '150',
                'img_height' => 30,
                'expiration' => 1200
                );

            $cap = create_captcha($vals);
                        
            
            $data = array('universities' => $universities,'defTab'=>'','captcha'=>$cap);
            
            $this->load->library('form_validation');
            
            if($this->input->post('submit'))
            {
                $this->load->library('form_validation');
            
                $this->form_validation->set_rules('reg_name', 'نام', 'required|htmlspecialchars');
                $this->form_validation->set_rules('reg_password', 'کلمه عبور', 'required|matches[reg_password_conf]');
                $this->form_validation->set_rules('reg_email', 'ایمیل', 'required|valid_email');
                $this->form_validation->set_rules('reg_university', 'university', 'required|integer');
                
                $this->form_validation->set_message('required', '%s نباید خالی باشد');
                $this->form_validation->set_message('valid_email', 'آدرس ایمیل وارد شده باید معتبر باشد');
                $this->form_validation->set_message('matches', 'کلمات عبور وارد شده یکسان نیست');
                
                
                if ($this->form_validation->run() == FALSE)
                {
                    $data['defTab'] = '<script>$(document).ready(function(){$(\'#log-reg a[href="#register"]\').tab("show")});</script>';
                    $content = $this->load->view('login',$data,true);//NULL->data , true is to load into varible

                    $this->load->view('master_view',array('content' => $content));
                }
                else
                {
                    print_r($this->input->post());
                }      
            }
            else
            {
                $content = $this->load->view('login',$data,true);//NULL->data , true is to load into varible

                $this->load->view('master_view',array('content' => $content));
            }

            
            
	}
}
