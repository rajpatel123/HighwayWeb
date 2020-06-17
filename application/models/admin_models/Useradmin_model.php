<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Useradmin_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_users = 'users';  
    private $_fb_token = 'tbl_fb_token';  
    
    public function check_login_info() {
        $username_or_email_address = $this->input->post('username_or_email_address', true);
        $password = $this->input->post('password', true);
        $this->db->select('*')
                ->from('users')
                ->where("(Name = '$username_or_email_address' OR Email = '$username_or_email_address')")
                ->where('password', md5($password))
                 ->where('Role_Id = ', 1)
                ->where('Status', 1)
                ->where('deletion_status', 0);
        $query_result = $this->db->get();
//         echo  $this->db->last_query();die;
        $result = $query_result->row();
        return $result;

    }
    
    
     public function check_login_owner() {
        $username_or_email_address = $this->input->post('username_or_email_address', true);
        $password = $this->input->post('password', true);
        $this->db->select('*')
                ->from('users')
                ->where("(Name = '$username_or_email_address' OR Email = '$username_or_email_address')")
                ->where('password', md5($password))
                ->where('Status', 1)
                ->where('deletion_status', 0)
                ->where('Role_Id = ', 5);
        $query_result = $this->db->get();
//         echo  $this->db->last_query();die;
        $result = $query_result->row();
        return $result;

    }
    
    
    
    public function add_owner_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_users, $data); 
        
        return $this->db->insert_id(); 
    }  
	
    public function get_owner_info() { 
        $this->db->select('*') 
                ->from('users')
                ->where('Role_Id', 5)
                ->where('deletion_status', 0)
                ;
        $this->db->order_by('users.Id', 'DESC');
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 

    public function get_Owner_by_owner_id($owner_id) { 
        $result = $this->db->get_where($this->_users, array('Id' => $owner_id , 'deletion_status' => 0)); 
        return $result->row_array(); 
    } 

    public function published_owner_by_id($owner_id) { 
        $this->db->update($this->_users, array('Status' => 1), array('Id' => $owner_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_owner_by_id($owner_id) { 
        $this->db->update($this->_users, array('Status' => 0), array('Id' => $owner_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_owner($owner_id, $data) { 
        $this->db->update($this->_users, $data, array('Id' => $owner_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_owner_by_id($owner_id) { 
        $this->db->update($this->_users, array('deletion_status' => 1), array('Id' => $owner_id)); 
        $this->db->update($this->_fb_token, array('fb_status' => 0), array('fb_u_id' => $owner_id));  

        return $this->db->affected_rows(); 
    } 
    public function get_userList($roleId) { 
        $this->db->select('u.Id,u.Name,u.Status,r.Title') 
                ->from('users u')
                 ->join('roles r', 'r.Id=u.Role_Id','left')
                ->where('u.Role_Id =', $roleId);
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['Id']=$row->Id;
                    $cat[$counter]['Title']=$row->Title ;
                    $cat[$counter]['Name']=$row->Name ;
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

