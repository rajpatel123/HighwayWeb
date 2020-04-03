<?php
class Trip_rating_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    function insertRatingTripByUser($data) {
        $this->db->insert("tbl_trip_rating", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public function updateRatingTripByUser($data,$ratingId) {
        $this->db->where(['t_r_id'=>$ratingId]);
        $this->db->update("tbl_trip_rating", $data);
        if ($ratingId> 0) {
            return $ratingId;
        } else {
            return false;
        }
    }
    
     public function getRatingData($userId,$tripId) {
         if((isset($userId)>0) && (isset($tripId)>0)){
        $this->db->select(array("*"))
                ->from("tbl_trip_rating t");
                $this->db->where(array(
                    "t.t_r_trip_id" => $tripId, 
                    "t.t_r_user_id"=> $userId,
                    "t.t_r_status"=> 1,
                    "t.t_r_delete"=> 0,
                    ));
                
         }
        $query = $this->db->get();
      //  echo  $this->db->last_query();die;
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
    }

}
