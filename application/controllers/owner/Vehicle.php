<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Vehicle extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
//        $this->user_login_authentication(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('owner_models/Vehicle_model', 'vehicle_mdl'); 
        
    } 

    public function index() {
       
        $data = array();
        $data['title'] = 'Manage Vehicle';
        $data['active_menu'] = 'vehicle';
        $data['active_sub_menu'] = 'vehicle';
        $data['active_sub_sub_menu'] = ''; 
        $data['loginId']=$this->session->userdata('admin_id'); 
        $data['vehicle_info'] = $this->vehicle_mdl->get_vehicle_info($data['loginId']);
        $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('owner_views/vehicles/manage_vehicle_v', $data, TRUE);
        $this->load->view('owner_views/admin_master_v', $data);
    } 

    public function add_vehicle() { 
        $data = array(); 
        $data['title'] = 'Add Vehicle';
        $data['active_menu'] = 'vehicle';
        $data['active_sub_menu'] = 'vehicle';
        $data['active_sub_sub_menu'] = '';
        $data['dropdownData'] = $this->vehicle_mdl->get_driver_dropdown();
        $data['vehicleData'] = $this->vehicle_mdl->get_vehicle_dropdown();
        //echo '<pre>' ;print_r($data['vehicleData']);die;
        $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('owner_views/vehicles/add_vehicle_v', $data, TRUE);
        $this->load->view('owner_views/admin_master_v', $data);
    }
    public function create_vehicle() {
        // $imgPath = base_url(). '/assets/backend/img/vehicle/';
        $config = array(
            array(
                'field' => 'vehicle_type',
                'label' => 'vehicle_type',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'vehicle_detail',
                'label' => 'vehicle_detail',
                'rules' => 'trim|required|max_length[250]|min_length[3]'
            ),
            array(
                'field' => 'vehicle_number',
                'label' => 'vehicle_number',
                'rules' => 'trim|required|max_length[20]|min_length[3]'
            ),
            array(
                'field' => 'vehicle_model_no',
                'label' => 'vehicle_model_no',
                'rules' => 'trim|required|max_length[25]|min_length[3]'
            ),
            array(
                'field' => 'vehicle_name',
                'label' => 'vehicle_name',
                'rules' => 'trim|required|max_length[30]|min_length[3]'
            ),
            array(
                'field' => 'chechis_number',
                'label' => 'chechis_number',
                'rules' => 'trim|max_length[250]|min_length[3]'
            )

        );
       
        //echo '<pre>' ;print_r($config) ;die;
        $this->form_validation->set_rules($config);
       // $this->load->library('upload', $config);
     
        if ($this->form_validation->run() == FALSE) {
            $this->add_vehicle();
            
        } else {
            $data['v_type_id'] = $this->input->post('vehicle_type', TRUE); 
            $data['v_vehicle_detail'] = $this->input->post('vehicle_detail', TRUE); 
            $data['v_vehicle_number'] = $this->input->post('vehicle_number', TRUE); 
            $data['v_vehicle_name'] = $this->input->post('vehicle_name', TRUE); 
            $data['v_vehicle_model_no'] = $this->input->post('vehicle_model_no', TRUE); 
            $data['v_chechis_number'] = $this->input->post('chechis_number', TRUE); 
            $data['v_status'] = 1; 
           // $data['Image'] = $this->input->post('Image', TRUE); 
           
            $data['v_owner_id'] = $this->session->userdata('admin_id'); 
            $data['v_add_by'] = $this->session->userdata('admin_id'); 
            //$data['date_added'] = date('Y-m-d H:i:s');  
            $vehicleTypeId= $data['v_type_id'];
            $this->load->model('owner_models/Vehicle_type_model', 'vehicle_type_mdl');    
            $vehicleTypeData = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicleTypeId); 
            
           
            $insert_id = $this->vehicle_mdl->add_vehicle_data($data); 
            
            
            
            
            
            
            //=============profile upload===============//
            $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['rcfile']['error'] == 0) {
                    $img = $_FILES['rcfile']['name'];
                    $tmp = $_FILES['rcfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                  
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleRcImage=$insert_id.'_rc_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/vehicle/rcpic/" . $vehicleRcImage;
                        } else {
                            $path ='';
                        }
                            //  echo '<pre>' ;print_r($path) ;die;
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['rcfile'] = $path;
                        }
                    }
                    if (file_exists($path)){
                    $dataUpdate['v_vehicle_rc']=$vehicleRcImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                } 
                }
               // echo '<pre>' ;print_r($Name) ;die;
                if ($_FILES['vimagefile']['error'] == 0) {
                    $imgv = $_FILES['vimagefile']['name'];
                    $tmpv = $_FILES['vimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleImage=$insert_id.'_vimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleImage/" .$vehicleImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_vehicle_Image']=$vehicleImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
                
                if ($_FILES['vfimagefile']['error'] == 0) {
                    $imgv = $_FILES['vfimagefile']['name'];
                    $tmpv = $_FILES['vfimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleFImage=$insert_id.'_vfimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleFront/" .$vehicleFImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vfimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_front_image']=$vehicleFImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
                
                
                 if ($_FILES['vlimagefile']['error'] == 0) {
                    $imgv = $_FILES['vlimagefile']['name'];
                    $tmpv = $_FILES['vlimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehiclelImage=$insert_id.'_vlimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleLeft/" .$vehiclelImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vlimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_left_image']=$vehiclelImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
                
                
                if ($_FILES['vrimagefile']['error'] == 0) {
                    $imgv = $_FILES['vrimagefile']['name'];
                    $tmpv = $_FILES['vrimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehiclerImage=$insert_id.'_vrimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleRight/" .$vehiclerImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vrimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_right_image']=$vehiclerImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
                
                
                
                if ($_FILES['vbimagefile']['error'] == 0) {
                    $imgv = $_FILES['vbimagefile']['name'];
                    $tmpv = $_FILES['vbimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleBImage=$insert_id.'_vbimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleBack/" .$vehicleBImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vbimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_back_image']=$vehicleBImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
                
                
                if ($_FILES['veimagefile']['error'] == 0) {
                    $imgv = $_FILES['veimagefile']['name'];
                    $tmpv = $_FILES['veimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleEImage=$insert_id.'_vbimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleEngine/" .$vehicleEImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['veimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_engine_image']=$vehicleEImage;
                    $this->vehicle_mdl->update_vehicle($insert_id, $dataUpdate); 
                }
                }
               
                
               
               // echo '<pre>' ;print_r($pathv);die;
            //=============profile upload end===============//
            
            
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } 
        } 
    }
 
    public function published_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_active_inactive_by_vehicle_id($vehicle_id); 
        // echo '<pre>' ;print_r($vehicle_id);die;
        if (!empty($vehicle_info)) { 
            $result = $this->vehicle_mdl->published_vehicle_by_id($vehicle_id); 
           // echo '<pre>' ;print_r($result);die;
            if (!empty($result)) { 
                $sdata['success'] = 'Active successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !';
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !';
            $this->session->set_userdata($sdata); 
            redirect('owner/vehicle', 'refresh'); 
        } 
    }
 
    public function unpublished_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_active_inactive_by_vehicle_id($vehicle_id);
        if (!empty($vehicle_info)) {
            $result = $this->vehicle_mdl->unpublished_vehicle_by_id($vehicle_id);
            if (!empty($result)) {
                $sdata['success'] = 'Inactive successfully .';
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/vehicle', 'refresh'); 
        } 
    }  

    public function edit_vehicle($vehicle_id) { 
        $data = array(); 
        $data['user_data'] = $this->vehicle_mdl->get_active_inactive_by_vehicle_id($vehicle_id);  
        //echo '<pre>' ;print_r($data['user_data']);die;
        if (!empty($data['user_data'])) { 
            $data['title'] = 'Edit Vehicle'; 
            $data['active_menu'] = 'vehicle'; 
            $data['active_sub_menu'] = 'vehicle'; 
            $data['active_sub_sub_menu'] = ''; 
            //$data['dropdownData'] = $this->vehicle_mdl->get_driver_dropdown();
            $data['vehicleData'] = $this->vehicle_mdl->get_vehicle_dropdown();
            $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('owner_views/vehicles/edit_vehicle_v', $data, TRUE);
            $this->load->view('owner_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/vehicle', 'refresh'); 
        } 
    } 

    public function update_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_active_inactive_by_vehicle_id($vehicle_id); 
        if (!empty($vehicle_info)) { 
            $config = array( 
              array(
                'field' => 'vehicle_type',
                'label' => 'vehicle_type',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'vehicle_detail',
                'label' => 'vehicle_detail',
                'rules' => 'trim|required|max_length[250]|min_length[3]'
            ),
            array(
                'field' => 'vehicle_number',
                'label' => 'vehicle_number',
                'rules' => 'trim|required|max_length[20]|min_length[3]'
            ),
            array(
                'field' => 'vehicle_model_no',
                'label' => 'vehicle_model_no',
                'rules' => 'trim|required|max_length[25]|min_length[3]'
            ),
            array(
                'field' => 'vehicle_name',
                'label' => 'vehicle_name',
                'rules' => 'trim|required|max_length[30]|min_length[3]'
            ),
                array(
                'field' => 'chechis_number',
                'label' => 'chechis_number',
                'rules' => 'trim|max_length[250]|min_length[3]'
            )

        );
            $this->form_validation->set_rules($config); 
            if ($this->form_validation->run() == FALSE) { 
                $this->edit_vehicle($vehicle_id); 
            } else { 
                $data['v_type_id'] = $this->input->post('vehicle_type', TRUE); 
                $data['v_vehicle_detail'] = $this->input->post('vehicle_detail', TRUE); 
                $data['v_vehicle_number'] = $this->input->post('vehicle_number', TRUE); 
                $data['v_vehicle_model_no'] = $this->input->post('vehicle_model_no', TRUE); 
                $data['v_vehicle_name'] = $this->input->post('vehicle_name', TRUE); 
                $data['v_chechis_number'] = $this->input->post('chechis_number', TRUE); 
                $data['v_status'] = 1; 
                $data['v_add_by'] = $this->session->userdata('admin_id');
                $data['v_date'] = date('Y-m-d H:i:s');  
                
                $vehicleTypeId= $data['v_type_id'];
                $this->load->model('owner_models/Vehicle_type_model', 'vehicle_type_mdl');    
                $vehicleTypeData = $this->vehicle_type_mdl->get_vehicle_type_by_id($vehicleTypeId); 
                $result = $this->vehicle_mdl->update_vehicle($vehicle_id, $data); 
                
                
                //=============profile upload===============//
                $valid_extensions = array('jpeg','jpg','png','gif');
                if ($_FILES['rcfile']['error'] == 0) {
                    $img = $_FILES['rcfile']['name'];
                    $tmp = $_FILES['rcfile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                     if (in_array($ext, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleRcImage=$vehicle_id.'_rc_'.$name_replace_with_underscore.'.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/vehicle/rcpic/" . $vehicleRcImage;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['rcfile'] = $path;
                        }
                    }
                    if (file_exists($path)){
                    $dataUpdate['v_vehicle_rc']=$vehicleRcImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                    } 
                }
                if ($_FILES['vimagefile']['error'] == 0) {
                    $imgv = $_FILES['vimagefile']['name'];
                    $tmpv = $_FILES['vimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleImage=$vehicle_id.'_vimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleImage/" . $vehicleImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_vehicle_Image']=$vehicleImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                
                
                if ($_FILES['vfimagefile']['error'] == 0) {
                    $imgv = $_FILES['vfimagefile']['name'];
                    $tmpv = $_FILES['vfimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleFImage=$vehicle_id.'_vfimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleFront/" .$vehicleFImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vfimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_front_image']=$vehicleFImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                 if ($_FILES['vlimagefile']['error'] == 0) {
                    $imgv = $_FILES['vlimagefile']['name'];
                    $tmpv = $_FILES['vlimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehiclelImage=$vehicle_id.'_vlimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleLeft/" .$vehiclelImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vlimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_left_image']=$vehiclelImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                
                if ($_FILES['vrimagefile']['error'] == 0) {
                    $imgv = $_FILES['vrimagefile']['name'];
                    $tmpv = $_FILES['vrimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehiclerImage=$vehicle_id.'_vrimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleRight/" .$vehiclerImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vrimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_right_image']=$vehiclerImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                
                
                if ($_FILES['vbimagefile']['error'] == 0) {
                    $imgv = $_FILES['vbimagefile']['name'];
                    $tmpv = $_FILES['vbimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleBImage=$vehicle_id.'_vbimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleBack/" .$vehicleBImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['vbimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_back_image']=$vehicleBImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                
                if ($_FILES['veimagefile']['error'] == 0) {
                    $imgv = $_FILES['veimagefile']['name'];
                    $tmpv = $_FILES['veimagefile']['tmp_name'];
                    $extv = strtolower(pathinfo($imgv, PATHINFO_EXTENSION));
                     if (in_array($extv, $valid_extensions)) {
                        $Name=$vehicleTypeData['v_t_vehicle_name'];
                        $name_replace_with_underscore = str_replace(' ', '_', $Name);
                        $vehicleEImage=$vehicle_id.'_veimage_'.$name_replace_with_underscore.'.'.$extv;
                        if($imgv){
                            $pathv = "./assets/backend/img/vehicle/vehicleEngine/" .$vehicleEImage;
                        } else {
                            $pathv ='';
                        }
                        if (move_uploaded_file($tmpv, $pathv)){
                            $_POST['veimagefile'] = $pathv;
                        }
                    }
                     if (file_exists($pathv)){
                    $dataUpdate['v_engine_image']=$vehicleEImage;
                    $this->vehicle_mdl->update_vehicle($vehicle_id, $dataUpdate); 
                }
                }
                
                
                if (!empty($result)) { 
                    $sdata['success'] = 'Update successfully .'; 
                    $this->session->set_userdata($sdata); 
                    redirect('owner/vehicle', 'refresh'); 
                } else { 
                    $sdata['exception'] = 'Operation failed !'; 
                    $this->session->set_userdata($sdata); 
                    redirect('owner/vehicle', 'refresh'); 
                } 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/vehicle', 'refresh');
        } 
    } 

    public function remove_vehicle($vehicle_id) { 
        $vehicle_info = $this->vehicle_mdl->get_active_inactive_by_vehicle_id($vehicle_id); 
        if (!empty($vehicle_info)) { 
            $result = $this->vehicle_mdl->remove_vehicle_by_id($vehicle_id); 
            if (!empty($result)) { 
                $sdata['success'] = 'Remove successfully .'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                redirect('owner/vehicle', 'refresh'); 
            } 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/vehicles', 'refresh'); 
        } 
    } 
    
    public function view_vehicle($vehicle_id) { 
        $data = array(); 
        
        $data['vehicle_data'] = $this->vehicle_mdl->get_active_inactive_by_vehicle_id($vehicle_id);
//        echo '<pre>' ;print_r($data['vehicle_data']) ;die;
        if (!empty($data['vehicle_data'])) { 
            $data['title'] = 'View Vehicle'; 
            $data['active_menu'] = 'vehicle'; 
            $data['active_sub_menu'] = 'vehicle'; 
            $data['active_sub_sub_menu'] = ''; 
            $data['main_menu'] = $this->load->view('owner_views/main_menu_v', $data, TRUE);
            $data['main_content'] = $this->load->view('owner_views/vehicles/view_vehicle_v', $data, TRUE);
            $this->load->view('owner_views/admin_master_v', $data); 
        } else { 
            $sdata['exception'] = 'Content not found !'; 
            $this->session->set_userdata($sdata); 
            redirect('owner/vehicle', 'refresh'); 
        } 
    } 
      
}
?>