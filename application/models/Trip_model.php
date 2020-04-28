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
    
     
}
