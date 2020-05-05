<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Rating extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Rating_model','rating_mdl'); 
        
    } 
    public function index(){
        $data = array();
        $data['title'] = 'Driver Rating';
        $data['active_menu'] = 'Driver Rating';
        $data['active_sub_menu'] = 'Driver Rating' ;
        $data['active_sub_sub_menu'] = ''; 
        $data['rating_info'] = $this->rating_mdl->get_driverRatingList();
        //echo '<pre>' ;print_r($data['rating_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/rating/manage_driver_rating', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
     public function customerRating(){
        $data = array();
        $data['title'] = 'Customer Rating';
        $data['active_menu'] = 'Customer Rating';
        $data['active_sub_menu'] = 'Customer Rating' ;
        $data['active_sub_sub_menu'] = ''; 
        $data['rating_info'] = $this->rating_mdl->get_customerRatingList();
        //echo '<pre>' ;print_r($data['rating_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/rating/manage_customer_rating', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
    
}
?>