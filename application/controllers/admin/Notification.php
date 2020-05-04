<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Notification extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Push_notification_model','push_notification_mdl'); 
        
    } 
    public function index(){
        $data = array();
        $data['title'] = 'Manage Notification';
        $data['active_menu'] = 'Manage Notification';
        $data['active_sub_menu'] = 'Manage Notification';
        $data['active_sub_sub_menu'] = ''; 
        $data['single_user'] = $this->push_notification_mdl->get_notificationSingleUser();
        $data['all_user'] = $this->push_notification_mdl->get_notificationAllUser();
        //echo '<pre>' ;print_r($data['fare_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/Notification/manage_notification', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
    
}
?>