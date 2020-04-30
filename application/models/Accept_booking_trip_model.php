<?php
class Accept_booking_trip_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    public  function getAcceptBookingTripApi($data) {
        $this->db->insert("tbl_accept_booking_trip", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }   
    
    public function getAcceptTripData($tripId,$userId) {
        $this->db->select(array("*"))
                ->from("tbl_accept_booking_trip a")
                ->where(array("a.a_b_t_booking_trip_id" => $tripId, "a.a_b_t_driver_id" => $userId ,'a.a_b_t_status'=>1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public function getAcceptTripOnlyOneAccept($tripId) {
        if($tripId>0)
{        $this->db->select(array("*"))
                ->from("tbl_accept_booking_trip a")
                ->where(array("a.a_b_t_booking_trip_id" => $tripId ,'a.a_b_t_status'=>1,'a.a_b_t_accept_driver_status'=>1));
}
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    
    
     public function getFirstTripData($driverId) {
        if($driverId>0){
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b");
                $this->db->where(array(
                    'b.b_l_t_active_status'=>1,
                    'b.b_l_t_driver_id'=>$driverId,
                    ));
        $this->db->order_by("b_l_t_trip_id", "DESC");            
        $this->db->limit(1);
        $query = $this->db->get();
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    
    
    public function getLastRatingTripData($driverId) {
        if($driverId>0){
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b");
                $this->db->where(array(
                    'b.b_l_t_active_status'=>1,
                    'b.b_l_t_driver_id'=>$driverId,
                    'b.b_l_t_rating_status'=>1,
                    ));
        $this->db->order_by("b_l_t_trip_id", "DESC");            
        $this->db->limit(1);
        $query = $this->db->get();
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public function updateAcceptBooking($data,$tripId,$userId){
        //echo '<pre>' ; print_r($tripId);die;
        $this->db->where(['a_b_t_booking_trip_id'=>$tripId,'a_b_t_driver_id'=>$userId,'a_b_t_status'=>1]);
        $this->db->update('tbl_accept_booking_trip',$data);
        if ($tripId> 0) {
            return $tripId;
        } else {
            return false;
        }
    }
    public function addStartTripByDriverApi($data,$tripId,$userId){
        if(isset($tripId)>0 && ($userId)>0){
        $this->db->where(['a_b_t_booking_trip_id'=>$tripId,'a_b_t_driver_id'=>$userId,'a_b_t_status'=>1]);
        }
        $this->db->update('tbl_accept_booking_trip',$data);
        if ($tripId> 0) {
            return $tripId;
        } else {
            return false;
        }
    }
    public function getDriverStatus($userId,$tripId) {
        $this->db->select(array("*"))
                ->from("tbl_accept_booking_trip a")
                ->where(array("a.a_b_t_booking_trip_id" => $tripId,"a.a_b_t_driver_id" => $userId ,'a_b_t_status'=>1));
                $this->db->order_by("a.a_b_t_id", "desc");
                $this->db->limit(1);
                
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    public function updateTripDataByDriver($data,$tripId,$userId){
        if(isset($tripId)>0 && ($userId)>0){
        $this->db->where(['a_b_t_booking_trip_id'=>$tripId,'a_b_t_driver_id'=>$userId,'a_b_t_status'=>1]);
        $this->db->update('tbl_accept_booking_trip',$data);
        }
        if ($tripId> 0) {
            return $tripId;
        } else {
            return false;
        }
    }
    
    public function getDriverTripdataByDriverId($userId) {
        $this->db->select(array("*"))
                ->from("tbl_accept_booking_trip a")
                ->where(array("a.a_b_t_driver_id" => $userId ,'a_b_t_status'=>1,'a_b_t_accept_status'=>'TRIP_STARTED'));
                $this->db->order_by("a.a_b_t_id", "desc");
                $this->db->limit(1);
                
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
}
