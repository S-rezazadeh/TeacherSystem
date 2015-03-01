<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller
{

	public function index($sts = null)
	{
            $this->load->model('university_model');
            $universities = $this->university_model->getAllUniversity();
            
            
            switch ($sts) 
            {
                case null:
                    $sts = '';
                    break;
                case 'incorrect':
                    $sts = 'نام کاربری یا کلمه عبور اشتباه است.';
                    break;
                default:
                    $sts = 'خطایی در ورود رخ داد.';
            } 

            if($sts != null)
            {
                
            }
            else
            {
                $sts = '';
            }
            $data = array('universities' => $universities,'defTab'=>'','loginMsg'=>$sts);
            
            $this->load->library('form_validation');
            
            if($this->input->post('submit'))
            {
            
                $this->form_validation->set_rules('reg_name', 'نام', 'required|htmlspecialchars');
                $this->form_validation->set_rules('reg_password', 'کلمه عبور', 'required|matches[reg_password_conf]');
                $this->form_validation->set_rules('reg_email', 'ایمیل', 'required|valid_email|callback_free_email');
                $this->form_validation->set_rules('reg_university', 'university', 'required|integer');
                $this->form_validation->set_rules('captcha', 'کد امنیتی', 'required|callback_validate_captcha');
                
                $this->form_validation->set_message('required', '%s نباید خالی باشد');
                $this->form_validation->set_message('valid_email', 'آدرس ایمیل وارد شده باید معتبر باشد');
                $this->form_validation->set_message('matches', 'کلمات عبور وارد شده یکسان نیست');
                $this->form_validation->set_message('validate_captcha', 'کد امنیتی صحیح نیست');
                $this->form_validation->set_message('free_email', 'این ایمیل قبلا ثبت شده');
                
                
                if ($this->form_validation->run() == FALSE)
                {
                    $data['defTab'] = '<script>$(document).ready(function(){$(\'#log-reg a[href="#register"]\').tab("show")});</script>';
                    $content = $this->load->view('login',$data,true);//NULL->data , true is to load into varible

                    $this->load->view('master_view',array('content' => $content));
                }
                else
                {
                    //print_r($this->input->post());
                    $this->load->model('student_model');
                    $name=$this->input->post('reg_name');
                    $mail=$this->input->post('reg_email');
                    $pass=$this->input->post('reg_password');
                    $uni =$this->input->post('reg_university');
                    //echo $this->student_model->registerStudent($name,$pass,$mail,$uni);
                    $res = $this->student_model->registerStudent($name,$pass,$mail,$uni);
                    if($res>0)
                    {
                        
                        $this->session->set_userdata(array('userId'=>$res , 'name'=>$name,'role'=>'10'));
                        redirect("");
                    }
                    else
                        echo 'Unknown error';
                    //echo '<pre>'.print_r($this->student_model->isMailRegistered($mail),true).'</pre>';
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
        
        
        public function free_email()
        {
            $mail=$this->input->post('reg_email');
            $this->load->model('student_model');
            if($this->student_model->isMailRegistered($mail))
            {
                return false;
            }
            return true;

        }
        
        
        
        public function dologin()
        {
            $name=$this->input->post('login_user');
            $pass=$this->input->post('login_pass');
            
            $this->load->model('student_model');
            
            $login = $this->student_model->checkLogin($name,$pass);
            
            
            if($login)
            {
            
                if($this->input->post('login_rem')!=FALSE)
                {
                    $cookie = array(
                    'name'   => 'TS_LG_Info',
                    'value'  => $login['id'].'.'.sha1($login['salt']),
                    'expire' => '8400000',
                    );

                    $this->input->set_cookie($cookie); 
                }
                //print_r($this->input->post());
                //echo '<pre>'.print_r($login->row_array(),TRUE)."Row Number : ".$login->num_rows;
                
                
                $this->session->set_userdata(array('userId'=>$login['id'] , 'name'=>$login['name'],'role'=>$login['status']));
                
               redirect('/');
    
            }
            
            else
                redirect ('member/index/incorrect');
            
        }
               
}
