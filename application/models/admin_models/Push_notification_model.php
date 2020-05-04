<?php
class Push_notification_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    private $_push_notification = 'tbl_push_notification';  
    
    public function check_login_info() {
        $username_or_email_address = $this->input->post('username_or_email_address', true);
        $password = $this->input->post('password', true);
        $this->db->select('*')
                ->from('users')
                ->where("(Name = '$username_or_email_address' OR Email = '$username_or_email_address')")
                ->where('password', md5($password))
                ->where("(Role_Id = '1' OR Role_Id = '2')")
                ->where('Status', 1)
                ->where('deletion_status', 0)
                ->where('Role_Id <= ', 5);
        $query_result = $this->db->get();
//         echo  $this->db->last_query();die;
        $result = $query_result->row();
        return $result;

    }
 
    public function get_notificationSingleUser() { 
        $this->db->select('p.*,s.Name as senderName,r.Name as reciverName,ro.Title ') 
                ->from('tbl_push_notification p')
                ->join('users s', 'p.p_n_sender_id=s.Id','left')
                ->join('users r', 'p.p_n_receiver_id=r.Id','left')
                ->join('roles ro', 'r.Role_Id=ro.Id','left')
                ->where(array('p.p_n_one_or_all'=>'1'));
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['notificationID']=$row->p_n_id ;
                    $cat[$counter]['notificationMessage']=$row->p_n_message ;
                    $cat[$counter]['sendBy']=$row->senderName ;
                    $cat[$counter]['reciverBY']=$row->reciverName ;
                    $cat[$counter]['role']=$row->Title ;
                    $cat[$counter]['messageStatus']=$row->p_n_one_or_all ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
    
    public function get_notificationAllUser() { 
        $this->db->select('*') 
                ->from('tbl_push_notification p')
                ->join('roles ro', 'p.p_n_one_or_all=ro.Id','left')
                ->where('p.p_n_one_or_all != ', 'ONE_USER');
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['notificationID']=$row->p_n_id ;
                    $cat[$counter]['notificationMessage']=$row->p_n_message ;
                    $cat[$counter]['role']=$row->p_n_one_or_all ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
    
}
