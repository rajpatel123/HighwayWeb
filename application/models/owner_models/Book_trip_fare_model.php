<?php
class Book_trip_fare_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    private $_book_trip_fare = 'tbl_book_trip_fare';  
    
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
 
    public function get_payment_history() { 
        $this->db->select('f.*,t.t_trip_id,b.b_l_t_trip_id,c.Name as customerName,d.Name as driverName') 
                ->from('tbl_book_trip_fare f')
                ->join('tbl_book_trip_link b', 'f.b_t_f_trip_id=b.b_l_t_trip_id','left')
                ->join('tbl_trip t', 'f.b_t_f_trip_id=t.t_id','left')
                ->join('users c', 'f.b_t_f_user_id=c.Id','left')
                ->join('users d', 'b.b_l_t_driver_id=d.Id','left')
                ->where(array('f.b_t_f_delete'=>0));
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat[$counter]['bookingId']=$row->b_l_t_trip_id ;
                    $cat[$counter]['bookingTripCode']=$row->t_trip_id ;
                    $cat[$counter]['customerName']=$row->customerName ;
                    $cat[$counter]['driverName']=$row->driverName ;
                    $cat[$counter]['totalFare']=$row->b_t_f_fare ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
    
}
