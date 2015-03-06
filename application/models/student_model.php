<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_Model extends CI_Model
{
    private $id;
    private $name;
    private $role;
    private $mail;
    private $uid;
    private $lastLogin;
    private $lastIp;
    
    public function getId() 
    {
        return $this->id;
    }
    public function getName() 
    {
        return $this->name;
    }
    public function getRole() 
    {
        return $this->role;
    }
    public function getMail() 
    {
        return $this->mail;
    }
    public function getUId() 
    {
        return $this->uid;
    }
    public function getLastLogin() 
    {
        return $this->lastLogin;
    }
    public function getLastIp() 
    {
        return $this->lastIp;
    }
    
            
            
    function __construct() 
    {
        parent::__construct();
    }
    
    
    function isMailRegistered($mail)
    {
         $sql = "select id from student where email=?"; 
         $db= $this->db->query($sql, array("$mail")); 
         return $db->num_rows;
    }
            
    
    public function checkLogin($email,$pass)
    {   
        $sql = "SELECT * FROM student WHERE email = ? LIMIT 1";
        $result = $this->db->query($sql, array($email));
    
        
        if($result->num_rows != 1)
            return FALSE;
       
        
        $info = $result->row_array();
        if($info['pass']==$this->passwordGenerator($pass, $info['salt']))
        {
            $sql = "update student set lastlogin = ? , lastip = ? WHERE id = ?";
            $this->db->query($sql, array(time(),$this->input->ip_address(),$info['id']));
            return $info;
        }
        else
        {
            return false;
        }
        
    }
    

    
    function checkCookie($id,$hashSalt)
    {
        $sql = "SELECT * FROM student WHERE id = ? LIMIT 1";
        $result = $this->db->query($sql, array($id));
    
        if($result->num_rows != 1)
            return FALSE;
       
        
        $info = $result->row_array();
        if(sha1($info['salt'])==$hashSalt)
            return $info;
        else
            return false;
    }
            
    
    function passwordGenerator($pass,$salt)
    {
        return sha1($pass.$salt);
    }
    
    
    function registerStudent($name,$pass,$mail,$uni)
    {
        $this->load->helper('string');
        $salt = random_string('md5');
        $passToSave = $this->passwordGenerator($pass, $salt);
        
        $role;
        $mailActive = '';
        if($this->config->item('need_mail_verification'))
        {
            $role = $this->config->item('email_not_validated', 'user_role');
            $mailActive = random_string('md5');
        }
        else if ($this->config->item('need_teacher_verification')) 
        {
            $role = $this->config->item('teacher_not_activated', 'user_role');
        } 
        else
        {
            $role = $this->config->item('registered', 'user_role');
        }

        $data = array(
        'name' => $name ,
        'pass' => $passToSave ,
        'salt' => $salt ,
        'email' => $mail ,
        'status' => $role,
        'uid' => $uni ,
        'registerDate' => time() ,
        'lastip' => $this->input->ip_address(),
        'lastlogin' => time(),
        'mailactive' => $mailActive,
        );

        if($this->db->insert('student', $data)>0)
        {
            $this->name = $name;
            $this->id = $this->db->insert_id();
            $this->role = $role;
            $this->lastIp = $this->input->ip_address();
            $this->lastLogin = time();
            $this->mail=$mail;
            return $this->db->insert_id();
        }
        return 0;
    }
    
    
    function findMailActivationCode($id)
    {
        $sql = "SELECT mailactive FROM student WHERE id = ? LIMIT 1";
        $result = $this->db->query($sql, array($id));
    
        
        if($result->num_rows != 1)
            return NULL;
       
        
        $info = $result->row_array();
        return $info['mailactive'];
    }
    
    
    function validateActivationMail($id,$inpCode)
    {
        $code = $this->findMailActivationCode($id);
        if($code != null &&  $code == $inpCode )
        {
            $role = 0;
            if ($this->config->item('need_teacher_verification')) 
            {
                $role = $this->config->item('teacher_not_activated', 'user_role');
            } 
            else
            {
                $role = $this->config->item('registered', 'user_role');
            }
            
            $sql = "update student set status = ? WHERE id = ?";
            $this->db->query($sql, array($role,$id));
            
            
            return $role;
        }
        else
            return false;
    }
}
