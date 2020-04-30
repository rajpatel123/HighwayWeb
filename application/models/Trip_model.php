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
                ->from("tbl_accept_booking_trip a ")
                ->join('tbl_trip t', 't.t_id=a.a_b_t_booking_trip_id','left')
                ->join('users u', 'u.Id=a.a_b_t_driver_id','left');
               
                $this->db->where(array(
                    "a.a_b_t_booking_trip_id" => $bookTripId,
                    "a.a_b_t_status"=> 1,
                    "u.deletion_status"=> 0
                    ));
                }
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
                    $cat[$counter]['latitude']=$row->d_l_latitude ;
                    $cat[$counter]['longitude']=$row->d_l_longitude ;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
}
