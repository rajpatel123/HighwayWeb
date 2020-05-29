<?php
class Trip_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function addTripApi($data) {
        $this->db->insert("tbl_trip", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     public function getLatLongData($tripId,$customerId) {
         if((isset($tripId)>0) && (isset($customerId)>0)) {
            $this->db->select(array("*"))
                ->from("tbl_trip");
            $this->db->where(array("tbl_trip.t_id" => $tripId, "tbl_trip.t_user_Id" => $customerId,));
                }
        $query = $this->db->get();
        $resultData = $query->result();
        if ($query->num_rows() > 0) {
            $result = $resultData[0];
            return $result;
        } else {
            return array();
        }
        
    }
    public function getLatLongDataDriver($tripId) {
         if((isset($tripId)>0)) {
            $this->db->select(array("*"))
                ->from("tbl_trip");
            $this->db->where(array("tbl_trip.t_id" => $tripId));
                }
        $query = $this->db->get();
        $resultData = $query->result();
        if ($query->num_rows() > 0) {
            $result = $resultData[0];
            return $result;
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

//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
            
            
            function nbSecToString($nbSec) {
                    $tmp = $nbSec % 3600;
                    $h = ($nbSec - $tmp ) / 3600;
                    $s = $tmp % 60;
                    $m = ( $tmp - $s ) / 60;
                    $h = str_pad($h, 2, "0", STR_PAD_LEFT);
                    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
                    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
                    return "$h:$m:$s";
                }
                
                
        public function getViewTripDataByTrip($bookTripId) {
       
        if(isset($bookTripId)>0){
        $this->db->select(array("*"))
                ->from("tbl_driver_location d")
                ->join('users u', 'u.Id=d.d_l_driver_id','left')
                ->join('tbl_trip t', 't.t_id=d.d_l_trip_id','left')
               ->join('tbl_accept_booking_trip a', 'd.d_l_trip_id=a.a_b_t_booking_trip_id','left');
                $this->db->where(array(
                    "d.d_l_trip_id" => $bookTripId,
                    "a.a_b_t_accept_status" => 'TRIP_STARTED',
                    "u.deletion_status"=> 0
                    ));
                }
                $this->db->order_by("d_l_id", "DESC");
                $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                   foreach($data as $row){
                    $cat['driverName']=$row->Name ;
                    $cat['tripId']=$row->a_b_t_booking_trip_id ;
                    $cat['bookTripCode']=$row->t_trip_id ;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
     public function getDriverLocationAfterTripStart($tripId) {
         if((isset($tripId)>0)) {
            $this->db->select(array("*"))
                ->from("tbl_driver_location d")
                ->join('tbl_accept_booking_trip a', 'd.d_l_trip_id=a.a_b_t_booking_trip_id','left');
            $this->db->where(array("d.d_l_trip_id" => $tripId,"a.a_b_t_accept_status" => 'TRIP_STARTED'));
                }
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
        if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter=0;
                   foreach($data as $row){
                    $cat[$counter]['driverLocationId']=$row->d_l_id ;
                    $cat[$counter]['latitude']=$row->d_l_latitude ;
                    $cat[$counter]['longitude']=$row->d_l_longitude ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
     public function getAllTripData() {  //======All Requests from all customers with paginatin which not accepted or cancelled by driver==========//
            $this->db->select('t.*,b.*,a.*,c.Name as customerName,c.Role_Id as customer_role_id,vt.*,v.*,o.Name as ownerName, d.Name as driverName,') 
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
                    $tripData[$counter]['t_type']=$row->t_type;
                    $tripData[$counter]['t_trip_id']=$row->t_trip_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_active_status']=$row->b_l_t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    
                    
                    $vehicleTypeId=$row->v_t_id;
                    $startlat=$row->t_start_latitude;
                    $startLong=$row->t_start_longitude;
                    $endlat=$row->t_end_latitude;
                    $endLong=$row->t_end_longitude;
                    $unit = "K";  // K = kilometer
                    $distance_all_Data=$this->getPriceDetailByDistance($startlat,$startLong,$endlat,$endLong,$unit,$vehicleTypeId);
                    
                    $tripData[$counter]['distance']=$distance_all_Data['totDistance'];
                    $tripData[$counter]['basePrice']=$distance_all_Data['totDistance']*$row->v_t_per_km_charge;
                    $tripData[$counter]['v_t_gst']=$row->v_t_gst;
                    $tripData[$counter]['totalAmount']=$distance_all_Data['totalAmount'];
                    
                    
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
                       $tripData[$counter]['userRole']='Goods Provider';
                    }
                    
                    $counter++;
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    }
    
    public  function getPriceDetailByDistance($lat1, $lon1, $lat2, $lon2, $unit,$vehicleTypeId) {
        if(isset($vehicleTypeId)>0){
        $this->db->select(array("*"))
                ->from("tbl_vehicle_type vt");
         $this->db->where(array(
                    //"vt.v_t_delete" => 0,
                    "vt.v_t_id" => $vehicleTypeId,
                    ));
        }
        $query = $this->db->get();
        // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                
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
                  $distanceData = $miles_in_k;
                } 
              }
              foreach($data as $row){
                    $distancePrice = $row->v_t_per_km_charge*$distanceData;
                    $gstPrise = $row->v_t_gst*$distancePrice/100;
                    $totalAmount=$distancePrice+$gstPrise;
                    $cat['totDistance']=$distanceData;
                    $cat['basedFarefixed']=$distancePrice;
                    $cat['distancePrice']=$distancePrice ;
                    $cat['peekHourCharges']=$row->v_t_per_km_charge;
                    $cat['nightFare']=$row->v_t_nigh_charge_per_km;
                    $cat['tax']=$row->v_t_gst;
                    $cat['totalAmount']=$totalAmount;
                    $cat['walletDetection']=$totalAmount;
                    $cat['gstAmount']=$gstPrise;
                    $cat['discount']='';
                    $cat['paymentMode']='paytm';
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
}
