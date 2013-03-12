<?php
class Country_data extends Controller {

    function Country_data()
    {
        define("MAX_IMGS", "5");
        parent::Controller();
        $this->freakauth_light->check('admin');
        $this->_container = $this->config->item('FAL_template_dir') . 'template_admin/container';
        //loads necessary libraries and models
        $this->lang->load('freakauth');
        $this->load->model('countrymodel', 'countrymodel');
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
         $this->load->library('pagination');
        $config['base_url'] = base_url() . $this->config->item('index_page') . '/' . 'admin/catagory';
        $config['uri_segment'] = 3;
        $config['per_page'] = '10';
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['next_link'] = '&gt';
        $config['prev_link'] = '&lt';

        if ($this->input->post('cat_id')) {
            $where = $this->input->post('cat_id');
        } else {
            $where = '';
        }
        $fields = 'cat_id';
        $query = $this->countrymodel->getcountry($fields);

        $config['total_rows'] = $query->num_rows();
        //print_r($config['total_rows']);
        $this->pagination->initialize($config);
        $query->free_result();

        $page = $this->uri->segment(3, 0);

        $fields = '*';

        $limit = array('start' => $config['per_page'],
            'end' => $page
        );


        $query = $this->countrymodel->getcountry($fields, $limit, $where);
        //print_r ($query);

        if ($query->num_rows() > 0) {
            $i = 1;
            foreach ($query->result() as $row) {
                $data['reg'][$i]['show_edit_link'] = TRUE;
                $data['reg'][$i]['show_delete_link'] = TRUE;
                $data['reg'][$i]['cat_id'] = $row->cat_id;
                $data['reg'][$i]['country'] = $row->country;
                $i++;
            }

            $query->free_result();
        } else {
            $data['message'] = 'No country in the database.';
        }

        $data['heading'] = 'country Management';
        $data['action'] = 'country Management';
        $data['controller'] = 'country_data';
        $data['pagination_links'] = $this->pagination->create_links();
        $data['page'] = $this->config->item('FAL_template_dir') . 'template_admin/country_data/list';

        $this->load->vars($data);
        $this->load->view($this->_container);
    }

    function _get_form_values() {
        if (isset($_POST['cat_id'])) {
            //for edit record
            $values['cat_id'] = $_POST['cat_id'];
            //	$values['reg']['modifieddate'] = date('Y-m-d');
        } else {
            //$values['reg']['date'] = date('Y-m-d');
        }

        $values['reg']['country'] = $this->input->post('country');
        //let's treat our banned yes/no checkbox

        return $values;
    }

     function add() {
        $this->freakauth_light->check('admin');
        //sets the necessary form fields
        $fields['country'] = 'country';
        //additionalFields($fields);
        //set validation rules
        $rules['country'] = 'trim|required|xss_clean';
        $this->fal_validation->set_rules($rules);
        $this->fal_validation->set_fields($fields);
        //if validation unsuccesfull & data not ok
        if ($this->fal_validation->run() == FALSE) {
            $data['heading'] = 'country Management';
            $data['action'] = 'Add country';
            $data['controller'] = 'country_data';
            $data['page'] = $this->config->item('FAL_template_dir') . 'template_admin/country_data/add';
            $this->load->vars($data);
            $this->load->view($this->_container);
        }
        //if everything ok
        else {
            $values = $this->_get_form_values();
            $this->countrymodel->insertcountry($values['reg']);
            $msg = $this->db->affected_rows() . ' country added successfully!';

            flashMsg($msg);
            //redirect to list
            redirect('admin/country', 'location');
        }
    }

    function del($id = '') {
        // security check:
        // admins or superadmins cannot be deleted in the users controller
        $this->countrymodel->deletecat($id);
        $msg = $this->db->affected_rows() . ' country deleted successfully!';
        flashMsg($msg);
        $this->countrymodel->deletetipsBycatId($id);
        //set a flash message
       
        redirect('admin/country_data', 'location');
    }

    function edit($cat_id=NULL) {
        //id field needed for validation
        $fields['country'] = 'country';
        //set validation rules
        $rules['country'] = 'trim|required|xss_clean';
        $this->fal_validation->set_rules($rules);
        $this->fal_validation->set_fields($fields);
        //this avoid 1 extra query if validation doesn't return true
        if ($cat_id != '') {
            //gets values for the edit form
           
             $query = $this->countrymodel->getcountrybyid($cat_id);
            foreach ($query->result() as $row) {
                $data['reg']['cat_id'] = $row->cat_id;
                $data['reg']['country'] = $row->country;
            }
            $query->free_result();
            

         
        }
        if ($this->fal_validation->run() == FALSE) {

            $data['heading'] = 'Catagory Management';
            $data['action'] = 'Edit catagory';
            $data['controller'] = 'country_data';
            $data ['page'] = $this->config->item('FAL_template_dir') . 'template_admin/country_data/edit';
            $msg = 'Update failed';
            flashMsg($msg);
            $this->load->vars($data);
            $this->load->view($this->_container);
        }
        //if everything ok
        else {
            $values = $this->_get_form_values();
            
            $frame_id = $values['cat_id'];
            //update data in DB
            $where = array('cat_id' => $frame_id);
            //print_r($values['reg']);
            $this->countrymodel->updatecountry($where, $values['reg']);

            //rows changed in user table
            $page_affected = $this->db->affected_rows();
            //set a flash message
            $msg = $page_affected . ' country edited successfully!';
            flashMsg($msg);
            //redirect to list
            redirect('admin/country_data', 'location');
        }
        //$this->output->enable_profiler(true);
    }

    function show() {
        $id = $this->uri->segment(4);
        $query = $this->framesmodel->getframeById($id);
        if ($query->num_rows() == 1) {
            $row = $query->row();

            // initializing two flags, for the edit and delete links
            // we can edit the displayed user if
            //  - we are an admin
            //  - OR the displayed user is not a superadmin
            $data['reg']['frame_id'] = $row->frame_id;
            $data['reg']['model_number'] = $row->model_number;
            $data['reg']['temple_length'] = $row->temple_length;
            $data['reg']['bridge'] = $row->bridge;
            $data['reg']['frame_width'] = $row->frame_width;
            $data['reg']['frame_weight'] = $row->frame_weight;

            //$data['frames']['modifiedDate']= $row->modifiedDate;

            if (isset($query))
                $query->free_result();
            $query = $this->framesmodel->getImagesByFrameID($data['reg']['frame_id']);
            if ($query) {
                //$data['img']['CUR_IMGS']=$query->num_rows();
                $row = $query->result();
                for ($i = 0; $i < $query->num_rows(); $i++) {
                    $data['img'][$i]['frame_image_id'] = $row[$i]->frame_image_id;
                    $data['img'][$i]['image'] = $row[$i]->image;
                    $data['img'][$i]['image_thumb'] = $row[$i]->image_thumb;
                    $data['img'][$i]['published'] = $row[$i]->published;
                }
            } else {
                //$data['img']['CUR_IMGS']=0;
            }
        } else {
            $data['error_message'] = 'The record you are looking for does not exist';
        }
        $data['heading'] = 'Manage framess';
        $data['action'] = 'View frames Details';
        $data['controller'] = 'frames';
        $data['page'] = $this->config->item('FAL_template_dir') . 'template_admin/frames/show';

        $this->load->vars($data);
        $this->load->view($this->_container);
        // for debugging
    }


}

