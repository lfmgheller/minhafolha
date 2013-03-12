<?php

class authentication extends Controller
{
    function authentication()
    {
        parent::Controller();
        
        $this->_container = $this->config->item('FAL_template_dir').'template/container';
        $this->load->library('FAL_front', 'fal_front');
        $this->load->model('auth_model','auth_model');
        
        $this->load->model('home_model','home_model');
    }

    function index()
    {
        $this->login();
    }

    function generate_token()
    {
        $random=substr(md5(uniqid(rand(), true)), 25);

        $first_result=md5($random);

        $merge_result=$first_result.time();

        $final_result=sha1(sha1($merge_result));

//        echo $final_result.'<br/>';
//        echo mcrypt_encrypt(MCRYPT_RIJNDAEL_128,'date me now',$final_result,MCRYPT_MODE_ECB);
        return $final_result;
    }


    function login()
    {
        $username=$_POST['login_email'];
        $password=  $this->freakauth_light->_encode($_POST['login_pwd']);

        $user=$this->auth_model->authentication($username,$password);
        if($user->num_rows() > 0)
        {
            $arr=$user->result();
            $arr=(array)$arr[0];

            $userid=$arr['id'];
//            $paid=$arr['paid'];
//            $membershiptime=$arr['membershiptime'];
            $session_arr=array("userEmail" => $username,"userID" => $userid);
            $this->db_session->set_userdata($session_arr);

            $this->db_session->set_userdata('sessionMsg','You are successfully logged in.');
            redirect('user');
        }
        else
        {
            $this->db_session->set_userdata('sessionMsg','You entered wrong Email OR password.');
            redirect('home');
        }
    }

    function logout()
    {
        $session_arr=array("userEmail" => "","userID" => "");
        $this->db_session->unset_userdata($session_arr);
        $this->db_session->set_userdata('sessionMsg','You are successfully Logged out.');
        redirect('home');
    }

    
    
    
    
    function register(){
        if(isset($_POST['reg_name']) && $_POST['reg_name'])
            $data['name']=$_POST['reg_name'];
        
        if(isset($_POST['reg_email']) && $_POST['reg_email'])
            $data['email']=$_POST['reg_email'];
        
        if(isset($_POST['reg_pwd']) && $_POST['reg_pwd'])
            $data['password_hash']=$this->freakauth_light->_encode($_POST['reg_pwd']);
        
        if(isset($_POST['reg_cpwd']) && $_POST['reg_cpwd'])
            $cpwd=$this->freakauth_light->_encode($_POST['reg_cpwd']);
        
        $data['confirmation_sent_at']= date('Y-m-d H:i:s',  time());
        
        $data['confirmation_token']=substr(md5(uniqid(rand(), true)), 25);
        
        if($data['password_hash'] == $cpwd)
        {
            
            $email=$this->home_model->checkEmail($data['email']);
            if($email->num_rows() > 0)
            {
//                $data['msg']='Email is alreay taken.';
                
                $this->db_session->set_userdata('sessionMsg','Email is alreay taken.');
            
                redirect('home/register');

            }
            else{
            
                $this->home_model->registerUser($data);

                $uid=  $this->db->insert_id();

                $this->db_session->set_userdata('uid',$uid);

                $to=$data['email'];
                $subject='Register Confirmation';
                $message='Use below token to confirm your registration.'.$data['confirmation_token'].'  ';
                $message.='You can also use below link to confirm your registration. ' .base_url().'index.php/authentication/confirmationPage/'.urlencode($uid);
                mail($to,$subject , $message);
                
                $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/confirmation';
                $this->load->vars($data);
                $this->load->view($this->_container);
            }
        }
        else{            
            $this->db_session->set_userdata('sessionMsg','Password and Confirm Password field did not match.');
            
            redirect('home/register');
        }
    }
    
    
    function confirmationPage($uid = NULL)
    {
        $this->db_session->set_userdata('uid',$uid);
        
        $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/confirmation';
        $this->load->vars($data);
        $this->load->view($this->_container);
    }
    
    
    
    function confirmtoken(){
        if(isset($_POST['conf_token']) && $_POST['conf_token'] != '')
            $token=$_POST['conf_token'];
        
        if(isset($this->db_session->userdata['uid']) && $this->db_session->userdata['uid'] != '')
            $uid=$this->db_session->userdata['uid'];
        
        $token=$this->home_model->checkToken($token,  $uid);
        if($token->num_rows() > 0)
        {
            $data['confirmed_at']=date('Y-m-d H:i:s',  time());;            
            
            $fieldname='id';
            $this->home_model->updateUsersEntry($data,$uid,$fieldname);            
            
            $this->db_session->set_userdata('sessionMsg','We received your confirmation. Your registration process completed successfully.');
            redirect('home');

        }
        else{
            
            $this->db_session->set_userdata('sessionMsg','Sorry, Confirmation token is wrong.');
            
            redirect('home/register');

        }
    }
    
    
    
}

?>
