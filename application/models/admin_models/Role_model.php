<?php
class Role_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    private $_role = 'roles';  
    
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
    
    
 
   
    public function get_roleList() { 
        $this->db->select('*') 
                ->from('roles r')
                ->where('r.Id > ', 1);
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['Id']=$row->Id ;
                    $cat[$counter]['Title']=$row->Title ;
                    if(($row->Status)==1){
                       $status = 'Active' ;
                    }else {
                         $status = 'Inactive' ;
                    }
                    $cat[$counter]['status']=$status ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
    
}
