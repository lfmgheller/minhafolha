<?php
class Movie extends Controller {

    function Movie()
    {
        define("MAX_IMGS", "5");
        parent::Controller();
        $this->freakauth_light->check('admin');
        $this->_container = $this->config->item('FAL_template_dir') . 'template_admin/container';
        //loads necessary libraries and models
        $this->lang->load('freakauth');
        $this->load->model('moviemodel', 'moviemodel');
        //lets load the validation class if it hasn't been already loaded
        //it is needed by the FAL_validation library
        if (!class_exists('CI_Validation')) {
            $this->load->library('validation');
        }
        $this->load->library('FAL_validation', 'fal_validation');
        $this->fal_validation->set_error_delimiters($this->config->item('FAL_error_delimiter_open'), $this->config->item('FAL_error_delimiter_close'));

        //sets the necessary form fields

        //additionalFields($fields);


    }

    function index()
    {
        


        $query = $this->moviemodel->getmovies();
        //print_r ($query);

     
            $i = 1;
            foreach ($query->result() as $row) {
                $data['reg'][$i]['show_edit_link'] = TRUE;
                $data['reg'][$i]['show_delete_link'] = TRUE;
                $data['reg'][$i]['movie_id'] = $row->movie_id;
                $data['reg'][$i]['movie_name'] = $row->movie_name;
                $data['reg'][$i]['movie_date'] = $row->movie_date;
                $data['reg'][$i]['movie_director'] = $row->movie_director;
                $data['reg'][$i]['movie_stars'] = $row->movie_stars;
                $i++;
            }                          
               
        

         

        $data['heading'] = 'movie Management';
        $data['action'] = 'movie Management';
        $data['controller'] = 'movie';
      
       $data['page'] = $this->config->item('FAL_template_dir') . 'template_admin/movie/list';

        $this->load->vars($data);
        $this->load->view($this->_container);
    }

    function add() {
        $this->freakauth_light->check('admin');
                
            if(isset($_POST['Submit']))
            {
             $values = $this->_get_form_values();
             $movie_id = $this->moviemodel->insertmovie($values['reg']);
             $count = 1;
             $movie_array = $this->input->post('movie_country');

                foreach ($movie_array as $country_id) {
                $bestdata['data']['movie_id'] = $movie_id;
                $bestdata['data']['country_id']=$country_id;
                $query = $this->moviemodel->insertmovie_country($bestdata['data']);
                $count++;
            }

             
               redirect('admin/movie', 'location');
        }
        else
        {
            $data['heading'] = 'Movie Management';
            $data['action'] = 'Add Movie';
            $data['controller'] = 'movie';
            $data['page'] = $this->config->item('FAL_template_dir') . 'template_admin/movie/add';
            $this->load->vars($data);
            $this->load->view($this->_container);
        }
    }
    
    function _get_form_values() {
     
         $values['reg']['movie_name'] = $this->input->post('movie_name');
         $values['reg']['movie_date'] = $this->input->post('movie_date');
         $values['reg']['movie_director'] = $this->input->post('movie_director');
         $values['reg']['movie_stars'] = $this->input->post('movie_starts');
         $values['reg']['movie_rated'] = $this->input->post('movie_rated');
         $values['reg']['movie_studio'] = $this->input->post('movie_studio');
         $values['reg']['movie_synopsis'] = $this->input->post('movie_synopsis');
         $values['reg']['movie_geners'] = $this->input->post('movie_geners');        
        return $values;
    }

    function del($tips_id = '') {
        $query = $this->moviemodel->gettipslinksById($tips_id);
        $dat=$query[0]['file_name'];
        unlink($dat);
        // security check:
        // admins or superadmins cannot be deleted in the users controller
        $this->moviemodel->deletetips($tips_id);
       $msg = $this->db->affected_rows() . ' movie deleted successfully!';
        flashMsg($msg);
        $this->moviemodel->deletetips_link($tips_id);
       
       
        //unlink($data['reg']['file_name']);
        //set a flash message
        
        $this->load->view($this->config->item('FAL_template_dir').'template_admin/del');
       redirect('admin/movie', 'location');
    }

    function show() {
        $id = $this->uri->segment(4);
        $query = $this->moviemodel->gettipsById($id);
        if ($query->num_rows() == 1) {
            $row = $query->row();

            // initializing two flags, for the edit and delete links
            // we can edit the displayed user if
            //  - we are an admin
            //  - OR the displayed user is not a superadmin
            $data['reg']['tips_id'] = $row->id;
            $data['reg']['tips_title'] = $row->tips_title;
            $data['reg']['tips_dec'] = $row->tips_dec;            

            //$data['frames']['modifiedDate']= $row->modifiedDate;           
                $query->free_result();
            
        } else {
            $data['error_message'] = 'The record you are looking for does not exist';
        }
        $data['heading'] = 'Manage Tips';
        $data['action'] = 'View Tips Details';
        $data['controller'] = 'movie';
        $data['page'] = $this->config->item('FAL_template_dir') . 'template_admin/movie/show';

        $this->load->vars($data);
        $this->load->view($this->_container);
        // for debugging
    }

    function edit($tips_id=NULL) {
        //id field needed for validation
       
        //set validation rules
        $fields['tips_title'] = 'tips_title';
        $fields['tips_dec'] = 'tips_dec';
        //additionalFields($fields);
        //set validation rules
        $rules['tips_title'] = 'trim|required|xss_clean';
        $rules['tips_dec'] = 'trim|required|xss_clean';
        $this->fal_validation->set_rules($rules);
        $this->fal_validation->set_fields($fields);
        //this avoid 1 extra query if validation doesn't return true
        $id = $this->uri->segment(4);
            //gets values for the edit form            
             $query = $this->moviemodel->gettipsById($id);
            foreach ($query->result() as $row) {
                 $data['reg']['tips_id'] = $row->id;
                 $data['reg']['tips_title'] = $row->tips_title;
                 $data['reg']['tips_dec'] = $row->tips_dec;
            }
            $query->free_result();
         
    
        if ($this->fal_validation->run() == FALSE) {

            $data['heading'] = 'movie Management';
            $data['action'] = 'Edit Tips';
            $data['controller'] = 'movie';
            $data ['page'] = $this->config->item('FAL_template_dir') . 'template_admin/movie/edit';
            $msg = 'Update failed';
            flashMsg($msg);
            $this->load->vars($data);
            $this->load->view($this->_container);
        }
        //if everything ok
        else {
           
            $id = $this->input->post('tips_id');
               
            echo $id;
            $values['reg']['tips_title'] = $this->input->post('tips_title');
            $values['reg']['tips_dec'] = $this->input->post('tips_dec');
            $this->moviemodel->updatetips($id,$values['reg']);

            //rows changed in user table
            $page_affected = $this->db->affected_rows();
            //set a flash message
            $msg = $page_affected . ' movie edited successfully!';
            flashMsg($msg);
            //redirect to list
            redirect('admin/movie', 'location');
        }
        $this->output->enable_profiler(true);
    }

}
?>
