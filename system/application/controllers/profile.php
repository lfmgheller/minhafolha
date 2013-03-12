<?php
class Profile extends Controller {

    function Profile() {
        parent::Controller();
        $this->freakauth_light->check('user');
        $this->_container = $this->config->item('FAL_template_dir') . 'template/container';
       
        $this->load->library('FAL_front', 'fal_front');
    }

    function index() {
        $data['heading'] = 'Profile';
        $data['page'] = $this->config->item('FAL_template_dir') . 'template/profile/profile';
        $this->load->vars($data);
        $this->load->view($this->_container);
    }
    }
?>
