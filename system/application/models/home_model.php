<?php

class home_model extends Model
{
    function home_model()
    {
        parent::Model();
    }
    
    function registerUser($data)
    {
        $this->db->insert('users',$data);
    }
    
    function checkToken($token,$uid)
    {
        $this->db->select('*');
        $this->db->where('id',$uid);
        $this->db->where('confirmation_token',$token);
        return $this->db->get('users');
    }
    
    function updateUsersEntry($data,$uid,$fname)
    {
        $this->db->where($fname,$uid);
        $this->db->update('users',$data);
    }
    
    function login($email,$pwd)
    {
        $this->db->select('*');
        $this->db->where('email',$email);
        $this->db->where('password_hash',$pwd);
        $this->db->where('confirmed_at <>','0000-00-00 00:00:00');
        return $this->db->get('users');
    }
    
    function checkOldPassword($email,$pwd)
    {
        $this->db->select('*');
        $this->db->where('email',$email);
        $this->db->where('password_hash',$pwd);        
        return $this->db->get('users');
    }
    
    function checkEmail($email)
    {
        $this->db->select('*');
        $this->db->where('email',$email);
        return $this->db->get('users');
    }
}
?>
