<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Trip_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_trip = 'tbl_trip';  
    
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
    public function get_trip_info() { 
           $this->db->select('t.*,b.*,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_vehicle_name,o.Name as ownerName') 
               ->from('tbl_book_trip_link b ')
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')   
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('t.t_delete'=>0,'b.b_l_t_delete'=>0));
                $this->db->order_by("t.t_id", "DESC");
                $this->db->limit(20);
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['t_id']=$row->t_id;
                    $tripData[$counter]['t_trip_id']=$row->t_trip_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_active_status']=$row->b_l_t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    $tripData[$counter]['b_l_t_status']=$row->b_l_t_status;
                    if($row->b_l_t_status==1){
                        $tripData[$counter]['tripStatus']='UPCOMING';
                    }
                    if($row->b_l_t_status==2){
                        $tripData[$counter]['tripStatus']='ONGOING';
                    }
                    if($row->b_l_t_status==3){
                        $tripData[$counter]['tripStatus']='COMPLETED';
                    }
                    if($row->b_l_t_status==4){
                        $tripData[$counter]['tripStatus']='CANCEL';
                    }
                    if($row->t_type==1){
                        $tripData[$counter]['tripType']='Personal Trip';
                        
                    }
                    if($row->t_type==2){
                        $tripData[$counter]['tripType']='Business Trip';
                    }
                    
                    if($row->customer_role_id==4){
                      $tripData[$counter]['userName']=$row->customerName;  
                      $tripData[$counter]['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData[$counter]['userName']=$row->customerName; 
                       $tripData[$counter]['userRole']='Milluser';
                    }
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }
    
    public function get_trip_data_by_id($trip_id) { 
          $this->db->select('t.*,a.*,b.*,c.Name as customerName,c.Mobile as customerMobile,c.Role_Id as customer_role_id,d.Name as driverName,d.Mobile as driverMobile,o.Name as ownerName,o.Mobile as ownerMobile,vt.*,v.*,ds.*,lc.*') 
               ->from('tbl_book_trip_link b ')
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_accept_booking_trip a', 'a.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')   
               ->join('tbl_vehicle_dimension_size ds','ds.v_d_s_id=vt.v_t_vehicle_size_id','left') 
               ->join('tbl_vehicle_load_capacity lc','lc.v_l_c_id=vt.v_t_vehicle_load_capacity_id','left') 
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left') 
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=b.b_l_t_customer_id','left')
                ->where(array('b.b_l_t_trip_id' => $trip_id ,'b.b_l_t_delete'=>0))
                ;
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $tripData=array();
                foreach($data as $row){
                    $tripData['t_id']=$row->t_id;
                    $tripData['t_trip_id']=$row->t_trip_id;
                    $tripData['t_user_Id']=$row->t_user_Id;
                    $tripData['t_active_status']=$row->b_l_t_active_status;
                    $tripData['t_add_date']=$row->t_add_date;
                    $tripData['t_start_date']=$row->t_start_date;
                    $tripData['t_end_date']=$row->t_end_date;
                    $tripData['t_start_time']=$row->t_start_time;
                    $tripData['t_end_time']=$row->t_end_time;
                    $tripData['t_start_latitude']=$row->t_start_latitude;
                    $tripData['t_start_longitude']=$row->t_start_longitude;
                    $tripData['t_end_latitude']=$row->t_end_latitude;
                    $tripData['t_end_longitude']=$row->t_end_longitude;
                    $tripData['t_start_latitude']=$row->t_start_latitude;
                    
                    $startlat=$row->t_start_latitude;
                    $startLong=$row->t_start_longitude;
                    $endlat=$row->t_end_latitude;
                    $endLong=$row->t_end_longitude;
                    $unit = "K";  // K = kilometer
                    $distanceData=$this->distance($startlat,$startLong,$endlat,$endLong,$unit);
                    
                    
                    $tripData['distance']=$distanceData;
                    $tripData['basePrice']=$distanceData*$row->v_t_per_km_charge;
                    $tripData['vehicleType']=$row->v_t_type;
                    $tripData['a_b_t_accept_status']=$row->a_b_t_accept_status;
                    $tripData['vehicle_dimension_size']=$row->v_d_s_dimension_size;
                    $tripData['vehicle_load_capacity']=$row->v_l_c_load_capacity;
                    $tripData['pickupAddress']=$row->t_source_address;
                    $tripData['dropAddress']=$row->t_destination_address;
                    if($row->v_type){
                        $tripData['vehicleName']=$row->v_type.' '.$row->v_vehicle_number;
                    } else {
                        $tripData['vehicleName']='';   
                    }
                    if($row->t_status==1){
                        $tripData['tripStatus']='Upcoming';
                    }
                    if($row->t_status==2){
                        $tripData['tripStatus']='Ongoing';
                    }
                    if($row->t_status==3){
                        $tripData['tripStatus']='Completed';
                    }
                    if($row->t_status==4){
                        $tripData['tripStatus']='Cancel';
                    }
                    if($row->t_type==1){
                        $tripData['tripType']='Personal Trip';
                        
                    }
                    if($row->t_type==2){
                        $tripData['tripType']='Business Trip';
                    }
                    
                    if($row->customer_role_id==4){
                      $tripData['userName']=$row->customerName; 
                      $tripData['customerMobile']=$row->customerMobile; 
                      $tripData['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData['userName']=$row->customerName;
                       $tripData['customerMobile']=$row->customerMobile; 
                       $tripData['userRole']='Milluser';
                    }
                    
                    $tripData['driverName']=$row->driverName;
                    $tripData['driverMobile']=$row->driverMobile;
                    $tripData['ownerName']=$row->ownerName;
                    $tripData['ownerMobile']=$row->ownerMobile;
                   
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    } 
    public function get_trip_view_data() { 
           $this->db->select('t.*,b.*,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,o.Name as ownerName,vt.*,v.*') 
               ->from('tbl_book_trip_link b ')
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')   
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left')   
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('t.t_delete'=>0,'t.t_delete'=>0));
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['t_id']=$row->t_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_active_status']=$row->b_l_t_active_status;;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['t_start_time']=$row->t_start_time;
                    $tripData[$counter]['t_end_time']=$row->t_end_time;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_type.' '.$row->v_vehicle_number;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->b_l_t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->b_l_t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->b_l_t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->b_l_t_status==4){
                        $tripData[$counter]['tripStatus']='Cancel';
                    }
                    if($row->t_type==1){
                        $tripData[$counter]['tripType']='Personal Trip';
                        
                    }
                    if($row->t_type==2){
                        $tripData[$counter]['tripType']='Business Trip';
                    }
                    
                    if($row->customer_role_id==4){
                      $tripData[$counter]['userName']=$row->customerName;  
                      $tripData[$counter]['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData[$counter]['userName']=$row->customerName; 
                       $tripData[$counter]['userRole']='Milluser';
                    }
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }
    public function get_trip_data_by_status($tstatus) { 
            $this->db->select('t.*,b.*,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,o.Name as ownerName,vt.*,v.*') 
               ->from('tbl_book_trip_link b ')
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')   
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('b.b_l_t_delete'=>0));
            if (isset($tstatus) && !empty($tstatus)) {
                    $this->db->where("b.b_l_t_status", $tstatus);
                }
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['t_id']=$row->t_id;
                    $tripData[$counter]['t_trip_id']=$row->t_trip_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_active_status']=$row->b_l_t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['t_start_time']=$row->t_start_time;
                    $tripData[$counter]['t_end_time']=$row->t_end_time;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name.' '.$row->v_vehicle_number;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->b_l_t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->b_l_t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->b_l_t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->b_l_t_status==4){
                        $tripData[$counter]['tripStatus']='Cancel';
                    }
                    if($row->t_type==1){
                        $tripData[$counter]['tripType']='Personal Trip';
                        
                    }
                    if($row->t_type==2){
                        $tripData[$counter]['tripType']='Business Trip';
                    }
                    
                    if($row->customer_role_id==4){
                      $tripData[$counter]['userName']=$row->customerName;  
                      $tripData[$counter]['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData[$counter]['userName']=$row->customerName; 
                       $tripData[$counter]['userRole']='Milluser';
                    }
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }
    
    public function getAllTripData() { 
            $this->db->select('t.*,b.*,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_vehicle_name,o.Name as ownerName') 
                 ->from('tbl_book_trip_link b ')
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')   
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('t.t_delete'=>0));
                $this->db->order_by("t.t_id", "DESC");
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['t_id']=$row->t_id;
                    $tripData[$counter]['t_trip_id']=$row->t_trip_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_active_status']=$row->b_l_t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->b_l_t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->b_l_t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->b_l_t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->b_l_t_status==4){
                        $tripData[$counter]['tripStatus']='Cancel';
                    }
                    if($row->t_type==1){
                        $tripData[$counter]['tripType']='Personal Trip';
                        
                    }
                    if($row->t_type==2){
                        $tripData[$counter]['tripType']='Business Trip';
                    }
                    
                    if($row->customer_role_id==4){
                      $tripData[$counter]['userName']=$row->customerName;  
                      $tripData[$counter]['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData[$counter]['userName']=$row->customerName; 
                       $tripData[$counter]['userRole']='Milluser';
                    }
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }

    public function get_Trip_by_trip_id($trip_id) { 
        $result = $this->db->get_where($this->_trip, array('t_id' => $trip_id , 't_delete' => 0)); 
        return $result->row_array(); 
    } 

    public function active_trip_by_id($trip_id) { 
        $this->db->update($this->_trip, array('t_active_status' => 1), array('t_id' => $trip_id));  
        return $this->db->affected_rows(); 
    } 

    public function inactive_trip_by_id($trip_id) { 
        $this->db->update($this->_trip, array('t_active_status' => 0), array('t_id' => $trip_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_trip($trip_id, $data) { 
        $this->db->update($this->_trip, $data, array('t_id' => $trip_id)); 
        return $this->db->affected_rows(); 
    } 
     public function remove_trip_by_id($trip_id) { 
        $this->db->update($this->_trip, array('t_delete' => 1), array('t_id' => $trip_id)); 
        return $this->db->affected_rows(); 
    } 
    public function getAllTripRequestHistory() {  //======All Requests from all customers with paginatin which not accepted or cancelled by driver==========//
            $this->db->select('t.*,b.*,a.*,c.Name as customerName,c.Role_Id as customer_role_id,vt.v_t_vehicle_name,o.Name as ownerName, d.Name as driverName,') 
                ->from('tbl_book_trip_link b ')
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_accept_booking_trip a', 'a.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')    
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')    
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=b.b_l_t_customer_id','left')
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left')
                ->where(array('b.b_l_t_delete'=>0));
                $this->db->order_by("b.b_l_t_id", "DESC");
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['t_id']=$row->t_id;
                    $tripData[$counter]['t_trip_id']=$row->t_trip_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_active_status']=$row->b_l_t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->driverName){
                    $tripData[$counter]['driverName']=$row->driverName;
                    } else {
                    $tripData[$counter]['driverName']='N/A';    
                    }
                    if($row->a_b_t_accept_status){
                    $tripData[$counter]['trip_accept_status']=$row->a_b_t_accept_status;
                    } else {
                    $tripData[$counter]['trip_accept_status']='N/A';  
                    }
                    if($row->b_l_t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->b_l_t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->b_l_t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->b_l_t_status==4){
                        $tripData[$counter]['tripStatus']='Cancel';
                    }
                    if($row->t_type==1){
                        $tripData[$counter]['tripType']='Personal Trip';
                        
                    }
                    if($row->t_type==2){
                        $tripData[$counter]['tripType']='Business Trip';
                    }
                    
                    if($row->customer_role_id==4){
                      $tripData[$counter]['userName']=$row->customerName;  
                      $tripData[$counter]['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData[$counter]['userName']=$row->customerName; 
                       $tripData[$counter]['userRole']='Milluser';
                    }
                    
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }
    
    
    public function getAllTripDataAcceptOrRejectByDriver() {  
            $this->db->select('a.a_b_t_booking_trip_id,a.a_b_t_driver_id') 
                ->from('tbl_accept_booking_trip a ')
                    ->where(array('a.a_b_t_delete'=>0));
        $query = $this->db->get(); 
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['acceptTripId']=$row->a_b_t_booking_trip_id;
                    $tripData[$counter]['acceptTripDriverId']=$row->a_b_t_driver_id;
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }
    
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
              if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                return 0;
              }
              else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);
                $miles_in_k = round($miles * 1.609344);
                $miles_in_N = round($miles * 0.8684);
                

                if ($unit == "K") {
                  return ($miles_in_k);
                } else if ($unit == "N") {
                  return ($miles_in_N);
                } else {
                  return $miles_in_N;
                }
              }
            }
            
            
            
    public  function getPriceDetailByDistance($tripId,$driverId,$distanceData,$totalTime) {
       // print_r($tripId);die;
        if(isset($tripId)>0){
        $this->db->select(array("*"))
                ->from("tbl_vehicle_type vt");
         $this->db->where(array(
                    "vt.v_t_delete" => 0,
                    ));
        }
              
         $query = $this->db->get();
        // echo  $this->db->last_query();die;
          
        
         if($query->num_rows() > 0){
                $data= $query->result();
                
                $cat = array();
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                     $distancePrice = $row->v_t_per_km_charge*$distanceData;
                    $gstPrise = $row->v_t_gst*$distancePrice/100;
                    $totalAmount=$distancePrice+$gstPrise;
                    $cat['totDistance']=$distanceData;
                    $cat['travelTime']=$totalTime;
                    $cat['basedFarefixed']=$distancePrice;
                    $cat['distancePrice']=$distancePrice ;
                    $cat['peekHourCharges']=$row->v_t_per_km_charge;
                    $cat['nightFare']=$row->v_t_nigh_charge_per_km;
                    $cat['tax']=$row->v_t_gst;
                    $cat['totalAmount']=$totalAmount;
                    $cat['walletDetection']=$totalAmount;
                    $cat['discount']='';
                    $cat['paymentMode']='paytm';
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
}


