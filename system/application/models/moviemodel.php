<?php

class Moviemodel extends Model {

    function Moviemodel() {
        parent::Model();

        //FreakAuth_light table prefix
        // $this->_prefix = 'waiit_';
        $this->_table = 'movie';
    }

     function getmovies() {

        $this->db->select('*');
        return $this->db->get($this->_table);

    }

    function insertmovie($data) {
        $this->db->insert($this->_table, $data);
       return $this->db->insert_id();
    }

    function insertmovie_country($data) {
        $this->db->insert('country_movie', $data);
    }

     function deletetips($tips_id) {


        $this->db->where('id', $tips_id);
        $this->db->delete($this->_table);
    }

    function gettipsById($id) {

        $this->db->select('*');
        $this->db->where('id', $id);
        return $this->db->get($this->_table);

    }

    function getCatagoryById($id) {

        $this->db->select('*');
        $this->db->where('cat_id', $id);
        return $this->db->get('catagory');

    }

     function updatetips($where,$data) {
         print_r($where);
         $this->db->where('id',$where);
        $this->db->update($this->_table, $data);
    }

     function deletetips_link($tips_id) {

        $this->db->where('f_id', $tips_id);
        $this->db->delete('tips_links');

       
    }

     function gettipslinksById($id) {

        $this->db->select('*');
        $this->db->where('f_id',$id);
         $query = $this->db->get('tips_links');
            if ($query->num_rows()>0)
            {
                return $query->result_array();
            }
        	return null;
        
        

    }
}
?>
