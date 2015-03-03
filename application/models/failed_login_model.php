<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Failed_Login_Model extends CI_Model
{
    public function add()
    {
        $sql = "insert into failedlogin(time,ip) values(?,?)";
        $this->db->query($sql, array(time(),$this->input->ip_address()));
    }
    
    public function clear()
    {
        $sql = "delete from failedlogin where time < ?";
        $this->db->query($sql, array(time()-$this->config->item('failed_login_timeout')));
    }
    
    
    public function isIpOk($ip)
    {
        $sql = "SELECT count(*) FROM failedlogin WHERE ip = ?";
        $result = $this->db->query($sql, array($ip));
        
        $info =  $result->row_array();
        if($info['count(*)']>$this->config->item('failed_login_allowed'))
        {
            return false;
        }
        return true;
    }
}