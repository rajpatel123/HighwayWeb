<?php
class Book_trip_link_model extends CI_Model {
    
    public function addConfirmBookingApi($data) {
        $this->db->insert("tbl_book_trip_link", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function updateBookingStatusApi($data,$bookTripId) {
        $this->db->where(['b_l_t_trip_id'=>$bookTripId,'b_l_t_active_status'=>1]);
        $this->db->update("tbl_book_trip_link", $data);
        if ($bookTripId> 0) {
            return $bookTripId;
        } else {
            return false;
        }
    }
    
    public  function getBookTripDetailsApi($booking_trip_id,$user_id) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('users u', 'u.Id=b.b_l_t_customer_id','left')
                ->join('tbl_vehicle_type vt', 'vt.v_t_id=b.b_l_t_vehicle_type','left');
         //echo '<pre>' ;print_r($user_id);die;
         if(isset($booking_trip_id)>0){
             $this->db->where(array(
                    "b.b_l_t_trip_id" => $booking_trip_id,
                    "b.b_l_t_customer_id" => $user_id,
                    "b.b_l_t_active_status" => 1,
                    "b.b_l_t_delete" => 0,
                    ));
        }
              
         $query = $this->db->get();
        // echo  $this->db->last_query();die;
          
        
         if($query->num_rows() > 0){
                $data= $query->result();
                
                $cat = array();
               // echo '<pre>' ;print_r($data);die;
                foreach($data as $row){
                    $cat['bookingId']=$row->b_l_t_trip_id ;
                    $cat['bookingTripId']=$row->t_trip_id ;
                    $cat['customerName']=$row->Name ;
                    $cat['customerMobile']=$row->Mobile;
                    $cat['tripPickupLocation']=$row->t_source_address;
                    $cat['tripDropLocation']=$row->t_destination_address;
                    $cat['tripAddDate']=$row->t_add_date;
                    $cat['vehicleTypeId']=$row->v_t_id ;
                    $cat['vehicleName']=$row->v_t_vehicle_name ;
                    $cat['vehicleFare']=$row->v_t_fare;
                    
                    
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    
    public  function getBookTripDetailsByTripIdApi($bookTripId,$driverId) {
        
       // echo '<pre>'; print_r($driverId);die;
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_vehicle_type vt','b.b_l_t_vehicle_type=vt.v_t_id','left')
                ->join('vehicle v', 'v.v_type_id=vt.v_t_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_vehicle_id=v.v_Id','left')
                ->join('users u', 'u.Id=a.a_v_t_d_driver_id','left');
      //  $query = $this->db->get();
        //echo  $this->db->last_query();die;
                if(isset($bookTripId)>0){
                $this->db->where(array(
                    "b.b_l_t_trip_id"=>$bookTripId,
                    "b.b_l_t_active_status" =>1,
                    "a.a_v_t_d_driver_id" =>$driverId,
                    "a.a_v_t_d_status" =>1,
                    "ab.a_b_t_status" =>1,
                    ));
                }
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['tripId']=$row->b_l_t_trip_id;
                    $cat['trip_status']=$row->b_l_t_trip_status;
                    $cat['bookingTripCode']=$row->t_trip_id ;
                    $cat['otp']=$row->a_b_t_otp;
                    $cat['customerId']=$row->b_l_t_customer_id;
                    $cat['driverId']=$row->a_v_t_d_driver_id;
                    $cat['driverName']=$row->Name;
                    $cat['driverImage']=$row->Image;
                    $cat['DrivrRating']=3;
                    $cat['DrivrTripCount']=1;
                    $cat['driverMobile']=$row->Mobile;
                    $cat['vehicleId']=$row->v_Id ;
                    $cat['vehicleTypeId']=$row->v_t_id ;
                    $cat['vehicleType']=$row->v_t_vehicle_name ;
                    $cat['vehicleName']= ucwords($row->v_vehicle_name).' '.$row->v_vehicle_number;
                    $cat['vehicleNumber']=$row->v_vehicle_number ;
                    $cat['vehicleImage']='' ;
                    $cat['tripAcceptStatus']=$row->a_b_t_accept_status;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    
    
     public  function getBookTripCustomerDetailsByTripIdApi($bookTripId,$driverId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('users ua', 'ua.Id=b.b_l_t_customer_id','left');
      //  $query = $this->db->get();
        //echo  $this->db->last_query();die;
                if(isset($bookTripId)>0){
                $this->db->where(array(
                    "b.b_l_t_trip_id"=>$bookTripId,
                    "b.b_l_t_active_status" =>1,
                    
                    ));
                }
        $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['customerId']=$row->b_l_t_customer_id;
                    $cat['customerName']=$row->Name;
                    $cat['customerMobile']=$row->Mobile;
                    $cat['tripAcceptStatus']=$row->a_b_t_accept_status;
                    $cat['startTripLat']=$row->t_start_latitude;;
                    $cat['startTripLong']=$row->t_start_longitude;;
                    $cat['endTripLat']=$row->t_end_latitude;;
                    $cat['endTripLong']=$row->t_end_longitude;;
                    $cat['bookingTripId']=$row->t_trip_id;
                    $cat['tripId']=$row->b_l_t_trip_id;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    
    
    public function getBookTripDataById($bookTripId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link");
                if(isset($bookTripId)>0){
                $this->db->where(array("tbl_book_trip_link.b_l_t_trip_id" => $bookTripId, "tbl_book_trip_link.b_l_t_active_status"=> 1));
                }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
   
    public function getBookTripDataByTripId($bookTripId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t','b.b_l_t_trip_id=t.t_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left');
                if(isset($bookTripId)>0){
                $this->db->where(array("b.b_l_t_trip_id" => $bookTripId, "b.b_l_t_active_status"=> 1));
                }
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
    }
    
     public  function getCustomerStatus($userId) {
         if(($userId)>0){
         $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('users u', 'b.b_l_t_driver_id=u.id','left')
                ->join('tbl_trip t','b.b_l_t_trip_id=t.t_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('tbl_vehicle_type vt','b.b_l_t_vehicle_type=vt.v_t_id','left')
                ->join('vehicle v', 'v.v_Id=b.b_l_t_vehicle_id','left');
        $this->db->where([
          'b.b_l_t_customer_id'=>$userId,
          'u.Status'=>1,
          'u.deletion_status'=>0,
          'b.b_l_t_active_status'=>1,
          ]);
         }
         $this->db->order_by("b_l_t_trip_id", "DESC");
         $this->db->limit(1);
        $query = $this->db->get();
      // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat  = array();
                $customerData= $query->result();
                foreach($data as $row){
                     if($row->a_b_t_driver_id>0){
                    $cat['id']=$row->Id;
                    $cat['Name']=$row->Name;
                    $cat['email']=$row->Email;
                    if($row->Gender==1){
                        $cat['gender']="Male";
                    } 
                    if($row->Gender==2){
                        $cat['gender']="Female";
                    } 
                    $cat['mobile']=$row->Mobile;
                    $cat['created_at']=$row->created_on;
                    $cat['emergency_contact1']=$row->emergency_contact1;
                    $cat['emergency_contact2']=$row->emergency_contact2;
                    $cat['bookingTripId']=$row->b_l_t_trip_id;
                    $cat['bookingTripCode']=$row->t_trip_id;
                    if($row->b_l_t_status==1){
                        $cat['bookingTripStatus']='Upcomming';
                    }
                    if($row->b_l_t_status==2){
                        $cat['bookingTripStatus']='Ongoing';
                    }
                    if($row->b_l_t_status==3){
                        $cat['bookingTripStatus']='Completed';
                    }
                    if($row->b_l_t_status==4){
                        $cat['bookingTripStatus']='Cancel';
                    }
                    if($row->b_l_t_status==0){
                         $cat['bookingTripStatus']='New Trip';
                    }
                    $cat['currentTripStatus']=$row->a_b_t_accept_status;
                    $cat['ratingStatus']=$row->b_l_t_rating_status;
                    $cat['sourceLat']=$row->t_start_latitude;
                    $cat['sourceLong']=$row->t_start_longitude;
                    $cat['dropLat']=$row->t_end_latitude;
                    $cat['dropLong']=$row->t_end_longitude;
                    $cat['sourceAddress']=$row->t_source_address;
                    $cat['destinationAddress']=$row->t_destination_address;
                    $cat['otp']=$row->a_b_t_otp;
                    $cat['vehicleType']=$row->v_t_vehicle_name;
                    $cat['vehicleNumber']=$row->v_vehicle_number;
                   
                    }
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    
     public  function getDriverStatus($userId) {
         if(($userId)>0){
         $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('users u', 'b.b_l_t_customer_id=u.id','left')
                ->join('tbl_trip t','b.b_l_t_trip_id=t.t_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('tbl_vehicle_type vt','b.b_l_t_vehicle_type=vt.v_t_id','left')
                ->join('vehicle v', 'v.v_Id=b.b_l_t_vehicle_id','left');
                
        $this->db->where([
        'b.b_l_t_driver_id'=>$userId,
          'u.Status'=>1,
          'u.deletion_status'=>0,
          'b.b_l_t_active_status'=>1,
          ]);
         }
         $this->db->order_by("b_l_t_trip_id", "DESC");
         $this->db->limit(1);
        $query = $this->db->get();
       /// echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat  = array();
                $customerData= $query->result();
                foreach($data as $row){
                if($row->a_b_t_driver_id>0){
                    $cat['id']=$row->Id;
                    $cat['Name']=$row->Name;
                    $cat['email']=$row->Email;
                    if($row->Gender==1){
                        $cat['gender']="Male";
                    } 
                    if($row->Gender==2){
                        $cat['gender']="Female";
                    } 
                    $cat['mobile']=$row->Mobile;
                    $cat['created_at']=$row->created_on;
                    $cat['emergency_contact1']=$row->emergency_contact1;
                    $cat['emergency_contact2']=$row->emergency_contact2;
                    $cat['bookingTripId']=$row->b_l_t_trip_id;
                    $cat['bookingTripCode']=$row->t_trip_id;
                    if($row->b_l_t_status==1){
                        $cat['bookingTripStatus']='Upcomming';
                    }
                    if($row->b_l_t_status==2){
                        $cat['bookingTripStatus']='Ongoing';
                    }
                    if($row->b_l_t_status==3){
                        $cat['bookingTripStatus']='Completed';
                    }
                    if($row->b_l_t_status==4){
                        $cat['bookingTripStatus']='Cancel';
                    }
                    if($row->b_l_t_status==0){
                         $cat['bookingTripStatus']='New Trip';
                    }
                    $cat['currentTripStatus']=$row->a_b_t_accept_status;
                    $cat['ratingStatus']=$row->b_l_t_rating_status;
                    $cat['sourceLat']=$row->t_start_latitude;
                    $cat['sourceLong']=$row->t_start_longitude;
                    $cat['dropLat']=$row->t_end_latitude;
                    $cat['dropLong']=$row->t_end_longitude;
                    $cat['sourceAddress']=$row->t_source_address;
                    $cat['destinationAddress']=$row->t_destination_address;
                    $cat['otp']=$row->a_b_t_otp;
                    $cat['vehicleType']=$row->v_t_vehicle_name;
                    $cat['vehicleNumber']=$row->v_vehicle_number;
                    
                   
                    }
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    public  function getDriverInvoiceData($tripId,$driverId,$distanceData,$totalTime) {
       // print_r($tripId);die;
        if(isset($tripId)>0){
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('users u', 'u.Id=b.b_l_t_driver_id','left')
                ->join('tbl_vehicle_type v', 'v.v_t_Id=b.b_l_t_vehicle_type','left');
         //echo '<pre>' ;print_r($driverId);die;
         $this->db->where(array(
                    "b.b_l_t_trip_id" => $tripId,
                    "b.b_l_t_driver_id" => $driverId,
                    "b.b_l_t_active_status" => 1,
                    "b.b_l_t_delete" => 0,
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
                    $cat['bookingId']=$row->b_l_t_trip_id ;
                    $cat['bookingTripCode']=$row->t_trip_id ;
                    $cat['startDate']=$row->a_b_t_start_date;
                    $cat['endDate']=$row->a_b_t_end_date ;
                    $cat['startTime']=$row->a_b_t_start_time;
                    $cat['endTime']=$row->a_b_t_end_time ;
                    $cat['totDistance']=$distanceData;
                     $cat['travelTime']=$totalTime;
                    $cat['basedFarefixed']=$row->v_t_fare;
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
    
     public  function getCustomerInvoiceData($tripId,$customerId,$distanceData,$totalTime) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_accept_booking_trip ab', 'ab.a_b_t_booking_trip_id=b.b_l_t_trip_id','left')
                ->join('users u', 'u.Id=b.b_l_t_customer_id','left')
                ->join('tbl_vehicle_type v', 'v.v_t_Id=b.b_l_t_vehicle_type','left');
         //echo '<pre>' ;print_r($driverId);die;
         if(isset($tripId)>0){
             $this->db->where(array(
                    "b.b_l_t_trip_id" => $tripId,
                    "b.b_l_t_customer_id" => $customerId,
                    "b.b_l_t_active_status" => 1,
                    "b.b_l_t_delete" => 0,
                    ));
        }
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $distancePrice = $row->v_t_per_km_charge*$distanceData;
                    $gstPrise = $row->v_t_gst*$distancePrice/100;
                    $totalAmount=$distancePrice+$gstPrise;
                    
                    $cat['bookingId']=$row->b_l_t_trip_id ;
                    $cat['bookingTripCode']=$row->t_trip_id ;
                    $cat['startDate']=$row->a_b_t_start_date;
                    $cat['endDate']=$row->a_b_t_end_date ;
                    $cat['startTime']=$row->a_b_t_start_time;
                    $cat['endTime']=$row->a_b_t_end_time;
                    $cat['totDistance']=$distanceData;
                    $cat['travelTime']=$totalTime;
                    $cat['basedFarefixed']=$row->v_t_fare;
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
    
     public function getViewTripDataById($bookTripId,$driverId) {
       
        if((isset($bookTripId)>0) && (isset($driverId)>0)){
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('users u', 'u.Id=b.b_l_t_customer_id','left');
               
                $this->db->where(array(
                    "b.b_l_t_trip_id" => $bookTripId,
                    "b.b_l_t_driver_id" => $driverId,
                    "b.b_l_t_active_status"=> 1,
                    "u.deletion_status"=> 0
                    ));
                }
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    
    public function getCustomerTripDataByID($bookTripId,$userId) {
       if(isset($bookTripId)>0){
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b");
                $this->db->where(array(
                    "b.b_l_t_trip_id" => $bookTripId,
                    "b.b_l_t_customer_id" => $userId,
                    "b.b_l_t_active_status"=> 1,
                    ));
                }
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
   
    
}
