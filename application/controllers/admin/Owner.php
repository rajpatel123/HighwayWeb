<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Owner extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/useradmin_model', 'useradmin_mdl'); 
        $this->load->model('admin_models/customer_model', 'customer_mdl'); 
        $this->load->model('admin_models/driver_model', 'driver_mdl'); 
        // $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
       
        $data = array();
        $data['title'] = 'Manage Owner';
        $data['active_menu'] = 'owner';
        $data['active_sub_menu'] = 'owner';
        $data['active_sub_sub_menu'] = ''; 
        $data['owner_info'] = $this->useradmin_mdl->get_owner_info();
       // echo '<pre>' ;        print_r($data['owner_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/owners/manage_owner_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

    public function add_owner() { 
        $data = array(); 
        $data['title'] = 'Add Owner';
        $data['active_menu'] = 'owner';
        $data['active_sub_menu'] = 'owner';
        $data['active_sub_sub_menu'] = '';
        $data['state'] = $this->driver_mdl->get_StateDropdown();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/owners/add_owner_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    public function fetchcity()
        {
            if ($this->input->post('state_id'))
            {
                echo $this->driver_mdl->fetchstateidwisedata($this->input->post('state_id'));
            }
        }
    public function create_owner() {
        // $imgPath = base_url(). '/assets/backend/img/owner/';
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
                'rules' => 'trim|max_length[250]|min_length[10]'
            ),
            array(
                'field' => 'Address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]|min_length[5]'
            ),
             array(
                'field' => 'state',
                'label' => 'state',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'city',
                'label' => 'city',
                'rules' => 'trim|required'
            ), 
           
            array(
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            ),
           
//            array(
//                'upload_path' => $imgPath,
//                'allowed_types' => 'gif|jpg|png',
//                'max_size' => 100,
//                'max_width' => 1024,
//                'max_height' => 768,
//            )
        );
       
        //echo '<pre>' ;print_r($config) ;die;
        $this->form_validation->set_rules($config);
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_owner();
        } else {
            
            
            $data['Name'] = $this->input->post('Name', TRUE); 
            $data['Mobile'] = $this->input->post('Mobile', TRUE); 
            $data['Address'] = $this->input->post('Address', TRUE); 
            $data['Email'] = $this->input->post('Email', TRUE); 
            $data['Gender'] = $this->input->post('Gender', TRUE); 
            $data['u_state_id'] = $this->input->post('state', TRUE); 
            $data['u_city_id'] = $this->input->post('city', TRUE); 
            $data['Image'] = ""; 
            $data['Role_Id'] = 5; 
            $data['add_by'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            
            //echo '<pre>' ;print_r($data) ;die;
            $mobileCheckData = $this->customer_mdl->checkMobileData($data['Mobile']); 
            if(empty($mobileCheckData)){
            $insert_id = $this->useradmin_mdl->add_owner_data($data); 
            
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $profilePic=$insert_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/owner/profile/" . strtolower($profilePic);
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->useradmin_mdl->update_owner($insert_id, $dataUpdate); 
                    }
                }
                
            //=============profile upload end===============//
             //=============aadhaar front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharfrontfile']['error'] == 0) {
                    $img = $_FILES['aadharfrontfile']['name'];
                    $tmp = $_FILES['aadharfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$insert_id.'_aadharFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/owner/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_front_image']=$addharFPic;
                    $this->useradmin_mdl->update_owner($insert_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar front end===============//  
                
                
                 //=============aadhaar back===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharbackfile']['error'] == 0) {
                    $img = $_FILES['aadharbackfile']['name'];
                    $tmp = $_FILES['aadharbackfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$insert_id.'_aadharBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/owner/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_back_image']=$addharFPic;
                    $this->useradmin_mdl->update_owner($insert_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar back end===============// 
              
            
            
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
            } else { 
                $sdata['exception'] = 'user Alerady register !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner/add_owner', 'refresh'); 
            } 
        } 
    }
 
    public function published_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_owner_by_owner_id($owner_id); 
        if (!empty($owner_info)) { 
            $result = $this->useradmin_mdl->published_owner_by_id($owner_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    }
 
    public function unpublished_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_owner_by_owner_id($owner_id);
        if (!empty($owner_info)) {
            $result = $this->useradmin_mdl->unpublished_owner_by_id($owner_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    }  

    public function edit_owner($owner_id) { 
        $data = array(); 
        $data['user_data'] = $this->useradmin_mdl->get_owner_by_owner_id($owner_id); 
       // echo '<pre>' ;print_r($data);die;
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Owner'; 
            $data['active_menu'] = 'owner'; 
            $data['active_sub_menu'] = 'owner'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['state'] = $this->driver_mdl->get_StateDropdown();
            $data['city'] = $this->driver_mdl->get_CityDropdown($data['user_data']['u_city_id']);
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/owners/edit_owner_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    } 

    public function update_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_owner_by_owner_id($owner_id); 
        if (!empty($owner_info)) { 
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
                'rules' => 'trim|max_length[250]|min_length[10]'
            ),
            array(
                'field' => 'Address',
                'label' => 'Address',
                'rules' => 'trim|required|max_length[250]|min_length[5]'
            ),
            
             array(
                'field' => 'state',
                'label' => 'state',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'city',
                'label' => 'city',
                'rules' => 'trim|required'
            ),     
            array(
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            ),
           
            );
             $this->load->library('upload', $config);
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_owner($owner_id); 
            } else { 
                $data['Name'] = $this->input->post('Name', TRUE); 
                $data['Mobile'] = $this->input->post('Mobile', TRUE); 
                $data['Address'] = $this->input->post('Address', TRUE); 
                $data['Email'] = $this->input->post('Email', TRUE); 
                $data['Role_Id'] = 5; 
                $data['Gender'] = $this->input->post('Gender', TRUE); 
                $data['u_state_id'] = $this->input->post('state', TRUE); 
                $data['u_city_id'] = $this->input->post('city', TRUE); 
                $data['add_by'] = $this->session->userdata('admin_id');
                $data['created_on'] = date('Y-m-d H:i:s');  
                $result = $this->useradmin_mdl->update_owner($owner_id, $data); 
                //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $profilePic=$owner_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/owner/profile/" . strtolower($profilePic);
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->useradmin_mdl->update_owner($owner_id, $dataUpdate); 
                    }
                }
                
            //=============profile upload end===============//
                
                //=============aadhaar front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharfrontfile']['error'] == 0) {
                    $imgA = $_FILES['aadharfrontfile']['name'];
                    $tmp = $_FILES['aadharfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgA, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$owner_id.'_aadharFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgA){
                            $path = "./assets/backend/img/owner/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_front_image']=$addharFPic;
                    $this->useradmin_mdl->update_owner($owner_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar front end===============//  
                
                
                 //=============aadhaar back===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharbackfile']['error'] == 0) {
                    $imgB = $_FILES['aadharbackfile']['name'];
                    $tmp = $_FILES['aadharbackfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgB, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$owner_id.'_aadharBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgB){
                            $path = "./assets/backend/img/owner/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_back_image']=$addharFPic;
                    $this->useradmin_mdl->update_owner($owner_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar back end===============// 
                
                
                
                
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/owner', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/owner', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    } 

    public function remove_owner($owner_id) { 
        $owner_info = $this->useradmin_mdl->get_Owner_by_owner_id($owner_id); 
        if (!empty($owner_info)) { 
            $result = $this->useradmin_mdl->remove_owner_by_id($owner_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/owner', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owners', 'refresh'); 
        } 
    } 
    
    
    public function view_owner($owner_id) { 
        $data = array(); 
        $data['user_data'] = $this->useradmin_mdl->get_owner_by_owner_id($owner_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'View Owner'; 
            $data['active_menu'] = 'owner'; 
            $data['active_sub_menu'] = 'owner'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/owners/view_owner_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/owner', 'refresh'); 
        } 
    } 
    
    
    
}
?>