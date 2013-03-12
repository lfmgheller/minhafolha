<?php

class Countrymodel extends Model {

    function Countrymodel() {
        parent::Model();

        //FreakAuth_light table prefix
        // $this->_prefix = 'waiit_';
        $this->_table = 'country';
    }

    function getcountry() {

        $this->db->select('*');
        return $this->db->get($this->_table);
        
    }

    function getcountrybyid($cat_id) {

        $this->db->select('*');
        $this->db->where('cat_id', $cat_id);
        return $this->db->get($this->_table);

    }

    function getimages() {

        $this->db->select('*');
         //$this->db->where('FK_catagory_id', $cat_id);
        return $this->db->get('images');
        
    }

    function insertcountry($data) {
        $this->db->insert($this->_table, $data);
    }
    function deletecat($frame_id) {


        $this->db->where('cat_id', $frame_id);
        $this->db->delete($this->_table);
    }

     function deletetipsBycatId($frame_id) {


        $this->db->where('cat_id', $frame_id);
        $this->db->delete('tips');
    }
    function updatecountry($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
    }
    function uploadImage($vals) {
        $this->db->insert('images', $vals);
    }
    function deleteImg($img_id) {
        $this->db->where('images_id', $img_id);
        $this->db->delete('images');
    }

}
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
