<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Driver extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('owner_models/driver_model', 'driver_mdl'); 
        $this->load->model('owner_models/customer_model', 'customer_mdl'); 
        
//         $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
        $data = array();
        $data['title'] = 'Manage Driver';
        $data['active_menu'] = 'driver';
        $data['active_sub_menu'] = 'driver';
        $data['active_sub_sub_menu'] = ''; 
        $data['login_owner_id']=$this->session->userdata('admin_id'); 
        $data['driver_info'] = $this->driver_mdl->get_driver_info($data['login_owner_id']);
       // echo '<pre>' ;print_r($data['driver_info']);die;
      
        $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('owner_views/drivers/manage_driver_v', $data, TRUE);
        $this->load->view('owner_views/admin_master_v', $data);
    } 

     
        
    
     public function add_driver() { 
        $data = array(); 
        $data['title'] = 'Add Driver';
        $data['active_menu'] = 'driver';
        $data['active_sub_menu'] = 'driver';
        $data['active_sub_sub_menu'] = '';
        $data['state'] = $this->driver_mdl->get_StateDropdown();
        $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('owner_views/drivers/add_driver_v', $data, TRUE);
        $this->load->view('owner_views/admin_master_v', $data);
    }
    
    public function fetchcity()
        {
            if ($this->input->post('state_id'))
            {
                echo $this->driver_mdl->fetchstateidwisedata($this->input->post('state_id'));
            }
        }
    public function create_driver() {
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
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
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
                'field' => 'License_Number',
                'label' => 'License_Number',
                'rules' => 'trim|required|max_length[250]'
            ),

            );
        $this->load->library('upload', $config);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            // echo 'hi123';die;
            $this->add_driver();
        } else {
            $data['Name'] = $this->input->post('Name', TRUE); 
            $data['Mobile'] = $this->input->post('Mobile', TRUE); 
            $data['Address'] = $this->input->post('Address', TRUE); 
            $data['Email'] = $this->input->post('Email', TRUE); 
            $data['Status'] = 0;
            $data['Gender'] = $this->input->post('Gender', TRUE); 
            $data['u_state_id'] = $this->input->post('state', TRUE); 
            $data['u_city_id'] = $this->input->post('city', TRUE); 
            $data['Image'] ='';
            $data['Role_Id'] = 3; 
            $data['add_by'] = $this->session->userdata('admin_id'); 
            $data['u_date'] = date('Y-m-d'); 
            $mobileCheckData = $this->customer_mdl->checkMobileData($data['Mobile']); 
            if(empty($mobileCheckData)){
            $insert_id = $this->driver_mdl->add_driver_data($data);  // Insert in user table
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $profilePic=$insert_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/driver/profile/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->driver_mdl->update_driver($insert_id, $dataUpdate); 
                    }
                }
                
            //=============profile upload end===============//
            $dataDriver['License_Number'] = $this->input->post('License_Number', TRUE); 
         //   $dataDriver['vehicle_id'] = $this->input->post('vehicle_id', TRUE); 
            $dataDriver['User_Id'] = $insert_id; 
            $dataDriver['Status'] = 1; 
            $dataDriver['Image'] ='';
            $dataDriver['license_front_image'] ='';
            $dataDriver['license_back_image'] ='';
            $insert_driverid = $this->driver_mdl->add_driver_licence_data($dataDriver);  // Insert in drive_license table
            
            
                 //=============dl front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['dlfrontfile']['error'] == 0) {
                    $imgdl = $_FILES['dlfrontfile']['name'];
                    $tmp = $_FILES['dlfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgdl, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $dlfPic=$insert_id.'_dlFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgdl){
                            $path = "./assets/backend/img/driver/dl/" .$dlfPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['dlfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $datadlUpdate['license_front_image']=$dlfPic;
                    $this->driver_mdl->update_driver_dl($insert_id, $datadlUpdate); 
                    }
                }
                
            //=============dl front end===============//  
                
                
                 //=============dl back===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['dlbackfile']['error'] == 0) {
                    $imgdlb = $_FILES['dlbackfile']['name'];
                    $tmp = $_FILES['dlbackfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgdlb, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $dlbPic=$insert_id.'_dlBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgdlb){
                            $path = "./assets/backend/img/driver/dl/" .$dlbPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['dlbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $datadlUpdate['license_back_image']=$dlbPic;
                    $this->driver_mdl->update_driver_dl($insert_id, $datadlUpdate); 
                    }
                }
                
            //=============dl back end===============// 
               //=============aadhaar front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharfrontfile']['error'] == 0) {
                    $imgfa = $_FILES['aadharfrontfile']['name'];
                    $tmp = $_FILES['aadharfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgfa, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $addharFPic=$insert_id.'_aadharFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgfa){
                            $path = "./assets/backend/img/driver/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_front_image']=$addharFPic;
                    $this->driver_mdl->update_driver($insert_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar front end===============//  
                
                
                 //=============aadhaar back===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharbackfile']['error'] == 0) {
                    $imgfb = $_FILES['aadharbackfile']['name'];
                    $tmp = $_FILES['aadharbackfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgfb, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $addharFPic=$insert_id.'_aadharBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgfb){
                            $path = "./assets/backend/img/driver/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_back_image']=$addharFPic;
                    $this->driver_mdl->update_driver($insert_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar back end===============// 
                
                
                
                
                
          if (!empty($insert_id) && (!empty($insert_driverid))) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } 
             } else { 
                $sdata['exception'] = 'user Alerady register !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver/add_driver', 'refresh'); 
            } 
        } 
    }
 
    public function published_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_driver_by_driver_id($driver_id); 
        if (!empty($driver_info)) { 
            $result = $this->driver_mdl->published_driver_by_id($driver_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('owner/driver', 'refresh'); 
        } 
    }
 
    public function unpublished_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_driver_by_driver_id($driver_id);
        if (!empty($driver_info)) {
            $result = $this->driver_mdl->unpublished_driver_by_id($driver_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/driver', 'refresh'); 
        } 
    }  

   public function edit_driver($driver_id) { 
        $data = array(); 
        $data['user_data'] = $this->driver_mdl->getDriverViewData($driver_id); 
        //echo '<pre>' ;print_r($data['user_data']);die;
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Driver'; 
            $data['active_menu'] = 'driver'; 
            $data['active_sub_menu'] = 'driver'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['state'] = $this->driver_mdl->get_StateDropdown();
            $data['city'] = $this->driver_mdl->get_CityDropdown($data['user_data']['u_city_id']);
            $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('owner_views/drivers/edit_driver_v', $data, TRUE);
            $this->load->view('owner_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/driver', 'refresh'); 
        } 
    } 

    public function update_driver($driver_id) { 
        $driver_info = $this->driver_mdl->getDriverViewData($driver_id); 
        if (!empty($driver_info)) { 
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
                'field' => 'License_Number',
                'label' => 'License_Number',
                'rules' => 'trim|required|max_length[250]'
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
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_driver($driver_id); 
            } else { 
                $data['Name'] = $this->input->post('Name', TRUE); 
                $data['Mobile'] = $this->input->post('Mobile', TRUE); 
                $data['Address'] = $this->input->post('Address', TRUE); 
                $data['Email'] = $this->input->post('Email', TRUE); 
                $data['Status'] = 0;
                $data['Role_Id'] = 3; 
                $data['Gender'] = $this->input->post('Gender', TRUE); 
                $data['add_by'] = $this->session->userdata('admin_id');
                $data['u_state_id'] = $this->input->post('state', TRUE); 
                $data['u_city_id'] = $this->input->post('city', TRUE); 
                $data['created_on'] = date('Y-m-d H:i:s');  
                $result = $this->driver_mdl->update_driver($driver_id, $data); 
                
                $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['userfile']['error'] == 0) {
                    $img = $_FILES['userfile']['name'];
                    $tmp = $_FILES['userfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $profilePic=$driver_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/driver/profile/" . $profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['userfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->driver_mdl->update_driver($driver_id, $dataUpdate); 
                    }
                }
                
                
                $dataDriver['License_Number'] = $this->input->post('License_Number', TRUE);
                $dataDriver['User_Id'] = $driver_id; 
                $dataDriver['Status'] = 1; 
                $driverData = $this->driver_mdl->update_driver_dl($driver_id,$dataDriver);
               
                
                
                //=============dl front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['dlfrontfile']['error'] == 0) {
                    $imgdl = $_FILES['dlfrontfile']['name'];
                    $tmp = $_FILES['dlfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgdl, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $dlfPic=$driver_id.'_dlFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgdl){
                            $path = "./assets/backend/img/driver/dl/" .$dlfPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['dlfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataDLUpdate['license_front_image']=$dlfPic;
                    $this->driver_mdl->update_driver_dl($driver_id, $dataDLUpdate); 
                    }
                }
                
            //=============dl front end===============//  
                
                
                 //=============dl back===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['dlbackfile']['error'] == 0) {
                    $imgdlb = $_FILES['dlbackfile']['name'];
                    $tmp = $_FILES['dlbackfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgdlb, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $dlbPic=$driver_id.'_dlBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgdlb){
                            $path = "./assets/backend/img/driver/dl/" .$dlbPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['dlbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataDLUpdate['license_back_image']=$dlbPic;
                    $this->driver_mdl->update_driver_dl($driver_id, $dataDLUpdate); 
                    }
                }
                
            //=============dl back end===============// 
                
                
                
                 //=============aadhaar front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharfrontfile']['error'] == 0) {
                    $img = $_FILES['aadharfrontfile']['name'];
                    $tmp = $_FILES['aadharfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $addharFPic=$driver_id.'_aadharFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/driver/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_front_image']=$addharFPic;
                    $this->driver_mdl->update_driver($driver_id, $dataUpdate); 
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
                        $driverName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $driverName);
                        $addharFPic=$driver_id.'_aadharBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/driver/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_back_image']=$addharFPic;
                    $this->driver_mdl->update_driver($driver_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar back end===============// 
                
                
                
                
                
                 
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('owner/driver', 'refresh'); 
                } else { 
                    
//                    echo '<pre>' ;print_r($result);
//                 echo '<pre>' ;print_r($driverData); die;
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('owner/driver', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/driver', 'refresh'); 
        } 
    } 

    public function remove_driver($driver_id) { 
        $driver_info = $this->driver_mdl->get_Driver_by_driver_id($driver_id); 
        if (!empty($driver_info)) { 
            $result = $this->driver_mdl->remove_driver_by_id($driver_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/driver', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/drivers', 'refresh'); 
        } 
    } 
    
    public function view_driver($driver_id) { 
        $data = array(); 
        $data['user_data'] = $this->driver_mdl->getDriverViewData($driver_id);  
        //echo '<pre>' ;print_r($data);die;
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Driver'; 
            $data['active_menu'] = 'driver'; 
            $data['active_sub_menu'] = 'driver'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('owner_views/drivers/view_driver_v', $data, TRUE);
            $this->load->view('owner_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/driver', 'refresh'); 
        } 
    } 
}
?>