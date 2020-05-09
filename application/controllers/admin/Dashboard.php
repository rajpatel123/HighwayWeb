<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    /* #********************************************#
      #                   codingmaker             #
      #*********************************************#
      #      Author:     codingmaker              #
      #      Email:      info@codingmaker.com     #
      #      Website:    http://codingmaker.com   #
      #                                             #
      #      Version:    1.0.0                      #
      #      Copyright:  (c) 2018 - codingmaker   #
      #                                             #
      #*********************************************# */

    public function __construct() {
      parent::__construct();
        // Check Login Status
    //  $this->user_login_authentication();
      
      if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
      $this->load->model('admin_models/dashboard_model', 'dash_mdl');	
      $this->load->model('admin_models/booktrip_model', 'booktrip_mdl');	
      $this->load->model('admin_models/customer_model', 'customer_mdl'); 
      $this->load->model('admin_models/trip_model', 'trip_mdl'); 
         
    }

    public function index() {
      $data = array();
      $data['title'] = 'Dashboard';
      $data['active_menu'] = 'dashboard';
      $data['active_sub_menu'] = '';
      $data['active_sub_sub_menu'] = '';
      $data['trip_info'] = $this->trip_mdl->get_trip_info();
      $data['total_listing'] = 1;
      $data['total_users'] = 10;
      $data['total_classified'] = 10;
      $data['total_events'] = 100;
      
      $data['total_categories'] = 200;
      $data['total_cities'] = 3000;
      $data['all_notifications']= 400;
      $data['main_content']='';
      $data['customer'] = $this->customer_mdl->newCustomerList(); 
      //echo '<pre>' ;print_r($data['customer']);die;
      
      $data['upcoming'] = $this->booktrip_mdl->count_total_upcoming_trip(); 
      $data['ongoing'] = $this->booktrip_mdl->count_total_ongoing_trip(); 
      $data['completed'] = $this->booktrip_mdl->count_total_completed_trip(); 
      $data['cancel'] = $this->booktrip_mdl->count_total_cancel_trip();
      $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
      $data['main_content'] = $this->load->view('admin_views/dashboard/dashboard_v', '', TRUE);
      $this->load->view('admin_views/admin_master_v', $data);
    }
    
    public function active_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_trip_by_trip_id($trip_id); 
        if (!empty($trip_info)) { 
            $result = $this->trip_mdl->active_trip_by_id($trip_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('dashboard', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('dashboard', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !';
            $this->session->set_userdata($sdata); 
            redirect('dashboard', 'refresh'); 
        } 
    }
 
    public function inactive_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_trip_by_trip_id($trip_id);
        if (!empty($trip_info)) {
            $result = $this->trip_mdl->inactive_trip_by_id($trip_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('dashboard', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('dashboard', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('dashboard', 'refresh'); 
        } 
    }  

    public function edit_trip($trip_id) { 
        $data = array(); 
        $data['tripData'] = $this->trip_mdl->get_trip_data_by_id($trip_id);  
       // echo '<pre>' ;print_r($data['tripData']);die;
        if (!empty($data['tripData'])) { 
            $data['title'] = 'Edit Trip'; 
            $data['active_menu'] = 'trip'; 
            $data['active_sub_menu'] = 'trip'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/dashboard/edit_trip_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('dashboard', 'refresh'); 
        } 
    } 

    public function update_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_trip_data_by_id($trip_id); 
        if (!empty($trip_info)) { 
            $config = array( 
                array(
                'field' => 't_start_latitude',
                'label' => 't_start_latitude',
                'rules' => 'trim|required|max_length[250]'
            ),
                array(
                'field' => 't_start_longitude',
                'label' => 't_start_longitude',
                'rules' => 'trim|required|max_length[250]'
            ),
                array(
                'field' => 't_end_latitude',
                'label' => 't_end_latitude',
                'rules' => 'trim|required|max_length[250]'
            ),
                array(
                'field' => 't_end_longitude',
                'label' => 't_end_longitude',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_start_date',
                'label' => 't_start_date',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_end_date',
                'label' => 't_end_date',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_start_time',
                'label' => 't_start_time',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 't_end_time',
                'label' => 't_end_time',
                'rules' => 'trim|required|max_length[250]'
            ),
            );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_trip($trip_id); 
            } else { 
                $data['t_start_latitude'] = $this->input->post('t_start_latitude', TRUE); 
                $data['t_start_longitude'] = $this->input->post('t_start_longitude', TRUE); 
                $data['t_end_latitude'] = $this->input->post('t_end_latitude', TRUE); 
                $data['t_end_longitude'] = $this->input->post('t_end_longitude', TRUE); 
                $data['t_start_date'] = $this->input->post('t_start_date', TRUE); 
                $data['t_end_date'] = $this->input->post('t_end_date', TRUE); 
                $data['t_start_time'] = $this->input->post('t_start_time', TRUE); 
                $data['t_end_time'] = $this->input->post('t_end_time', TRUE); 
               
                $result = $this->trip_mdl->update_trip($trip_id, $data); 
                // echo '<pre>' ;print_r($result);die;
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('dashboard', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('dashboard', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('dashboard', 'refresh'); 
        } 
    } 

    public function remove_trip($trip_id) { 
        $trip_info = $this->trip_mdl->get_Trip_by_trip_id($trip_id); 
        if (!empty($trip_info)) { 
            $result = $this->trip_mdl->remove_trip_by_id($trip_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('dashboard', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('dashboard', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('dashboard', 'refresh'); 
        } 
    } 
    
    
    public function view_trip($trip_id) { 
        $data = array(); 
        $data['user_data'] = $this->trip_mdl->get_trip_data_by_id($trip_id);  
       // echo '<pre>' ;print_r($data['user_data']);
        if (!empty($data['user_data'])) { 
            $data['title'] = 'View Trip'; 
            $data['active_menu'] = 'trip'; 
            $data['active_sub_menu'] = 'trip'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/dashboard/view_trip_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Trip not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('dashboard', 'refresh'); 
        } 
    } 
	
	
   
   
}
