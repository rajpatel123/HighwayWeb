<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class PaymentHistory extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Book_trip_fare_model','book_trip_fare_mdl'); 
        
    } 
    public function index(){
        $data = array();
        $data['title'] = 'Manage Payment history';
        $data['active_menu'] = 'Manage Payment history';
        $data['active_sub_menu'] = 'Manage Payment history' ;
        $data['active_sub_sub_menu'] = ''; 
        $data['fare_info'] = $this->book_trip_fare_mdl->get_payment_history();
        //echo '<pre>' ;print_r($data['fare_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/paymentHistory/manage_payment_history', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
    
}
?>