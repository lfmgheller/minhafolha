<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class api extends REST_Controller
{    
    

    function user_get()
    {
      $data="getmethod";
           // $this->response($data, 200); // 200 being the HTTP response code
            echo json_encode($data);
    }


    function rrmdir($dir) {
       if (is_dir($dir)) {
         $objects = scandir($dir);
         foreach ($objects as $object) {
           if ($object != "." && $object != "..") {
             if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
           }
         }
         reset($objects);
         rmdir($dir);
       }
     }



    function sendErrorMessage($errNo,$errMsg = NULL){
        $msg['status']='ERROR';
        if($errNo == 1)            
            $msg['error']='Parameters missing';
        
        else if($errNo == 2)
            $msg['error']=$errMsg;
        
        else if($errNo == 3)
            $msg['error']='Data Not Found';
        
        echo json_encode($msg);
        exit;
    }

    



    function getQuotes_get()
    {
        $this->load->model('api_model','api_model');   
        
        $_POST['deviceID']='1234567890';
        
        if(isset($_POST['deviceID']) && $_POST['deviceID'] != '')
            $deviceID=$_POST['deviceID'];
        else
            $this->sendErrorMessage (1);                
        
        
        $did=$this->api_model->checkDeviceID($deviceID);
        if($did->num_rows() > 0){
        
            $quotes=  $this->api_model->getQuotesForDevice($deviceID);
            if($quotes->num_rows() > 0)
            {
                $i=0;

                $data['status']='OK';            

                foreach ($quotes->result() as $r)
                {
                    $data['quotes'][$i]['quoteID']=$r->quotes_quoteID;
                    $data['quotes'][$i]['quoteText']=$r->quotes_quoteText;
                    $data['quotes'][$i]['quoteAuthor']=$r->authors_authorName;
                    $data['quotes'][$i]['quoteCat']=$r->cat_categoryName;
                    $i++;
                }

                $this->api_model->updateTimestamp($deviceID);

            }
            else
                $this->sendErrorMessage (3);
        }
        else
        {
            $quotes=  $this->api_model->getAllQuotes();
            if($quotes->num_rows() > 0)
            {
                $i=0;

                $data['status']='OK';            

                foreach ($quotes->result() as $r)
                {
                    $data['quotes'][$i]['quoteID']=$r->quotes_quoteID;
                    $data['quotes'][$i]['quoteText']=$r->quotes_quoteText;
                    $data['quotes'][$i]['quoteAuthor']=$r->authors_authorName;
                    $data['quotes'][$i]['quoteCat']=$r->cat_categoryName;
                    $i++;
                }

                $this->api_model->updateTimestamp($deviceID);

            }
            else
                $this->sendErrorMessage (3);
        }
        
        echo json_encode($data);
    }

    
    function getQuotes_post()
    {
        $this->load->model('api_model','api_model');        
        
        if(isset($_POST['deviceID']) && $_POST['deviceID'] != '')
            $deviceID=$_POST['deviceID'];
        else
            $this->sendErrorMessage (1);                
        
        
        $did=$this->api_model->checkDeviceID($deviceID);
        if($did->num_rows() > 0){
        
            $quotes=  $this->api_model->getQuotesForDevice($deviceID);
            if($quotes->num_rows() > 0)
            {
                $i=0;

                $data['status']='OK';            

                foreach ($quotes->result() as $r)
                {
                    $data['quotes'][$i]['quoteID']=$r->quotes_quoteID;
                    $data['quotes'][$i]['quoteText']=$r->quotes_quoteText;
                    $data['quotes'][$i]['quoteAuthor']=$r->authors_authorName;
                    $data['quotes'][$i]['quoteCat']=$r->cat_categoryName;
                    $i++;
                }

                $this->api_model->updateTimestamp($deviceID);

            }
            else
                $this->sendErrorMessage (3);
        }
        else
        {
            $quotes=  $this->api_model->getAllQuotes();
            if($quotes->num_rows() > 0)
            {
                $i=0;

                $data['status']='OK';            

                foreach ($quotes->result() as $r)
                {
                    $data['quotes'][$i]['quoteID']=$r->quotes_quoteID;
                    $data['quotes'][$i]['quoteText']=$r->quotes_quoteText;
                    $data['quotes'][$i]['quoteAuthor']=$r->authors_authorName;
                    $data['quotes'][$i]['quoteCat']=$r->cat_categoryName;
                    $i++;
                }

                $this->api_model->updateTimestamp($deviceID);

            }
            else
                $this->sendErrorMessage (3);
        }
        
        echo json_encode($data);
    }
    
    
    
}
