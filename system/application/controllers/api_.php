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

    function post_var($post_var){
        foreach ($post_var as $val){
            if(isset($_POST[$val]))
                $post_data[$val]=$_POST[$val];
        }
        
        return $post_data;
    }
    
    function get_var($post_var){
        foreach ($post_var as $val){
            if(isset($_GET[$val]))
                $post_data[$val]=$_GET[$val];
        }
        
        return $post_data;
    }



    // LOGIN AUTHENTICATION
    function login_post()
    {
        $this->load->model('api_model','api_model');
        $post_var=array("user_name","password");
        
        $post_data=$this->post_var($post_var);

        $uname=$post_data['user_name'];
        $pwd=md5($post_data['password']);
        $login=$this->api_model->check_authentication($uname,$pwd);

        if($login->num_rows() > 0)
        {       
            $msg['response']='success';
            $msg['msg']='Login successfull';
            
            foreach ($login->result() as $r)
            {
                $user_id=$r->user_id;
            }
            $msg['user_id']=$user_id;
            
            $files=$this->api_model->get_user_files_num($user_id);
            if($files->num_rows() > 0)            
                $msg['flag']="true";            
            else
                $msg['flag']="false";
        }
         else {
             $msg['response']="failure";
             $msg['msg']="Login Failure";
        }

        echo json_encode($msg);
    }

    function login_get()
    {
        $this->load->model('api_model','api_model');
        $post_var=array("user_name","password");
        
        $post_data=$this->post_var($post_var);

        $post_data['user_name']='saurabh';
        $post_data['password']='123456';
        
        $uname=$post_data['user_name'];
        $pwd=md5($post_data['password']);
        $login=$this->api_model->check_authentication($uname,$pwd);

        if($login->num_rows() > 0)
        {       
            $msg['response']='success';
            $msg['msg']='Login successfull';
            
            foreach ($login->result() as $r)
            {
                $user_id=$r->user_id;
            }
            $msg['user_id']=$user_id;
        }
         else {
             $msg['response']="failure";
             $msg['msg']="Login Failure";
        }

        echo json_encode($msg);
    }

    
    
    function register_get()
    {
        $this->load->model('api_model','api_model');

        $post_var=array("user_name","password","name","image","latitude","longitude","device_id","status");
        
        $post_data=$this->get_var($post_var);
        
        $post_data['user_name']="saurabh";
        $post_data['password']="123456";
        $post_data['name']="saurabh";
        $post_data['latitude']="12.56585";
        $post_data['longitude']="83.455";

        $uname=$this->api_model->check_user_name($post_data['user_name']);
        if($uname->num_rows() > 0)
        {
            $msg['response']="failure";
            $msg['msg']="Username is already taken";
        }
        else
        {
            $post_data['password']=md5($post_data['password']);
            $this->api_model->register_user($post_data);
            
            $msg['response']="success";
            $msg['msg']="Registration successful.";
        }
        
        echo json_encode($msg);
    }


    // REGISTER NEW USER
    function register_post()
    {
        $this->load->model('api_model','api_model');

        $post_var=array("user_name","password","name","image","latitude","longitude","device_id","status");
        
        $post_data=$this->post_var($post_var);   

        $uname=$this->api_model->check_user_name($post_data['user_name']);
        if($uname->num_rows() > 0)
        {
            $msg['response']="failure";
            $msg['msg']="Username is already taken";
        }
        else
        {
            $post_data['password']=md5($post_data['password']);            
            $this->api_model->register_user($post_data);
            
//            $uid=$this->db->insert_id();
            
//            $dir="uploads/users/".$uid;
//            if(!is_dir($dir))
//                mkdir ($dir,0777);
//            
//            
//            $config['upload_path'] = $dir."/";
//            $path=$config['upload_path'];
//            $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPG|JPEG';
//            $config['max_size'] = '1024';
//            $config['max_width'] = '1920';
//            $config['max_height'] = '1280';
//            $this->load->library('upload');
//
//            foreach ($_FILES as $key => $value)
//            {
//                if (!empty($key['name']))
//                {
//                    $this->upload->initialize($config);
//                    if (!$this->upload->do_upload($key))
//                    {
//                        $errors = $this->upload->display_errors();                        
//                    }
//                    else
//                    {
//                         $data['image']=$_FILES['image']['name'];
//                         $this->api_model->update_user($data,$uid);
//                    }
//                }
//            }            
            
            $msg['response']="success";
            $msg['msg']="Registration successful.";
        }
        
        echo json_encode($msg);
    }

   
    
    function send_files_post(){
        $file_ids=array();
        
        $this->load->model('api_model','api_model');
        
        $post_var=array("user_id","music","video","image","doc","msg","miles");
        
        $post_data=$this->post_var($post_var);
        
        $uid=$post_data['user_id'];
        
        $data['file_user_idF']=$uid;
        $data['file_msg']=$post_data['msg'];
        
        $data['file_name']=$post_data['music'];
        $data['file_type']="music";
                
        $this->api_model->add_files($data);
        $file_ids[]=  $this->db->insert_id();
        
        $data['file_name']=$post_data['video'];
        $data['file_type']="video";
                
        $this->api_model->add_files($data);
        $file_ids[]=  $this->db->insert_id();
        
        $data['file_name']=$post_data['image'];
        $data['file_type']="image";
                
        $this->api_model->add_files($data);
        $file_ids[]=  $this->db->insert_id();
        
        $data['file_name']=$post_data['doc'];
        $data['file_type']="doc";
                
        $this->api_model->add_files($data);  
        $file_ids[]=  $this->db->insert_id();
        
        
        $user=$this->api_model->get_user_details($uid);
        if($user->num_rows() > 0)
        {
            foreach ($user->result() as $r)
            {
                $latitude=$r->latitude;
                $longitude=$r->longitude;
            }
        }        
        
        $user_data['miles']=$post_data['miles'];
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

    
    function get_files_post()
    {
        $this->load->model('api_model','api_model');
        
        $post_var=array("user_id");
        
        $post_data=$this->post_var($post_var);        
     
//        $post_data['user_id']=2;
        
        $files=$this->api_model->get_user_files($post_data['user_id']);                
        if($files->num_rows() > 0)
        { 
            $msg['response']='success';
            $msg['msg']='files found';            
//            echo '<pre>';
//            print_r($files->result());
            
            $i=0;$j=0;$sent_uid=0;$pre_sent_uid=0;
            foreach ($files->result() as $r)
            {
//                if($pre_sent_uid != $r->sentFiles_sent_user_idF){
//                    $sent_uid=$r->sentFiles_sent_user_idF;
//                    
//                    $msg['user_data'][$j]['files'][$i][$r->file_type]=$r->file_name;
//                    $msg['user_data'][$j]['files'][$i]['msg']=$r->file_msg;
//                    $j++;
//                }
//                else{
//                    $msg['user_data'][$j]['files'][$i][$r->file_type]=$r->file_name;
//                    $msg['user_data'][$j]['files'][$i]['msg']=$r->file_msg;
//                }
                                
//                $msg['files'][$i][$r->file_type]=$r->file_name;
//                $msg['files'][$i]['message']=$r->file_msg;
//                $i++;
                
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


    function send_notification($meeting_name=NULL,$create_user_name=NUll,$sender_id=NULL,$flag=NULL,$meeting_type=NULL,$meeting_id=NULL)
    {
         $this->load->model("api_model");
         if($flag==2)
         {
            $message='You are invited for the Private meeting "'.$meeting_name.'" by '.$create_user_name;
         }
         if($flag==1)
         $message='You are invited for the Public meeting "'.$meeting_name.'" by '.$create_user_name;
         if($flag==3)
         $message='Your invitation of '.$meeting_type.' meeting "'.$meeting_name.'" accepted by '.$create_user_name;
         if($flag==4)
         $message='Your invitation of '.$meeting_type.' meeting "'.$meeting_name.'" declined by '.$create_user_name;
         if($flag==5)
         $message=$meeting_type.' meeting "'.$meeting_name.'" has been deleted by '.$create_user_name;
         if($flag==6)
         {
            $message='One of your meetings named "'.$meeting_name.'" has been changed. Please Check details of meeting.';
            
            $data['message']=$message;
             $data['FK_user_id']=$sender_id;
             $data['date']=date('Y-m-d');
             $data['time']=date('H:i:s',  time());
             $data['FK_meeting_id']=$meeting_id;             

             $this->api_model->insert_notifications($data);
         }
         if($flag==7)
         $message='Your invitation of '.$meeting_type.' meeting "'.$meeting_name.'" deleted by '.$create_user_name;


         

         $get_token=  $this->api_model->get_userdetails_by_userid($sender_id);
         {
             if($get_token->num_rows() > 0)
                {
                    foreach ($get_token->result() as $r)
                    {
                        $data['token']=$r->device_token;
                    }
                }
         }

         $deviceToken = $data['token'];
//         $deviceToken='7790a299e5334a7fa53c99951f1644ccc3aa2408f5f15e97d49a1f9ce9477cce';

         // get unread message count
         $get_unread_message_count=  $this->api_model->get_user_all_notaccepted_invitations($sender_id);
         {
             if($get_unread_message_count->num_rows() > 0)
                {
                    $badges=$get_unread_message_count->num_rows();
                }
                else
                {
                    $badges=0;
                }
         }

        // Put your private key's passphrase here:
        $passphrase = '123456';

        // Put your alert message here:
        //$message = 'My first push notification!';

        ////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns-dev.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
         'ssl://gateway.sandbox.push.apple.com:2195', $err,
         $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
         exit("Failed to connect: $err $errstr" . PHP_EOL);

        //echo 'Connected to APNS' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
         'alert' => $message,
         'sound' => 'default',
                'badge' => $badges
         );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;


        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        //if (!$result)
        // echo 'Message not delivered' . PHP_EOL;
        //else
        // echo 'Message successfully delivered' . PHP_EOL;

        // Close the connection to the server
        fclose($fp);

    }

}
