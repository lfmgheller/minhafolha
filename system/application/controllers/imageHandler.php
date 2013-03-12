<?php
class ImageHandler extends Controller {

    function ImageHandler() {
        parent::Controller();
        $this->freakauth_light->check('user');
        $this->_container = $this->config->item('FAL_template_dir') . 'template/container';
        $this->load->model('profile_model', 'profile_model');
        $this->load->library('FAL_front', 'fal_front');
    }

    function index() {
        echo "sdf";
    }
    }

?>
