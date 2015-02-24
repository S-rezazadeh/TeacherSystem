<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller
{

	public function index()
	{
            $this->load->model('university_model');
            $universities = $this->university_model->getAllUniversity();
            
            $data = array('universities' => $universities,'defTab'=>'');
            
            $this->load->library('form_validation');
            
            if($this->input->post('submit'))
            {
            
                $this->form_validation->set_rules('reg_name', 'نام', 'required|htmlspecialchars');
                $this->form_validation->set_rules('reg_password', 'کلمه عبور', 'required|matches[reg_password_conf]');
                $this->form_validation->set_rules('reg_email', 'ایمیل', 'required|valid_email');
                $this->form_validation->set_rules('reg_university', 'university', 'required|integer');
                $this->form_validation->set_rules('captcha', 'کد امنیتی', 'required|callback_validate_captcha');
                
                $this->form_validation->set_message('required', '%s نباید خالی باشد');
                $this->form_validation->set_message('valid_email', 'آدرس ایمیل وارد شده باید معتبر باشد');
                $this->form_validation->set_message('matches', 'کلمات عبور وارد شده یکسان نیست');
                $this->form_validation->set_message('validate_captcha', 'کد امنیتی صحیح نیست');

                
                
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
        

        
        public function validate_captcha()
        {
            $sss=$this->input->post('captcha');
            //$this->form_validation->set_message('validate_captcha', 'session:'.$this->session->userdata['captcha'].'\nPosted val:'.$sss);
            //$this->form_validation->set_message('validate_captcha', FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg']);

            
            if($sss== $this->session->userdata['captcha'] && file_exists(FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg']))
            {
                unlink(FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg']);
                return true;
            }
            else
            {
                if(file_exists(FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg']))
                    unlink(FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg']);
                return false;
            }

        }     
        
}
