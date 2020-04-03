<?php
class Driver_location_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    function addDriverLocation($data){
        $this->db->insert("tbl_driver_location", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     public function geDriverDetailsById($user_id) {
        $this->db->select(array('d.d_l_driver_id'))
                ->from("tbl_driver_location d");
        if(isset($user_id)>0){
               $this->db->where(array("d.d_l_driver_id" => $user_id, "d.d_l_delete" => 0));
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
    
    public function getNearByDriverLocation() {
        $this->db->select(array('*'))
                ->from("tbl_driver_location d")
                ->join('tbl_assign_vehicle_to_driver a','d.d_l_driver_id=a.a_v_t_d_driver_id','left')
                ->join('users u','u.id=a.a_v_t_d_driver_id','left');
                $this->db->where(array(
                   "a.a_v_t_d_status" => 1,
                   "a.a_v_t_d_delete" => 0,
                   "d.d_l_delete" => 0,
                   ));
        
         $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                $counter = 0;
                foreach($data as $row){
                    $cat[$counter]['driverName']=$row->Name;
                    $cat[$counter]['driverMobile']=$row->Mobile;
                    $cat[$counter]['driverLat']=$row->d_l_latitude;
                    $cat[$counter]['driverLong']=$row->d_l_longitude;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    public function getDriverDetails($driverid,$tripid) {
          if(isset($driverid)>0 && isset($tripid)>0){
         $this->db->select(array('*'))
                ->from("tbl_accept_booking_trip a");
                $this->db->where(array(
                    "a.a_b_t_booking_trip_id" => $tripid, "a.a_b_t_driver_id" => $driverid, "a.a_b_t_delete" =>0,"a.a_b_t_accept_status" => 'TRIP_ACCEPTED'));
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
    
    
    public function getDriverCurentLocation($driverid,$tripid) {
          if(isset($driverid)>0 && isset($tripid)>0){
         $this->db->select(array('*'))
                ->from("tbl_driver_location d")
                ->join('users u','u.id=a.a_v_t_d_driver_id','left');
                $this->db->where(array(
                    "d.d_l_trip_id" => $tripid, 
                    "d.d_l_driver_id" => $driverid,
                    "a.d_l_delete" =>0
                    ));
            $this->db->order_by("id", "desc");
            $songsQuery = $this->db->limit(11);
        }
         $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['driverName']=$row->Name;
                    $cat['driverMobile']=$row->Mobile;
                    $cat['driverLat']=$row->d_l_latitude;
                    $cat['driverLong']=$row->d_l_longitude;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
    
    public function getDriverDataForNotification($driverid,$tripid) {
          if(isset($driverid)>0 && isset($tripid)>0){
         $this->db->select(array('*'))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('tbl_driver_location d', 'd.d_l_trip_id=b.b_l_t_trip_id','left')
                ->join('users u', 'u.Id=b.b_l_t_customer_id','left')
                ->join('tbl_vehicle_type vt', 'vt.v_t_id=b.b_l_t_vehicle_type','left');
                $this->db->where(array(
                    "d.d_l_trip_id" => $tripid, 
                    "d.d_l_driver_id" => $driverid,
                    ));
            $this->db->order_by("d_l_id", "desc");
            $this->db->limit(1);
        }
         $query = $this->db->get();
       // echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $cat = array();
                foreach($data as $row){
                    $cat['tripId']=$row->t_trip_id;
                    $cat['b_l_t_customer_id']=$row->b_l_t_customer_id;
                    $cat['driverName']=$row->Name;
                    $cat['driverMobile']=$row->Mobile;
                    $cat['driverCurrentLat']=$row->d_l_latitude;
                    $cat['driverCurrentLong']=$row->d_l_longitude;
                    $cat['vehicleName']=$row->v_t_vehicle_name;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }
   
}
