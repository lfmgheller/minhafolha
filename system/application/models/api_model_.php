<?php

class api_model extends Model
{
    function api_model(){
        parent::Model();
    }
    
    function check_user_name($uname){
        $this->db->select('*');
        $this->db->where('user_name',$uname);
        $this->db->limit(1);
        return $this->db->get('users');
    }
    
    function register_user($data)
    {
        $this->db->insert('users',$data);
    }
    
    function check_authentication($uname,$pwd){
        $this->db->select('*');
        $this->db->where('user_name',$uname);
        $this->db->where('password',$pwd);
        $this->db->limit(1);
        return $this->db->get('users');
    }
    
    function update_user($data,$uid)
    {
        $this->db->where('user_id',$uid);
        $this->db->update('users',$data);
    }
    
    function add_files($data)
    {
        $this->db->insert('user_files',$data);
    }
    
    function get_user_details($uid)
    {
        $this->db->select('*');
        $this->db->where('user_id',$uid);
        $this->db->limit(1);
        return $this->db->get('users');
    }
    
    function get_nearby_users($uid,$lat,$lon,$miles)
    {
        return $this->db->query(" SELECT *,
 
            3956 * 2 * ASIN(SQRT( POWER(SIN((".$lat." -
            abs( 
            dest.latitude)) * pi()/180 / 2),2) + COS(".$lat." * pi()/180 ) * COS( 
            abs
            (dest.latitude) *  pi()/180) * POWER(SIN((".$lon." - dest.longitude) *  pi()/180 / 2), 2) ))

            as distance FROM users dest WHERE dest.user_id != ".$uid." having distance < ".$miles." ORDER BY distance limit 10");
    }
    
    function get_user_files_num($uid)
    {
        $this->db->select('*');
        $this->db->where('sentFiles_user_idF',$uid);
        $this->db->limit(1);
        return $this->db->get('user_sent_files');
    }
    
    function get_user_files($uid)
    {
        return $this->db->query('SELECT user_sent_files.*,user_files.* FROM user_sent_files
            LEFT JOIN user_files ON user_sent_files.sentFiles_file_idF = user_files.file_id
            WHERE user_sent_files.sentFiles_user_idF = '.$uid);
    }
    
    function insert_user_sent_files($data)
    {
        $this->db->insert('user_sent_files',$data);
    }
}
?>
