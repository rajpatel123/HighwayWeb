<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
class Notification extends CI_Controller {  

    public function __construct() {
        parent::__construct(); 
        if ($this->session->userdata('logged_info') == FALSE) {
            redirect('admin', 'refresh');
        }
        $this->load->model('admin_models/Push_notification_model','push_notification_mdl'); 
        $this->load->model('admin_models/Role_model','role_mdl'); 
        $this->load->model('admin_models/Useradmin_model','useradmin_mdl');
        
    } 
    
     public function index(){
        $data = array();
        $data['title'] = 'Role';
        $data['active_menu'] = 'Role';
        $data['active_sub_menu'] = 'Role';
        $data['active_sub_sub_menu'] = ''; 
        $data['role_info'] = $this->role_mdl->get_roleList();
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/notification/manage_role', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
   
    
     public function send_notification_role($roleId){  
        $data = array();
        $data['title'] = 'Notification Message By Role';
        $data['roleId'] = $roleId;
        $data['active_menu'] = 'Notification Message By Role';
        $data['active_sub_menu'] = 'Notification Message By Role';
        $data['active_sub_sub_menu'] = ''; 
//        $data['single_user'] = $this->push_notification_mdl->get_notificationSingleUser($roleId);
        $data['all_user'] = $this->push_notification_mdl->get_notificationAllUser($roleId);
        //echo '<pre>' ;print_r($data['all_user']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/notification/send_notification_role', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
   
    public function create_notification($roleId) {
        $config = array(
            array(
                'field' => 'p_n_message',
                'label' => 'p_n_message',
                'rules' => 'trim|required|max_length[250]'
            )
          
           
            );
        $this->load->library('upload', $config);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->index();
            } else {
            $data['p_n_message'] = $this->input->post('p_n_message', TRUE); 
            $data['p_n_sender_id'] = $this->session->userdata['admin_id'];
            if(($roleId>1) && ($roleId<6)){
                $role = $roleId;
            } else {
                $role=0;
            }
            $data['p_n_one_or_all'] = $role ;
            $data['p_n_image'] ='';
            $insert_id = $this->push_notification_mdl->add_notification_data($data); 
           
            
            $valid_extensions = array('jpeg','jpg','png','gif');
            //echo '<pre>' ; print_r($valid_extensions);die;
                if ($_FILES['notificationFile']['error'] == 0) {
                    $img = $_FILES['notificationFile']['name'];
                    $tmp = $_FILES['notificationFile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                    
                     if (in_array($ext, $valid_extensions)) {
                        $profilePic=$insert_id.'_notification.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/notification/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['notificationFile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['p_n_image']=$profilePic;
                    $this->push_notification_mdl->update_notification_data($insert_id, $dataUpdate); 
                    }
                }
                
                
                
                
                  //==================push notification acording to role====================// 
                
    if($roleId){        
        $this->load->model("mobile_token_model");
        $mobileTokenData = $this->mobile_token_model->getAllUserTokenByRoleId($roleId); 
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
$fields = array
(
    'registration_ids' => $mobileTokenData,
    'priority' => 'high',
    'notification' => array(
        'title' => 'Notification',
        'body' => $this->input->post('p_n_message', TRUE)
    )
);
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );
}
                
                
            
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/notification/send_notification_role/'.$role.'', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                    redirect('admin/notification', 'refresh'); 
            } 
        } 
    }
     public function send_notification_user($userId){
        $data = array();
        $data['title'] = 'Notification Message By User';
        $data['userId'] = $userId;
        $data['active_menu'] = 'Notification Message By User';
        $data['active_sub_menu'] = 'Notification Message By User';
        $data['active_sub_sub_menu'] = ''; 
        $data['single_user'] = $this->push_notification_mdl->get_notificationSingleUser($userId);
        //echo '<pre>' ;print_r($data['fare_info']);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/notification/send_notification_user', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
     public function create_notification_user($userId) {
        $config = array(
            array(
                'field' => 'p_n_message',
                'label' => 'p_n_message',
                'rules' => 'trim|required|max_length[250]'
            )
          
           
            );
        $this->load->library('upload', $config);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->index();
            } else {
            $data['p_n_message'] = $this->input->post('p_n_message', TRUE); 
            $data['p_n_sender_id'] = $this->session->userdata['admin_id'];
            $data['p_n_receiver_id'] = $userId; 
            $data['p_n_one_or_all'] = 1;
            $data['p_n_image'] ='';
            $insert_id = $this->push_notification_mdl->add_notification_data($data); 
           
            
            $valid_extensions = array('jpeg','jpg','png','gif');
            //echo '<pre>' ; print_r($valid_extensions);die;
                if ($_FILES['notificationFile']['error'] == 0) {
                    $img = $_FILES['notificationFile']['name'];
                    $tmp = $_FILES['notificationFile']['tmp_name'];
                    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                    
                     if (in_array($ext, $valid_extensions)) {
                        $profilePic=$insert_id.'_notification.'.$ext;
                        if($img){
                            $path = "./assets/backend/img/notification/" .$profilePic;
                        } else {
                            $path ='';
                        }
                        if (move_uploaded_file($tmp, $path)){
                            $_POST['notificationFile'] = $path;
                        }
                    }
                    if (file_exists($path)) {
                    $dataUpdate['p_n_image']=$profilePic;
                    $this->push_notification_mdl->update_notification_data($insert_id, $dataUpdate); 
                    }
                }
                
                
                
                //==================push notification Single User====================// 
                
    if($userId){        
        $this->load->model("mobile_token_model");
        $mobileTokenData = $this->mobile_token_model->getUserTokenById($userId); 
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
$fields = array
(
    'registration_ids' => $mobileTokenData,
    'priority' => 'high',
    'notification' => array(
        'title' => 'Notification',
        'body' => $this->input->post('p_n_message', TRUE)
    )
);
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );
}
            
            if (!empty($insert_id)) { 
                $sdata['success'] = 'Add successfully . '; 
                $this->session->set_userdata($sdata); 
                redirect('admin/notification/send_notification_user/'.$userId.'', 'refresh'); 
            } else { 
                $sdata['exception'] = 'Operation failed !'; 
                $this->session->set_userdata($sdata); 
                     redirect('admin/notification/send_notification_user/'.$userId.'', 'refresh');  
            } 
        } 
    }
    
     public function manage_user($roleId){
        $data = array();
        $data['title'] = 'Users';
        $data['active_menu'] = 'Users';
        $data['active_sub_menu'] = 'Users';
        $data['active_sub_sub_menu'] = 'Users'; 
        $data['user_info'] = $this->useradmin_mdl->get_userList($roleId);
        //echo '<pre>' ;print_r($data);die;
        $data['main_menu'] = $this->load->view('admin_views/main_menu_v', $data, TRUE);
        $data['main_content'] = $this->load->view('admin_views/notification/manage_user', $data, TRUE);
        $this->load->view('admin_views/admin_master_v', $data);
    } 
    
    
    
}
?>