<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Customer extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/customer_model', 'customer_mdl'); 
        
        // $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 
    
    
    

    public function index() {
        $data = array();
        $data['title'] = 'Manage Customer';
        $data['active_menu'] = 'customer';
        $data['active_sub_menu'] = 'customer';
        $data['active_sub_sub_menu'] = ''; 
        $data['customer_info'] = $this->customer_mdl->get_customer_info();
       // echo '<pre>' ;        print_r($data['customer_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/customers/manage_customer_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
    
    

    public function add_customer() { 
        $data = array(); 
        $data['title'] = 'Add Customer';
        $data['active_menu'] = 'customer';
        $data['active_sub_menu'] = 'customer';
        $data['active_sub_sub_menu'] = '';
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/customers/add_customer_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function create_customer() {
        // $imgPath = base_url(). '/assets/backend/img/customer/';
        $config = array(
            array(
                'field' => 'Name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[250]|min_length[2]'
            ),
            array(
                'field' => 'Mobile',
                'label' => 'Mobile',
                'rules' => 'trim|required|max_length[15]|min_length[10]'
            ),
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'trim|required|max_length[250]|min_length[10]'
            ),
            array(
                'field' => 'Address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]|min_length[5]'
            ),
            array(
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'emergency_contact1',
                'label' => 'emergency_contact1',
                'rules' => 'trim|max_length[15]|min_length[10]'
            ),
            array(
                'field' => 'emergency_contact2',
                'label' => 'emergency_contact2',
                'rules' => 'trim|max_length[15]|min_length[10]'
            )
            );
        $this->load->library('upload', $config);
        $this->form_validation->set_rules($config);
       // $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_customer();
        } else {
            
            
            $data['Name'] = $this->input->post('Name', TRUE); 
            $data['Mobile'] = $this->input->post('Mobile', TRUE); 
            $data['Address'] = $this->input->post('Address', TRUE); 
            $data['Role_Id'] = 2; 
            $data['Email'] = $this->input->post('Email', TRUE); 
            $data['Gender'] = $this->input->post('Gender', TRUE); 
            $data['emergency_contact1'] = $this->input->post('emergency_contact1', TRUE); 
            $data['emergency_contact2'] = $this->input->post('emergency_contact2', TRUE); 
            $data['Image'] = ''; 
            $data['add_by'] = $this->session->userdata('admin_id'); 
            $data['u_date'] = date('Y-m-d');  
            
            //echo '<pre>' ;print_r($data) ;die;
            $mobileCheckData = $this->customer_mdl->checkMobileData($data['Mobile']); 
            if(empty($mobileCheckData)){
                $insert_id = $this->customer_mdl->add_customer_data($data); 
                
                
                //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $userName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $userName);
                        $profilePic=$insert_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/customer/profile/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->customer_mdl->update_customer($insert_id, $dataUpdate); 
                    }
                }
                
            //=============profile upload end===============//
                
                
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } 
            } else { 
                $sdata['exception'] = 'user Alerady register !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer/add_customer', 'refresh'); 
            } 
        } 
    }
 
    public function published_customer($customer_id) { 
        $customer_info = $this->customer_mdl->get_customer_by_customer_id($customer_id); 
        if (!empty($customer_info)) { 
            $result = $this->customer_mdl->published_customer_by_id($customer_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/customer', 'refresh'); 
        } 
    }
 
    public function unpublished_customer($customer_id) { 
        $customer_info = $this->customer_mdl->get_customer_by_customer_id($customer_id);
        if (!empty($customer_info)) {
            $result = $this->customer_mdl->unpublished_customer_by_id($customer_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/customer', 'refresh'); 
        } 
    }  

    public function edit_customer($customer_id) { 
        $data = array(); 
        $data['user_data'] = $this->customer_mdl->get_customer_by_customer_id($customer_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Customer'; 
            $data['active_menu'] = 'customer'; 
            $data['active_sub_menu'] = 'customer'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/customers/edit_customer_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/customer', 'refresh'); 
        } 
    } 

    public function update_customer($customer_id) { 
        $customer_info = $this->customer_mdl->get_customer_by_customer_id($customer_id); 
        if (!empty($customer_info)) { 
            $config = array( 
                array(
                'field' => 'Name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Mobile',
                'label' => 'Mobile',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Email',
                'label' => 'Email',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]'
            ),
            array(
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'emergency_contact1',
                'label' => 'emergency_contact1',
                'rules' => 'trim|max_length[250]'
            ),
            array(
                'field' => 'emergency_contact_two',
                'label' => 'emergency_contact_two',
                'rules' => 'trim|max_length[250]'
            )
            );
            $this->load->library('upload', $config);
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_customer($customer_id); 
            } else { 
                $data['Name'] = $this->input->post('Name', TRUE); 
                $data['Role_Id'] = 2;
                $data['Mobile'] = $this->input->post('Mobile', TRUE); 
                $data['Address'] = $this->input->post('Address', TRUE); 
                $data['Email'] = $this->input->post('Email', TRUE); 
                $data['Gender'] = $this->input->post('Gender', TRUE); 
                $data['emergency_contact1'] = $this->input->post('emergency_contact1', TRUE); 
                $data['emergency_contact2'] = $this->input->post('emergency_contact_two', TRUE); 
                $data['add_by'] = $this->session->userdata('admin_id');
                $data['created_on'] = date('Y-m-d H:i:s'); 
               
                $result = $this->customer_mdl->update_customer($customer_id, $data); 
                // echo '<pre>' ;print_r($result);die;
                
                 //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $userName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $userName);
                        $profilePic=$customer_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/customer/profile/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->customer_mdl->update_customer($customer_id, $dataUpdate); 
                    }
                }
                
            //=============profile upload end===============//
                
                
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/customer', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/customer', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/customer', 'refresh'); 
        } 
    } 

    public function remove_customer($customer_id) { 
        $customer_info = $this->customer_mdl->get_Customer_by_customer_id($customer_id); 
        if (!empty($customer_info)) { 
            $result = $this->customer_mdl->remove_customer_by_id($customer_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/customer', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/customers', 'refresh'); 
        } 
    } 
    
     public function view_customer($customer_id) { 
        $data = array(); 
        $data['user_data'] = $this->customer_mdl->get_customer_by_customer_id($customer_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Customer'; 
            $data['active_menu'] = 'customer'; 
            $data['active_sub_menu'] = 'customer'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/customers/view_customer_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/customer', 'refresh'); 
        } 
    } 
}
?>