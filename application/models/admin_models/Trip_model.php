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
            $this->db->select('b.b_l_t_status,b.b_l_t_active_status,t.t_id,t.t_trip_id,t.t_type,t.t_user_Id,t.t_vehicle_id,t.t_id,t.t_vehicle_id,t.t_add_date,t.t_fare,t.t_status,t.t_active_status,t.t_add_date,t.t_start_date,t.t_end_date,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_vehicle_name,o.Name as ownerName') 
                ->from('tbl_trip t')
                ->join('tbl_book_trip_link b','b.b_l_t_trip_id=t.t_id','left')  
                ->join('vehicle v','v.v_Id=t.t_vehicle_id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_vehicle_id=v.v_Id','left')      
                ->join('tbl_vehicle_type vt','vt.v_t_id=v.v_Id','left')
                ->join('users d', 'd.Id=a.a_v_t_d_driver_id','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('t.t_delete'=>0));
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
                    $tripData[$counter]['t_fare']=$row->t_fare;
                    $tripData[$counter]['t_active_status']=$row->t_active_status;
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
          $this->db->select('t.*,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_type,v.v_vehicle_number,v.v_type,o.Name as ownerName')        
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 't.t_id=b.b_l_t_trip_id','left')
                ->join('vehicle v','v.v_Id=b.b_l_t_vehicle_id','left')
                ->join('tbl_vehicle_type vt','vt.v_t_id=b.b_l_t_vehicle_type','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=b.b_l_t_customer_id','left')
                ->join('users d', 'd.Id=b.b_l_t_driver_id','left')
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
                    $tripData['t_fare']=$row->t_fare;
                    $tripData['t_active_status']=$row->t_active_status;
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
                    $tripData['driverName']=$row->driverName;
                    $tripData['vehicleType']=$row->v_t_type;
                    $tripData['vehicleName']=$row->v_type.' '.$row->v_vehicle_number;
                    $tripData['ownerName']=$row->ownerName;
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
                      $tripData['userRole']='Customer'; 
                    }
                    if($row->customer_role_id==2){
                       $tripData['userName']=$row->customerName; 
                       $tripData['userRole']='Milluser';
                    }
                   
                }
                //echo '<pre>' ; print_r($tripData);die;  
                return $tripData;
            } else {
            return array();
        }
    } 
    public function get_trip_view_data() { 
            $this->db->select('t.t_id,t.t_type,t.t_user_Id,t.t_vehicle_id,t.t_id,t.t_vehicle_id,t.t_add_date,t.t_fare,t.t_status,t.t_active_status,t.t_add_date,t.t_start_date,t.t_end_date,t.t_start_time,t.t_end_time,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_type,v.v_vehicle_number,v.v_type,o.Name as ownerName') 
                ->from('tbl_trip t')
                ->join('vehicle v','v.v_Id=t.t_vehicle_id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_vehicle_id=v.v_Id','left')      
                ->join('tbl_vehicle_type vt','vt.v_t_id=v.v_Id','left')
                ->join('users d', 'd.Id=a.a_v_t_d_driver_id','left')    
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('t.t_delete'=>0,'t.t_delete'=>0))
                ;
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $tripData=array();
                foreach($data as $row){
                    $tripData[$counter]['t_id']=$row->t_id;
                    $tripData[$counter]['t_user_Id']=$row->t_user_Id;
                    $tripData[$counter]['t_fare']=$row->t_fare;
                    $tripData[$counter]['t_active_status']=$row->t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['t_start_time']=$row->t_start_time;
                    $tripData[$counter]['t_end_time']=$row->t_end_time;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_type.' '.$row->v_vehicle_number;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->t_status==4){
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
            $this->db->select('t.t_id,t.t_trip_id,t.t_type,t.t_user_Id,t.t_vehicle_id,t.t_id,t.t_vehicle_id,t.t_add_date,t.t_fare,t.t_status,t.t_active_status,t.t_add_date,t.t_start_date,t.t_end_date,t.t_start_time,t.t_end_time,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_vehicle_name,v.v_vehicle_number,o.Name as ownerName') 
                ->from('tbl_trip t')
                ->join('vehicle v','v.v_Id=t.t_vehicle_id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_vehicle_id=v.v_Id','left')      
                ->join('tbl_vehicle_type vt','vt.v_t_id=v.v_Id','left')
                ->join('users d', 'd.Id=a.a_v_t_d_driver_id','left')
                ->join('users o', 'o.Id=v.v_owner_id','left')
                ->join('users c', 'c.Id=t.t_user_Id','left')
                ->where(array('t.t_delete'=>0,'t.t_delete'=>0));
                if (isset($tstatus) && !empty($tstatus)) {
                    $this->db->where("t.t_status", $tstatus);
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
                    $tripData[$counter]['t_fare']=$row->t_fare;
                    $tripData[$counter]['t_active_status']=$row->t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['t_start_time']=$row->t_start_time;
                    $tripData[$counter]['t_end_time']=$row->t_end_time;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name.' '.$row->v_vehicle_number;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->t_status==4){
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
            $this->db->select('t.t_id,t.t_trip_id,t.t_type,t.t_user_Id,t.t_vehicle_id,t.t_id,t.t_vehicle_id,t.t_add_date,t.t_fare,t.t_status,t.t_active_status,t.t_add_date,t.t_start_date,t.t_end_date,c.Name as customerName,c.Role_Id as customer_role_id,d.Name as driverName,vt.v_t_vehicle_name,o.Name as ownerName') 
                ->from('tbl_trip t')
                ->join('vehicle v','v.v_Id=t.t_vehicle_id','left')
                 ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_vehicle_id=v.v_Id','left')      
                ->join('tbl_vehicle_type vt','vt.v_t_id=v.v_Id','left')
                ->join('users d', 'd.Id=a.a_v_t_d_driver_id','left')
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
                    $tripData[$counter]['t_fare']=$row->t_fare;
                    $tripData[$counter]['t_active_status']=$row->t_active_status;
                    $tripData[$counter]['t_add_date']=$row->t_add_date;
                    $tripData[$counter]['t_start_date']=$row->t_start_date;
                    $tripData[$counter]['t_end_date']=$row->t_end_date;
                    $tripData[$counter]['driverName']=$row->driverName;
                    $tripData[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    $tripData[$counter]['ownerName']=$row->ownerName;
                    if($row->t_status==1){
                        $tripData[$counter]['tripStatus']='Upcoming';
                    }
                    if($row->t_status==2){
                        $tripData[$counter]['tripStatus']='Ongoing';
                    }
                    if($row->t_status==3){
                        $tripData[$counter]['tripStatus']='Completed';
                    }
                    if($row->t_status==4){
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
    
    
//    public function update_trip($trip_id,$data) {
//        $this->db->where(['t_id'=>$trip_id]);
//        $this->db->update("tbl_trip", $data);
//        if ($trip_id> 0) {
//            return $this->db->affected_rows();
//        } else {
//            return false;
//        }
//    }
	
    public function remove_trip_by_id($trip_id) { 
        $this->db->update($this->_trip, array('t_delete' => 1), array('t_id' => $trip_id)); 
        return $this->db->affected_rows(); 
    } 
    
}

