<?php
class Rating_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    private $_rating = 'tbl_trip_rating';  
    
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
    
    
    public function get_driverRatingList() { 
        $this->db->select('*') 
               ->from("tbl_trip_rating r")
                ->join('tbl_trip t', 'r.t_r_trip_id=t.t_id','left')
                ->join('users u', 'r.t_r_user_id=u.Id','left')
                ;
                $this->db->where(array(
                    "r.t_r_status"=> 1,
                    "u.Role_Id"=> 3,
                    "r.t_r_delete"=> 0,
                    ));
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['ratingId']=$row->t_r_id ;
                    $cat[$counter]['tripCodeId']=$row->t_trip_id ;
                    $cat[$counter]['userName']=$row->Name ;
                    $cat[$counter]['comment']=$row->t_r_comment ;
                    $cat[$counter]['rate']=$row->t_r_rate ;
                    $cat[$counter]['dateTime']=$row->t_r_date ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
    
    public function get_customerRatingList() { 
        $this->db->select('*') 
               ->from("tbl_trip_rating r")
                ->join('tbl_trip t', 'r.t_r_trip_id=t.t_id','left')
                ->join('users u', 'r.t_r_user_id=u.Id','left')
                ;
                $this->db->where(array(
                    "r.t_r_status"=> 1,
                     "u.Role_Id"=> 4,
                    "r.t_r_delete"=> 0,
                    ));
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['ratingId']=$row->t_r_id ;
                    $cat[$counter]['tripCodeId']=$row->t_trip_id ;
                    $cat[$counter]['userName']=$row->Name ;
                    $cat[$counter]['comment']=$row->t_r_comment ;
                    $cat[$counter]['rate']=$row->t_r_rate ;
                    $cat[$counter]['dateTime']=$row->t_r_date ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
    
    
}
