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
    
//    public $user_name;
//    public $password;


//    function api(){
//        parent::__construct();
//        
//        $this->user_name='';
//        $this->password='';
//    }


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

    function post_var(){
        if(isset($_POST['user_name']) && $_POST['user_name'] != '')
            $this->user_name=$_POST['user_name'];
        
        if(isset($_POST['password']) && $_POST['password'] != '')
            $this->password=$_POST['password'];
//        return $post_data;
    }
    
    function get_var($post_var){
        foreach ($post_var as $val){
            if(isset($_GET[$val]))
                $post_data[$val]=$_GET[$val];
        }
        
        return $post_data;
    }


    function sendErrorMessage($errNo,$errMsg = NULL){
        $msg['response']='failure';
        if($errNo == 1)            
            $msg['msg']='Parameters missing';
        
        else if($errNo == 2)
            $msg['msg']=$errMsg;
        
        echo json_encode($msg);
        exit;
    }

    
    // LOGIN AUTHENTICATION
    function login_post()
    {
        $this->load->model('api_model','api_model');        

        if(isset($_POST['userName']) && $_POST['userName']!='' && isset($_POST['password']) && $_POST['password']!= ''){
            $uname=$_POST['userName'];
            $pwd=md5($_POST['password']);
        }
        else{
            $this->sendErrorMessage(1);
        }
                
//        $this->post_var();
//        
//        if($this->user_name != '' && $this->password != ''){
//            $uname=  $this->user_name;
//            $pwd=  $this->password;
//        }
        
        $login=$this->api_model->check_authentication($uname,$pwd);

        if($login->num_rows() > 0)
        {       
            $msg['response']='success';
            $msg['msg']='Login successfull';
            
            foreach ($login->result() as $r)
            {
                $user_id=$r->user_id;
            }
            $msg['userID']=$user_id;
            
            $files=$this->api_model->get_user_files_num($user_id);
            if($files->num_rows() > 0)            
                $msg['flag']="true";            
            else
                $msg['flag']="false";
        }
         else {
             $this->sendErrorMessage(2,"Login Failure");
        }

        echo json_encode($msg);
    }

    function login_get()
    {
        $this->load->model('api_model','api_model');        
        
        if(isset($_POST['userName']) && $_POST['userName']!='' && isset($_POST['password']) && $_POST['password']!= ''){
            $uname=$_POST['userName'];
            $pwd=md5($_POST['password']);
        }
        else{
            $this->sendErrorMessage(1);
        }
        
        
//        $this->post_var();
//        
//        if($this->user_name != '' && $this->password != ''){
//            $uname=  $this->user_name;
//            $pwd=  $this->password;
//        }
//        
        $login=$this->api_model->check_authentication($uname,$pwd);

        if($login->num_rows() > 0)
        {       
            $msg['response']='success';
            $msg['msg']='Login successfull';
            
            foreach ($login->result() as $r)
            {
                $user_id=$r->user_id;
            }
            $msg['userID']=$user_id;
            
            $files=$this->api_model->get_user_files_num($user_id);
            if($files->num_rows() > 0)            
                $msg['flag']="true";            
            else
                $msg['flag']="false";
        }
         else {
             $this->sendErrorMessage(2,"Login Failure");
        }

        echo json_encode($msg);
    }

    
    
    function register_get()
    {
        $this->load->model('api_model','api_model');

//        $post_var=array("user_name","password","name","email","latitude","longitude","device_id","status");
//        
//        $post_data=$this->get_var($post_var);
        
        if(isset($_POST['userName']) && $_POST['userName'] != '' && isset($_POST['password']) && $_POST['password'] != '' && isset($_POST['name']) && $_POST['name'] != '' && isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['deviceID']) && $_POST['deviceID'] != ''){
            $data['users_userName']=$_POST['userName'];
            $data['users_password']=md5($_POST['password']);
            $data['users_name']=$_POST['name'];
            $data['users_email']=$_POST['email'];
            $data['users_deviceID']=$_POST['deviceID'];
        }
        else
            $this->sendErrorMessage(1);        
        
        $post_data['user_name']="saurabh";
        $post_data['password']="123456";
        $post_data['name']="saurabh";
        $post_data['latitude']="12.56585";
        $post_data['longitude']="83.455";

        $uname=$this->api_model->check_user_name($data['users_userName']);
        if($uname->num_rows() > 0)
        {
            $this->sendErrorMessage(2,"Username is already taken");
        }
        else
        {            
            $this->api_model->register_user($data);
            
            $user_id=$this->db->insert_id();
            
            $msg['response']="success";
            $msg['msg']="Registration successful.";
            $msg['userID']=$user_id;
            $msg['flag']='false';
        }
        
        echo json_encode($msg);
    }


    // REGISTER NEW USER
    function register_post()
    {
        $this->load->model('api_model','api_model');

//        $post_var=array("user_name","password","name","email","latitude","longitude","device_id","status");
//        
//        $post_data=$this->post_var($post_var);   

        
        if(isset($_POST['userName']) && $_POST['userName'] != '' && isset($_POST['password']) && $_POST['password'] != '' && isset($_POST['name']) && $_POST['name'] != '' && isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['deviceID']) && $_POST['deviceID'] != ''){
            $data['users_userName']=$_POST['userName'];
            $data['users_password']=md5($_POST['password']);
            $data['users_name']=$_POST['name'];
            $data['users_email']=$_POST['email'];
            $data['users_deviceID']=$_POST['deviceID'];
        }
        else
            $this->sendErrorMessage(1);
        
        $uname=$this->api_model->check_user_name($data['users_userName']);
        if($uname->num_rows() > 0)
        {
            $this->sendErrorMessage(2,"Username is already taken");
        }
        else
        {
//            $post_data['password']=md5($post_data['password']);            
            $this->api_model->register_user($data);
            
            $user_id=$this->db->insert_id();          
            
            $msg['response']="success";
            $msg['msg']="Registration successful.";
            $msg['userID']=$user_id;
            $msg['flag']='false';
        }
        
        echo json_encode($msg);
    }

   
    
    function send_files_post(){
        $file_ids=array();
        
        $this->load->model('api_model','api_model');
        
//        $post_var=array("user_id","music","video","image","doc","msg","miles");
//        
//        $post_data=$this->post_var($post_var);
        
        
        if(isset($_POST['userID']) && $_POST['userID'] != '')
            $data['users_userID']=$_POST['userID'];
        
        
        $uid=$data['users_userID'];
        
        $data['file_user_idF']=$uid;
        $data['file_msg']=$post_data['msg'];
        
        if(isset($post_data['music']) && $post_data['music']!=''){
            $data['file_name']=$post_data['music'];
            $data['file_type']="music";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }

        if(isset ($post_data['video']) && $post_data['video']!=''){
            $data['file_name']=$post_data['video'];
            $data['file_type']="video";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }

        if(isset ($post_data['image']) && $post_data['image']!=''){
            $data['file_name']=$post_data['image'];
            $data['file_type']="image";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }

        if(isset ($post_data['doc']) && $post_data['doc']!=''){
            $data['file_name']=$post_data['doc'];
            $data['file_type']="doc";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }
        
        
        $user=$this->api_model->get_user_details($uid);
        if($user->num_rows() > 0)
        {
            foreach ($user->result() as $r)
            {
                $latitude=$r->latitude;
                $longitude=$r->longitude;
            }
        }        
        if(isset($post_data['miles']) and !empty($post_data['miles']))
        	$user_data['miles']=$post_data['miles'];
        else $post_data['miles']=$user_data['miles']=100;
        $this->api_model->update_user($user_data,$uid);
        
        $nearby_users=$this->api_model->get_nearby_users($uid,$latitude,$longitude,$post_data['miles']);
        
        if($nearby_users->num_rows() > 0)
        {            
            foreach ($nearby_users->result() as $row)
            {                
                $u_sent_files_data['sentFiles_user_idF']=$row->user_id;
                
                $u_sent_files_data['sentFiles_sent_user_idF']=$uid;
            
                foreach ($file_ids as $fid){
                    $u_sent_files_data['sentFiles_file_idF']=$fid;

                    $this->api_model->insert_user_sent_files($u_sent_files_data);
                }
            }            
        }
        
//        $dir="uploads/users/".$uid;
//        if(!is_dir($dir))
//            mkdir ($dir,0777);
//
//
//        $config['upload_path'] = $dir."/";
//        $path=$config['upload_path'];
//        $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPG|JPEG';
//        $config['max_size'] = '1024';
//        $config['max_width'] = '1920';
//        $config['max_height'] = '1280';
//        $this->load->library('upload');
//
//        foreach ($_FILES as $key => $value)
//        {
//            if (!empty($key['name']))
//            {
//                $this->upload->initialize($config);
//                if (!$this->upload->do_upload($key))
//                {
//                    $errors = $this->upload->display_errors();                        
//                }
//                else
//                {
//                    
//                }
//            }
//        }
        
        $msg['response']="success";
        $msg['msg']="file sending successfull";        
        echo json_encode($msg);
    }

    
    
    function send_files_get(){
        $file_ids=array();
        
        $this->load->model('api_model','api_model');
        
        $post_var=array("user_id","music","video","image","doc","msg","miles");
        
        $post_data=$this->post_var($post_var);

        $post_data['user_id']=47;
        $post_data['music']='dsgfds';
//        $post_data['video']='dsgfds';
//        $post_data['image']='dsgfds';
//        $post_data['doc']='dsgfds';
        $post_data['msg']='dsgfds';
        $post_data['miles']=10;

        $uid=$post_data['user_id'];
        
        $data['file_user_idF']=$uid;
        $data['file_msg']=$post_data['msg'];

        if(isset($post_data['music'])){
            $data['file_name']=$post_data['music'];
            $data['file_type']="music";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }

        if(isset ($post_data['video'])){
            $data['file_name']=$post_data['video'];
            $data['file_type']="video";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }

        if(isset ($post_data['image'])){
            $data['file_name']=$post_data['image'];
            $data['file_type']="image";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }

        if(isset ($post_data['doc'])){
            $data['file_name']=$post_data['doc'];
            $data['file_type']="doc";

            $this->api_model->add_files($data);
            $file_ids[]=  $this->db->insert_id();
        }
        
        
        $user=$this->api_model->get_user_details($uid);
        if($user->num_rows() > 0)
        {
            foreach ($user->result() as $r)
            {
                $latitude=$r->latitude;
                $longitude=$r->longitude;
            }
        }        
        if(isset($post_data['miles']) and !empty($post_data['miles']))
        	$user_data['miles']=$post_data['miles'];
        else $post_data['miles']=$user_data['miles']=100;
        $this->api_model->update_user($user_data,$uid);
        
        echo $post_data['miles']*0.000621371;
        $nearby_users=$this->api_model->get_nearby_users($uid,$latitude,$longitude,$post_data['miles']*0.000621371);
        
        
        echo '<pre>';
        print_r($nearby_users->result());
        if($nearby_users->num_rows() > 0)
        {            
            foreach ($nearby_users->result() as $row)
            {                
                $u_sent_files_data['sentFiles_user_idF']=$row->user_id;
                
                $u_sent_files_data['sentFiles_sent_user_idF']=$uid;
            
                foreach ($file_ids as $fid){
                    $u_sent_files_data['sentFiles_file_idF']=$fid;

                    $this->api_model->insert_user_sent_files($u_sent_files_data);
                }
            }            
        }
        
//        $dir="uploads/users/".$uid;
//        if(!is_dir($dir))
//            mkdir ($dir,0777);
//
//
//        $config['upload_path'] = $dir."/";
//        $path=$config['upload_path'];
//        $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPG|JPEG';
//        $config['max_size'] = '1024';
//        $config['max_width'] = '1920';
//        $config['max_height'] = '1280';
//        $this->load->library('upload');
//
//        foreach ($_FILES as $key => $value)
//        {
//            if (!empty($key['name']))
//            {
//                $this->upload->initialize($config);
//                if (!$this->upload->do_upload($key))
//                {
//                    $errors = $this->upload->display_errors();                        
//                }
//                else
//                {
//                    
//                }
//            }
//        }
        
        $msg['response']="success";
        $msg['msg']="file sending successfull";        
        echo json_encode($msg);
    }



    function get_files_post()
    {
        $this->load->model('api_model','api_model');
        
        $post_var=array("user_id");
        
        $post_data=$this->post_var($post_var);
        
        $files=$this->api_model->get_user_files($post_data['user_id']);                
        if($files->num_rows() > 0)
        { 
            $msg['response']='success';
            $msg['msg']='files found';
            
            $i=0;$j=0;$sent_uid=0;$pre_sent_uid=0;
            foreach ($files->result() as $r)
            {
                if($r->file_type == 'music')
                    $music=$r->file_name;
                
                if($r->file_type == 'image')
                    $image=$r->file_name;
                
                if($r->file_type == 'doc')
                    $doc=$r->file_name;
                
                if($r->file_type == 'video')
                    $video=$r->file_name;
                
                $message=$r->file_msg;
                $pre_sent_uid=$r->sentFiles_sent_user_idF;
            }
            
            $msg['files']['music']=$music;
            $msg['files']['image']=$image;
            $msg['files']['doc']=$doc;
            $msg['files']['video']=$video;
            $msg['files']['message']=$message;
        }
        else{
            $msg['response']='failure';
            $msg['msg']='files not found';
        }
        
        echo json_encode($msg);
    }


    function get_files_get()
    {
        $this->load->model('api_model','api_model');
        
        $post_var=array("user_id");
        
        $post_data=$this->post_var($post_var);
        
        $post_data['user_id']=47;
        
        $files=$this->api_model->get_user_files($post_data['user_id']);                
        if($files->num_rows() > 0)
        { 
            $msg['response']='success';
            $msg['msg']='files found';
            
            echo '<pre>';
            print_r($files->result());
            
            $i=0;$j=0;$sent_uid=0;$pre_sent_uid=0;
            foreach ($files->result() as $r)
            {
//                if($r->file_type == 'music')
//                    $music=$r->file_name;
//                
//                if($r->file_type == 'image')
//                    $image=$r->file_name;
//                
//                if($r->file_type == 'doc')
//                    $doc=$r->file_name;
//                
//                if($r->file_type == 'video')
//                    $video=$r->file_name;
//                
//                $message=$r->file_msg;
//                $pre_sent_uid=$r->sentFiles_sent_user_idF;
                
                $msg['files'][$i]['userid']=$r->user_id;
                $msg['files'][$i]['username']=$r->user_name;
                $msg['files'][$i]['fileid']=$r->file_id;
                $msg['files'][$i]['filedata']=$r->file_name;
                $msg['files'][$i]['filetype']=$r->file_type;
                $msg['files'][$i]['filemsg']=$r->file_msg;
                
                $i++;
            }
            
//            $msg['files']['music']=$music;
//            $msg['files']['image']=$image;
//            $msg['files']['doc']=$doc;
//            $msg['files']['video']=$video;
//            $msg['files']['message']=$message;
        }
        else{
            $msg['response']='failure';
            $msg['msg']='files not found';
        }
        
        echo json_encode($msg);
    }
    
    
    function change_file_status_get(){
        $this->load->model('api_model','api_model');
        
        $post_var=array("json_string");
        
        $post_data=$this->post_var($post_var);
        
        $post_data['json_string']='[{
            "userid": "47",
            "sent_userid": "46",
            "fileid": "284"            
        },
        {
            "userid": "47",
            "sent_userid": "46",                   
            "fileid": "285"            
        }]';
        
        $files=json_decode($post_data['json_string']);        
        
        if(is_array($files) && count($files) > 0){
            foreach ($files as $r){
                $data['sentFiles_status']=1;
                $this->api_model->update_file_status($r->userid,$r->sent_userid,$r->fileid,$data);
            }
        }
        
        $msg['response']="success";
        $msg['msg']="status changed";
        
        echo json_encode($msg);
    }

    
    function change_file_status_post(){
        $this->load->model('api_model','api_model');
        
        $post_var=array("json_string");
        
        $post_data=$this->post_var($post_var);
        
//        $post_data['json_string']='[{
//            "userid": "46",            
//            "fileid": "284"            
//        },
//        {
//            "userid": "46",            
//            "fileid": "285"            
//        }]';
        
        $files=json_decode($post_data['json_string']);        
        
        if(is_array($files) && count($files) > 0){
            foreach ($files as $r){
                $data['sentFiles_status']=1;
                $this->api_model->update_file_status($r->userid,$r->fileid,$data);
            }
        }
        
        $msg['response']="success";
        $msg['msg']="status changed";
        
        echo json_encode($msg);
    }
}
