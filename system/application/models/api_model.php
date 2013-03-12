<?php

class api_model extends Model
{
    function api_model(){
        parent::Model();
    }
    
   
    function getQuotesForDevice($deviceID=NULL)
    {       
        return $this->db->query('SELECT edu_quotes.*,edu_categories.*,edu_authors.* FROM edu_quotes
            LEFT JOIN edu_categories ON edu_categories.cat_categoryID = edu_quotes.quotes_categoryIDF
            LEFT JOIN edu_authors ON edu_authors.authors_authorID = edu_quotes.quotes_authorIDF
            WHERE edu_quotes.quotes_timestamp > (SELECT edu_lastsenttime.lst_timestamp FROM edu_lastsenttime WHERE edu_lastsenttime.lst_deviceID = '.$deviceID.')');
    }
    
    function updateTimestamp($deviceID=NULL)
    {
//        $this->db->query('UPDATE edu_lastsenttime SET lst_timestamp = now() WHERE lst_deviceID = '.$deviceID);
        $this->db->query('INSERT INTO edu_lastsenttime(lst_deviceID) values('.$deviceID.') ON DUPLICATE KEY UPDATE lst_timestamp = now()');
    }
    
    function getAllQuotes()
    {
        return $this->db->query('SELECT edu_quotes.*,edu_categories.*,edu_authors.* FROM edu_quotes
            LEFT JOIN edu_categories ON edu_categories.cat_categoryID = edu_quotes.quotes_categoryIDF
            LEFT JOIN edu_authors ON edu_authors.authors_authorID = edu_quotes.quotes_authorIDF
            ');
    }
    
    
    function checkDeviceID($deviceID)
    {
        $this->db->select('*');
        $this->db->where('lst_deviceID',$deviceID);
        return $this->db->get('edu_lastsenttime');
    }
}
?>
