<?php

class users extends Controller
{
    function users()
    {
        parent::Controller();        
        
        $this->freakauth_light->check('user');                
        
        $this->_container = $this->config->item('FAL_template_dir').'template/container';
    }
    
    function index()
    {
        
    }
}

?>
