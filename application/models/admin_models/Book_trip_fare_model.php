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
        $this->db->select('b.*,t.*,v.*,vt.*,t.t_trip_id,b.b_l_t_trip_id,c.Name as customerName,d.Name as driverName') 
                ->from('tbl_book_trip_link b')
                ->join('tbl_trip t', 'b.b_l_t_trip_id=t.t_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')
                ->join('users c', 'b.b_l_t_customer_id=c.Id','left')
                ->join('users d', 'b.b_l_t_driver_id=d.Id','left')
                ->where(array('b.b_l_t_delete'=>0));
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter =0;
              $this->load->model('admin_models/Trip_model','trip_mdl'); 
                foreach($data as $row){
                    $cat[$counter]['bookingId']=$row->b_l_t_trip_id ;
                    $cat[$counter]['bookingTripCode']=$row->t_trip_id ;
                    $cat[$counter]['customerName']=$row->customerName ;
                    $cat[$counter]['driverName']=$row->driverName ;
                    $cat[$counter]['totalFare']=$row->driverName ;
                    
                    
                    $vehicleTypeId=$row->v_t_id;
                    $startlat=$row->t_start_latitude;
                    $startLong=$row->t_start_longitude;
                    $endlat=$row->t_end_latitude;
                    $endLong=$row->t_end_longitude;
                    $unit = "K";  // K = kilometer
//                      echo '<pre>' ;print_r($startLong);die;
                    $distance_all_Data=$this->trip_mdl->getPriceDetailByDistance($startlat,$startLong,$endlat,$endLong,$unit,$vehicleTypeId);
                    
                    //echo '<pre>' ;print_r($distance_all_Data);die;
                    
                    $cat[$counter]['distance']=$distance_all_Data['totDistance'];
                    $cat[$counter]['basedPrice']=$distance_all_Data['basedFarefixed'];
                    $cat[$counter]['basePrice']=$distance_all_Data['totDistance']*$row->v_t_per_km_charge;
                    $cat[$counter]['v_t_gst']=$row->v_t_gst;
                    $cat[$counter]['gstAmount']=$distance_all_Data['gstAmount'];
                    $cat[$counter]['totalFare']=$distance_all_Data['totalAmount'];
                    
                    
                    
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    
    } 
     
    
}
