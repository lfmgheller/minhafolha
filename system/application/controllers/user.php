<?php

class user extends Controller
{
    function user()
    {
        parent::Controller();
        
        if(!isset ($this->db_session->userdata['userEmail']) || $this->db_session->userdata['userEmail'] == '')
            redirect ('home');        
        
//        $this->load->model('user_model','user_model');
        $this->_container = $this->config->item('FAL_template_dir').'template/container';
        $this->load->library('FAL_front', 'fal_front');
        global $userid;
        $userid=  $this->db_session->userdata['userID'];
        
        $this->load->model('home_model','home_model');
    }
    
    function index()
    {
        $data['heading']='User Area';
        $data['page'] = $this->config->item('FAL_template_dir') . 'template/user/home';
        $this->load->vars($data);
        $this->load->view($this->_container);
    }
    
    
    function reset_password()
    {
//        if(isset($this->db_session->userdata['userEmail']) && $this->db_session->userdata['userEmail'] != '')
//        {
            $uemail=  $this->db_session->userdata['userEmail'];
            
            if (isset($_POST['pwdr_opwd']) && $_POST['pwdr_opwd'] != '')
                $opwd=$this->freakauth_light->_encode($_POST['pwdr_opwd']);

            if (isset($_POST['pwdr_npwd']) && $_POST['pwdr_npwd'] != '')
                $npwd=$this->freakauth_light->_encode($_POST['pwdr_npwd']);

            if (isset($_POST['pwdr_cpwd']) && $_POST['pwdr_cpwd'] != '')
                $cpwd=$this->freakauth_light->_encode($_POST['pwdr_cpwd']);

            $pwd=$this->home_model->checkOldPassword($uemail,$opwd);
            
            if($pwd->num_rows() > 0)
            {
                $data['password_hash']=$npwd;
                
                $fieldname='email';
                
                $this->home_model->updateUsersEntry($data,  $uemail,$fieldname);                
                
                $this->db_session->set_userdata('sessionMsg','Password has been changed successfully');
                
            }
            else{                
                $this->db_session->set_userdata('sessionMsg','You have entered wrong old password.');
            
            }
//        }       
        redirect('user');
//        $data['page'] = $this->config->item('FAL_template_dir') . 'template/home/login_success';
//        $this->load->vars($data);
//        $this->load->view($this->_container); 
    }
}
?>
