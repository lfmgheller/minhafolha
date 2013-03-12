<?php
class Home extends Controller {

    function Home() {
        parent::Controller();

        $this->_container = $this->config->item('FAL_template_dir') . 'template/container';

        $this->load->library('FAL_front', 'fal_front');
        
        $this->load->model('home_model','home_model');
    }

    function index() {
//       if(!$this->freakauth_light->isValidUser())
//        {
//            $data['fal_login'] = $this->fal_front->login();
//	    $data['host']="";
//        }
//        else
//        {
//            $data['fal_login']="";
//            $data['name'] =$this->db_session->userdata('user_name');
//            $ip=$_SERVER['REMOTE_ADDR'];
//           // echo "<b>IP Address= $ip</b>";
//	    $fullhost = gethostbyaddr($ip);
//	    $data['host']=$fullhost;
//            $data['ip'] = $ip;
//            $data['heading'] = 'HOME';
//            //redirect('profile', 'location');
//        }
        
        $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/home';
        $this->load->vars($data);
        $this->load->view($this->_container);
        
//        if(isset($this->db_session->userdata['userEmail']) && $this->db_session->userdata['userEmail'] != ''){
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/login_success';
//            $this->load->vars($data);
//            $this->load->view($this->_container); 
//        }
//        else{        
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/register';
//            $this->load->vars($data);
//            $this->load->view($this->_container);
//        }
    }
    
    
    function register()
    {
//        $data['Country'] = $this->auth_model->getcountries()->result();
        $data['heading']='Register';
        $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/register';
        $this->load->vars($data);
        $this->load->view($this->_container);
    }
    
    
    
//    function register(){
//        if(isset($_POST['reg_name']) && $_POST['reg_name'])
//            $data['name']=$_POST['reg_name'];
//        
//        if(isset($_POST['reg_email']) && $_POST['reg_email'])
//            $data['email']=$_POST['reg_email'];
//        
//        if(isset($_POST['reg_pwd']) && $_POST['reg_pwd'])
//            $data['password_hash']=md5($_POST['reg_pwd']);
//        
//        if(isset($_POST['reg_cpwd']) && $_POST['reg_cpwd'])
//            $cpwd=md5($_POST['reg_cpwd']);
//        
//        $data['confirmation_sent_at']= date('Y-m-d H:i:s',  time());
//        
//        $data['confirmation_token']=substr(md5(uniqid(rand(), true)), 25);
//        
//        if($data['password_hash'] == $cpwd)
//        {
//            
//            $email=$this->home_model->checkEmail($data['email']);
//            if($email->num_rows() > 0)
//            {
//                $data['msg']='Email is alreay taken.';
//                
//                $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/register';
//                $this->load->vars($data);
//                $this->load->view($this->_container);
//            }
//            else{
//            
//                $this->home_model->registerUser($data);
//
//                $uid=  $this->db->insert_id();
//
//                $this->db_session->set_userdata('uid',$uid);
//
//                $to=$data['email'];
//                $subject='Register Confirmation';
//                $message='Use below token to confirm your registration.'.$data['confirmation_token'];
//                mail($to,$subject , $message);
//                
//                $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/confirmation';
//                $this->load->vars($data);
//                $this->load->view($this->_container);
//            }
//        }
//        else{
//            $data['msg']='Password and Confirm Password field did not match.';
//                
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/register';
//            $this->load->vars($data);
//            $this->load->view($this->_container);
//        }
//        
//        
//    }
    
    
//    function confirmtoken(){
//        if(isset($_POST['conf_token']) && $_POST['conf_token'] != '')
//            $token=$_POST['conf_token'];
//        
//        $token=$this->home_model->checkToken($token,  $this->db_session->userdata['uid']);
//        if($token->num_rows() > 0)
//        {
//            $data['confirmed_at']=date('Y-m-d H:i:s',  time());;            
//            
//            $fieldname='id';
//            $this->home_model->updateUsersEntry($data,$this->db_session->userdata['uid'],$fieldname);
//            
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/confirmation_success';
//            $this->load->vars($data);
//            $this->load->view($this->_container);
//        }
//        else{
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/confirmation_fail';
//            $this->load->vars($data);
//            $this->load->view($this->_container);
//        }        
//    }
    
//    function login()
//    {
//        if(isset($_POST['login_email']) && $_POST['login_email'] != '')
//            $email=$_POST['login_email'];
//        
//        if(isset($_POST['login_pwd']) && $_POST['login_pwd'] != '')
//            $pwd=md5($_POST['login_pwd']);
//        
//        $user=$this->home_model->login($email,$pwd);
//        
//        if($user->num_rows() > 0)
//        {            
//            $this->db_session->set_userdata('userEmail',$email);            
//            
//            $data['msg']='Login Successfull';    
//            
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/login_success';
//            $this->load->vars($data);
//            $this->load->view($this->_container);
//        }
//        else{
//            $data['msg']='Login failed';
////            redirect('home');
//            $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/register';
//            $this->load->vars($data);
//            $this->load->view($this->_container);
//        }
//        
//        
//    }
//    
//    function reset_password()
//    {
//        if(isset($this->db_session->userdata['userEmail']) && $this->db_session->userdata['userEmail'] != '')
//        {
//            $uemail=  $this->db_session->userdata['userEmail'];
//            
//            if (isset($_POST['pwdr_opwd']) && $_POST['pwdr_opwd'] != '')
//                $opwd=md5($_POST['pwdr_opwd']);
//
//            if (isset($_POST['pwdr_npwd']) && $_POST['pwdr_npwd'] != '')
//                $npwd=md5($_POST['pwdr_npwd']);
//
//            if (isset($_POST['pwdr_cpwd']) && $_POST['pwdr_cpwd'] != '')
//                $cpwd=md5($_POST['pwdr_cpwd']);
//
//            $pwd=$this->home_model->checkOldPassword($uemail,$opwd);
//            
//            if($pwd->num_rows() > 0)
//            {
//                $data['password_hash']=$npwd;
//                
//                $fieldname='email';
//                
//                $this->home_model->updateUsersEntry($data,  $uemail,$fieldname);
//                
//                $data['msg']='Password has been changed successfully';                
//                
//            }
//            else{
//                $data['msg']='You have entered wrong old password.';
//            }
//        }       
//        
//        $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/login_success';
//        $this->load->vars($data);
//        $this->load->view($this->_container); 
//    }
    
//    function logout(){
//        $this->db_session->unset_userdata('userEmail');
//        
//        redirect('home');
//    }
    
}
?>
