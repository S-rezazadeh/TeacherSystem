<?php

class Student_Model extends CI_Model
{
    const STATUS_MAIL_NOT_ACTIVATED = 10;
    
    
    
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
            return $info;
        else
            return false;
        
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
        
        $data = array(
        'name' => $name ,
        'pass' => $passToSave ,
        'salt' => $salt ,
        'email' => $mail ,
        'status' => self::STATUS_MAIL_NOT_ACTIVATED,
        'uid' => $uni ,
        'registerDate' => time() ,
        );

        if($this->db->insert('student', $data)>0)
        {
            return $this->db->insert_id();
        }
        return 0;
    }
    
}
