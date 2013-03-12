<?php

class auth_model extends Model
{
    function auth_model()
    {
        parent::Model();
    }

    function authentication($username,$password)
    {
        $this->db->select('*');
        $this->db->where('email',$username);
        $this->db->where('password_hash',$password);
        $this->db->limit(1);
        return $this->db->get('users');
    }

//    function addTempUser($data)
//    {
//        $this->db->insert('fa_user_temp',$data);
//    }
//
//    function checkActivationCode($code)
//    {
//        $this->db->select('*');
//        $this->db->where('activation_code',$code);
//        $this->db->limit(1);
//        return $this->db->get('fa_user_temp');
//    }
//
//    function addUser($data)
//    {
//        $this->db->insert('fa_user',$data);
//    }
//
//    function deleteTempUser($code)
//    {
//        $this->db->where('activation_code',$code);
//        $this->db->limit(1);
//        $this->db->delete('fa_user_temp');
//    }
}

?>