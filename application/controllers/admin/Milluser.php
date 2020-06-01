<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Milluser extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/milluser_model', 'milluser_mdl'); 
        $this->load->model('admin_models/customer_model', 'customer_mdl'); 
        $this->load->model('admin_models/driver_model', 'driver_mdl'); 
        
        // $memberObj = $this->session->userdata;
       // echo '<pre>' ; print_r($memberObj);die;
    } 

    public function index() {
        $data = array();
        $data['title'] = 'Manage Goods Provider';
        $data['active_menu'] = 'Goods Provider';
        $data['active_sub_menu'] = 'Goods Provider';
        $data['active_sub_sub_menu'] = ''; 
        $data['milluser_info'] = $this->milluser_mdl->get_milluser_info();
       // echo '<pre>' ;        print_r($data['milluser_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/millusers/manage_milluser_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 

    public function add_milluser() { 
        $data = array(); 
        $data['title'] = 'Add Goods Provider';
        $data['active_menu'] = 'Goods Provider';
        $data['active_sub_menu'] = 'Goods Provider';
        $data['active_sub_sub_menu'] = '';
        $data['state'] = $this->driver_mdl->get_StateDropdown();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/millusers/add_milluser_v', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    }
    
    public function fetchcity()
        {
            if ($this->input->post('state_id'))
            {
                echo $this->driver_mdl->fetchstateidwisedata($this->input->post('state_id'));
            }
        }
    public function create_milluser() {
        // $imgPath = base_url(). '/assets/backend/img/milluser/';
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
                'field' => 'Status',
                'label' => 'Status',
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
        $this->load->library('upload', $config);
        $this->form_validation->set_rules($config);
       // $this->load->library('upload', $config);
        if ($this->form_validation->run() == FALSE) {
            $this->add_milluser();
        } else {
            
            
            $data['Name'] = $this->input->post('Name', TRUE); 
            $data['Mobile'] = $this->input->post('Mobile', TRUE); 
            $data['Address'] = $this->input->post('Address', TRUE); 
            $data['Email'] = $this->input->post('Email', TRUE); 
            $data['Status'] = $this->input->post('Status', TRUE); 
            $data['Gender'] = $this->input->post('Gender', TRUE); 
            $data['u_state_id'] = $this->input->post('state', TRUE); 
            $data['u_city_id'] = $this->input->post('city', TRUE); 
         //   $data['Image'] = '';
            $data['Role_Id'] = 2; 
            $data['add_by'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            
            //echo '<pre>' ;print_r($data) ;die;
             $mobileCheckData = $this->customer_mdl->checkMobileData($data['Mobile']); 
            if(empty($mobileCheckData)){
            $insert_id = $this->milluser_mdl->add_milluser_data($data); 
            $miluserFirstImage = array();
            if (($_FILES['milFirstfile']['error'] == 0) OR ($_FILES['milSecondfile']['error'] == 0))  {
                $miluserFirstImage['g_p_goods_provider_id']=$insert_id;
                $miluserFirstImage['g_p_status']=1;
                $miluserFirstImage['g_p_add_by']=$this->session->userdata('admin_id');;
                $miluserFirstImage['g_p_date']=date('Y-m-d');
                $insert_goodsprovider_id = $this->milluser_mdl->add_goodprovider_mil_images_data($miluserFirstImage); 
            
            }
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['milprofilefile']['error'] == 0) {
                    $img = $_FILES['milprofilefile']['name'];
                    $tmp = $_FILES['milprofilefile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $miluserName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $miluserName);
                        $profilePic=$insert_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/milluser/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['milprofilefile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->milluser_mdl->update_milluser($insert_id, $dataUpdate); 
                    }
                }
             //=============profile end===============//
                
                
                //=============mil first image upload===============//
                
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['milFirstfile']['error'] == 0) {
                    $imgF = $_FILES['milFirstfile']['name'];
                    $tmp = $_FILES['milFirstfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgF, PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_extensions)) {
                        $miluserName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $miluserName);
                        $milfirst=$insert_goodsprovider_id.'_milfirst_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgF){
                            $pathF = "./assets/backend/img/milluser/" .$milfirst;
                        } else {
                            $pathF ='';
                        }
                        if (move_uploaded_file($tmp, $pathF)){
                            $_POST['milFirstfile'] = $pathF;
                        }
                    }
                    if (file_exists($pathF)) {
                    $data_first['g_p_mil_image_first']=$milfirst;
                    $this->milluser_mdl->update_goodprovider_mil_images_data($insert_goodsprovider_id, $data_first); 
                    }
                }
             //=============milfirst first image end===============//
                
                
                //=============mil second image upload===============//
               
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['milSecondfile']['error'] == 0) {
                    $imgS = $_FILES['milSecondfile']['name'];
                    $tmp = $_FILES['milSecondfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgS, PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_extensions)) {
                        $miluserName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $miluserName);
                        $mil_Secondfile=$insert_goodsprovider_id.'_milsecond_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgS){
                            $pathS = "./assets/backend/img/milluser/" .$mil_Secondfile;
                        } else {
                            $pathS ='';
                        }
                        if (move_uploaded_file($tmp, $pathS)){
                            $_POST['milSecondfile'] = $pathS;
                        }
                    }
                    if (file_exists($pathS)) {
                    $dataSecond['g_p_mil_image_second']=$mil_Secondfile;
                    $this->milluser_mdl->update_goodprovider_mil_images_data($insert_goodsprovider_id, $dataSecond); 
                    }
                }
             //=============mil second image  end===============//
                
                
                 //=============aadhaar front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharfrontfile']['error'] == 0) {
                    $imgaf = $_FILES['aadharfrontfile']['name'];
                    $tmp = $_FILES['aadharfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgaf, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$insert_id.'_aadharFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgaf){
                            $path = "./assets/backend/img/milluser/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_front_image']=$addharFPic;
                    $this->milluser_mdl->update_milluser($insert_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar front end===============//  
                
                
                 //=============aadhaar back===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharbackfile']['error'] == 0) {
                    $imgab = $_FILES['aadharbackfile']['name'];
                    $tmp = $_FILES['aadharbackfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgab, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$insert_id.'_aadharBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgab){
                            $path = "./assets/backend/img/milluser/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_back_image']=$addharFPic;
                    $this->milluser_mdl->update_milluser($insert_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar back end===============// 
                
                
                
                
            
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } 
            } else { 
                $sdata['exception'] = 'user Alerady register !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser/add_milluser', 'refresh'); 
            } 
        } 
    }
 
    public function published_milluser($milluser_id) { 
        $milluser_info = $this->milluser_mdl->get_milluser_by_milluser_id($milluser_id); 
        if (!empty($milluser_info)) { 
            $result = $this->milluser_mdl->published_milluser_by_id($milluser_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('admin/milluser', 'refresh'); 
        } 
    }
 
    public function unpublished_milluser($milluser_id) { 
        $milluser_info = $this->milluser_mdl->get_milluser_by_milluser_id($milluser_id);
        if (!empty($milluser_info)) {
            $result = $this->milluser_mdl->unpublished_milluser_by_id($milluser_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/milluser', 'refresh'); 
        } 
    }  

    public function edit_milluser($milluser_id) { 
        $data = array(); 
        $data['user_data'] = $this->milluser_mdl->get_milluser_by_milluser_id($milluser_id);  
        $data['millImageData'] = $this->milluser_mdl->get_millimageData($milluser_id);
       // echo '<pre>' ;print_r($data['millImageData']);die;
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Milluser'; 
            $data['active_menu'] = 'milluser'; 
            $data['active_sub_menu'] = 'milluser'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['state'] = $this->driver_mdl->get_StateDropdown();
            $data['city'] = $this->driver_mdl->get_CityDropdown($data['user_data']['u_city_id']);
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/millusers/edit_milluser_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/milluser', 'refresh'); 
        } 
    } 

    public function update_milluser($milluser_id) { 
        $milluser_info = $this->milluser_mdl->get_milluser_by_milluser_id($milluser_id); 
        if (!empty($milluser_info)) { 
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
                'field' => 'Status',
                'label' => 'Status',
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
                'field' => 'Gender',
                'label' => 'Gender',
                'rules' => 'trim|required'
            )
            
            );
            $this->load->library('upload', $config);
            $this->form_validation->set_rules($config); 
           
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_milluser($milluser_id); 
            } else { 
                $data['Name'] = $this->input->post('Name', TRUE); 
                $data['Mobile'] = $this->input->post('Mobile', TRUE); 
                $data['Address'] = $this->input->post('Address', TRUE); 
                $data['Email'] = $this->input->post('Email', TRUE); 
                $data['Status'] = $this->input->post('Status', TRUE); 
                $data['Role_Id'] = 2; 
                $data['Gender'] = $this->input->post('Gender', TRUE); 
                $data['add_by'] = $this->session->userdata('admin_id');
                $data['u_state_id'] = $this->input->post('state', TRUE); 
                $data['u_city_id'] = $this->input->post('city', TRUE); 
                $data['created_on'] = date('Y-m-d H:i:s');  
                $result = $this->milluser_mdl->update_milluser($milluser_id, $data);
                
                $checkGoodProvideData = $this->milluser_mdl->get_millimageData($milluser_id);
                if($checkGoodProvideData){
                  $mill_user_id = $milluser_id;  
                } else {
                
                 $miluserFirstImage = array();
            if (($_FILES['milFirstfile']['error'] == 0) OR ($_FILES['milSecondfile']['error'] == 0))  {
                $miluserFirstImage['g_p_goods_provider_id']=$insert_id;
                $miluserFirstImage['g_p_status']=1;
                $miluserFirstImage['g_p_add_by']=$this->session->userdata('admin_id');;
                $miluserFirstImage['g_p_date']=date('Y-m-d');
                $insert_goodsprovider_id = $this->milluser_mdl->add_goodprovider_mil_images_data($miluserFirstImage); 
            
            }
            $mill_user_id = $insert_goodsprovider_id; 
            
                }
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['milprofilefile']['error'] == 0) {
                    $img = $_FILES['milprofilefile']['name'];
                    $tmp = $_FILES['milprofilefile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $miluserName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $miluserName);
                        $profilePic=$milluser_id.'_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/milluser/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['milprofilefile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['Image']=$profilePic;
                    $this->milluser_mdl->update_milluser($milluser_id, $dataUpdate); 
                    }
                }
             //=============profile end===============//
                
                
                //=============mil first image upload===============//
                
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['milFirstfile']['error'] == 0) {
                    $imgFi = $_FILES['milFirstfile']['name'];
                    $tmp = $_FILES['milFirstfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgFi, PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_extensions)) {
                        $miluserName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $miluserName);
                        $milfirst=$mill_user_id.'_milfirst_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgFi){
                            $pathF = "./assets/backend/img/milluser/" .$milfirst;
                        } else {
                            $pathF ='';
                        }
                        if (move_uploaded_file($tmp, $pathF)){
                            $_POST['milFirstfile'] = $pathF;
                        }
                    }
                    if (file_exists($pathF)) {
                    $data_first['g_p_mil_image_first']=$milfirst;
                    $this->milluser_mdl->update_goodprovider_mil_images_data($mill_user_id, $data_first); 
                    }
                }
             //=============milfirst first image end===============//
                
                
                //=============mil second image upload===============//
               
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['milSecondfile']['error'] == 0) {
                    $imgSc = $_FILES['milSecondfile']['name'];
                    $tmp = $_FILES['milSecondfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgSc, PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_extensions)) {
                        $miluserName=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $miluserName);
                        $mil_Secondfile=$mill_user_id.'_milsecond_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgSc){
                            $pathS = "./assets/backend/img/milluser/" .$mil_Secondfile;
                        } else {
                            $pathS ='';
                        }
                        if (move_uploaded_file($tmp, $pathS)){
                            $_POST['milSecondfile'] = $pathS;
                        }
                    }
                    if (file_exists($pathS)) {
                    $dataSecond['g_p_mil_image_second']=$mil_Secondfile;
                    $this->milluser_mdl->update_goodprovider_mil_images_data($mill_user_id, $dataSecond); 
                    }
                }
             //=============mil second image  end===============//
                
                 //=============aadhaar front===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['aadharfrontfile']['error'] == 0) {
                    $imgA = $_FILES['aadharfrontfile']['name'];
                    $tmp = $_FILES['aadharfrontfile']['tmp_name'];
                    $ext = strtolower(pathinfo($imgA, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$data['Name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $addharFPic=$mill_user_id.'_aadharFront_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgA){
                            $path = "./assets/backend/img/milluser/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharfrontfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_front_image']=$addharFPic;
                    $this->milluser_mdl->update_milluser($mill_user_id, $dataUpdate); 
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
                        $addharFPic=$mill_user_id.'_aadharBack_'.$name_replace_with_underscore.'.'.$ext;
                        if($imgB){
                            $path = "./assets/backend/img/milluser/aadhar/" .$addharFPic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['aadharbackfile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['aadhar_back_image']=$addharFPic;
                    $this->milluser_mdl->update_milluser($mill_user_id, $dataUpdate); 
                    }
                }
                
            //=============aadhaar back end===============// 
                
                
                
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/milluser', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('admin/milluser', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/milluser', 'refresh'); 
        } 
    } 

    public function remove_milluser($milluser_id) { 
        $milluser_info = $this->milluser_mdl->get_Milluser_by_milluser_id($milluser_id); 
        if (!empty($milluser_info)) { 
            $result = $this->milluser_mdl->remove_milluser_by_id($milluser_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('admin/milluser', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/millusers', 'refresh'); 
        } 
    } 
    
     public function view_milluser($milluser_id) { 
        $data = array(); 
        $data['user_data'] = $this->milluser_mdl->get_milluser_by_milluser_id($milluser_id);  
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Milluser'; 
            $data['active_menu'] = 'milluser'; 
            $data['active_sub_menu'] = 'milluser'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('admin_views/millusers/view_milluser_v', $data, TRUE);
            $this->load->view('admin_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('admin/milluser', 'refresh'); 
        } 
    } 
}
?>