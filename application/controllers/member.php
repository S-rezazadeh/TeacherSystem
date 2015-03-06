<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller
{

    function __construct() 
    {
        parent::__construct();
        
    }

    public function index($sts = null)
	{
        
            if($this->isLoggedIn())
            {
                redirect ('/');
                return;
            }
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
                case 'incorrectcaptcha':
                    $sts = 'کد امنیتی صحیح نیست.';
                    break;
                default:
                    $sts = 'خطایی در ورود رخ داد.';
                    break;
            } 

            if($sts != null)
            {
                
            }
            else
            {
                $sts = '';
            }
            
            $this->load->model('failed_login_model');
            $loginCaptcha = true;
            if($this->failed_login_model->isIpOk($this->input->ip_address()))
            {
                $loginCaptcha = false;
            }
            
            $data = array('universities' => $universities,'defTab'=>'','loginMsg'=>$sts , 'showLoginCaptcha'=>$loginCaptcha);
            
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
                    $res = $this->student_model->registerStudent($name,$pass,$mail,$uni);
                    if($res>0)
                    {
                        $this->session->set_userdata(
                                array(
                                    'userId'=>$res ,
                                    'name'=>$this->student_model->getName(),
                                    'role'=>$this->student_model->getRole(),
                                    'mail'=>$this->student_model->getMail()
                                    ));
                        if($this->student_model->getRole() == $this->config->item('email_not_validated', 'user_role'))
                            redirect("/member/resendmail");
                        else
                            redirect ("/");
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
        
        
        public function logout() 
        {
            $this->session->sess_destroy();
            $this->load->helper('cookie');
            delete_cookie($this->config->item('login_cookie_name'));
            redirect('/');
            
        }

        
        public function validate_captcha($type = 'register')
        {
            $sss = '';
            if($type == 'login')
                $sss=$this->input->post('login_captcha');
            else
                $sss=$this->input->post('captcha');

            //$this->form_validation->set_message('validate_captcha', FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg']);

            $path = FCPATH.CAPTCHA_PATH.$this->session->userdata['capimg'];
            if($sss== $this->session->userdata['captcha'] && file_exists($path))
            {
                unlink($path);
                return true;
            }
            else
            {
                if(file_exists($path))
                    unlink($path);
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
            $this->load->model('failed_login_model');
            
            $this->failed_login_model->clear();
            
            if(!$this->failed_login_model->isIpOk($this->input->ip_address()))
            {
                if(!$this->validate_captcha('login'))
                    redirect ('member/index/incorrectcaptcha');
            }
            
            $login = $this->student_model->checkLogin($name,$pass);
            
            
            if($login)
            {
            
                if($this->input->post('login_rem')!=FALSE)
                {
                    $cookie = array(
                    'name'   => $this->config->item('login_cookie_name'),
                    'value'  => $login['id'].'.'.sha1($login['salt']),
                    'expire' => $this->config->item('login_cookie_expire'),
                    );

                    $this->input->set_cookie($cookie); 
                }
                //print_r($this->input->post());
                //echo '<pre>'.print_r($login->row_array(),TRUE)."Row Number : ".$login->num_rows;
                
                
                $this->session->set_userdata(array('userId'=>$login['id'] , 'name'=>$login['name'],'role'=>$login['status'],'mail'=>$login['email']));
                
               redirect('/');
    
            }
            
            else
            {
                $this->failed_login_model->add();
                redirect ('member/index/incorrect');
            }
            
        }
               
        
        public function teacherverify() 
        {
            $this->load->library('parser');
            $data = array();
            $msg = $this->parser->parse(TEMPLATE_PATH . 'wating_for_teacher_activation', $data, TRUE);
            $data = array('msg' => $msg);

            $content = $this->load->view('user_msg',$data,true);//NULL->data , true is to load into varible

            $this->load->view('master_view',array('content' => $content));
        }
        
        
        public function emailverify($message = null) 
        {
            
            $this->load->library('parser');
            $msg = '';
            switch ($message) 
            {
                case null:
                case 'sent':
                $data = array(
                    'email_address' => $this->session->userdata('mail'),
                    'resend_link' => site_url('member/resendmail')   );
                $msg = $this->parser->parse(TEMPLATE_PATH . 'email_not_verified', $data, TRUE);

                break;
            
            
                case 'errorsend':
                    $msg = $this->config->item('mail_send_error', 'messages');
                    break;

            default:
                $msg = $this->config->item('general_error', 'messages');
                break;
        }
            
            
            $data = array('msg' => $msg);

            $content = $this->load->view('user_msg',$data,true);//NULL->data , true is to load into varible

            $this->load->view('master_view',array('content' => $content));
        }
        
        
        public function verifymailcode($userId=null , $code=null)
        {
            if(isset($code) && isset($userId))
            {
                $this->load->model('student_model');
                $res = $this->student_model->validateActivationMail($userId,$code);
                if($res != false)
                {
                    if($this->session->userdata('role') == $this->config->item('email_not_validated', 'user_role'))
                            $this->session->set_userdata('role', $res);
                    redirect('/');
                }
            }
            else
            {
                $data = array('msg' => $this->config->item('general_error', 'messages'));

                $content = $this->load->view('user_msg',$data,true);//NULL->data , true is to load into varible

                $this->load->view('master_view',array('content' => $content));
                return;
            }
            
        }
        
        
        public function resendmail()
        {
            if($this->getUserRole()==$this->config->item('email_not_validated', 'user_role'))
            {
                
                $userId = $this->session->userdata('userId');
                $this->load->model('student_model');
                $code = $this->student_model->findMailActivationCode($userId);
                
                
                
                $this->load->library('parser');
                $data = array('link' => site_url('member/verifymailcode/'.$userId.'/'.$code));
                $msg=$this->parser->parse(TEMPLATE_PATH.'email_to_verify', $data , TRUE);
                
                $mail = $this->session->userdata('mail');
                
                
                
                // Loads the email library
                $this->load->library('email');
                // FCPATH refers to the CodeIgniter install directory
                // Specifying a file to be attached with the email
                // if u wish attach a file uncomment the script bellow:
                //$file = FCPATH . 'yourfilename.txt';
                // Defines the email details
                
                $this->email->initialize();
                
                
                $this->email->from($this->config->item('send_mail_from'), $this->config->item('send_mail_name'));
                $this->email->to($mail);
                $this->email->subject($this->config->item('verify_email_subject', 'messages'));
                $this->email->message($msg);
                //also this script
                //$this->email->attach($file);
                // The email->send() statement will return a true or false
                // If true, the email will be sent
                if ($this->email->send()) 
                {
                    redirect('/member/emailverify/sent');
                } 
                else 
                {
                    redirect('/member/emailverify/errorsend');
                }
            }
            else
            {
                redirect ('/member/index');
            }
        }
        
}
