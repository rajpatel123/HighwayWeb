<?php
class Vehicle_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }


    
//    public  function get_users($user_id,$username) {
//        $this->db->where([
//                'Id'=>$user_id,
//                'Name'=>$username
//                ]);
//        $query =$this->db->get('users');
//        return $query->result();
//    }
//    
//    public function create_users($data){
//        $this->db->insert('users',$data);
//    }
//    public function update_users($data,$id){
//        $this->db->where(['Id'=>$id]);
//        $this->db->update('users',$data);
//    }
//    public function delete_user($id){
//        $this->db->where(['Id'=>$id]);
//        $this->db->delete('users');
//    }
//    function getUserList($user_id) {
//        $this->db->select(array("*"))
//                ->from("users")
//                ->where(array("users.Id" => $user_id, "users.Status" => 1));
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result();
//        } else {
//            return array();
//        }
//    }
    
    
    
    function addVehicleApi($data) {
        $this->db->insert("vehicle", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
            //return true;
        } else {
            return false;
        }
    }
    
      public  function getVehicleDetailsApi($ownerId) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_vehicle_type', 'vehicle.v_type_id=tbl_vehicle_type.v_t_id','left')
                ->join('tbl_vehicle_load_capacity', 'tbl_vehicle_type.v_t_vehicle_load_capacity_id =tbl_vehicle_load_capacity.v_l_c_id ','left')
                ->join('tbl_vehicle_dimension_size', 'tbl_vehicle_type.v_t_vehicle_size_id=tbl_vehicle_dimension_size.v_d_s_id','left')
                ->join('tbl_assign_vehicle_to_driver', 'vehicle.v_Id=tbl_assign_vehicle_to_driver.a_v_t_d_vehicle_id','left')
                ->join('users', 'users.Id=tbl_assign_vehicle_to_driver.a_v_t_d_driver_id','left')
                ->join('tbl_driver_location', 'tbl_assign_vehicle_to_driver.a_v_t_d_driver_id=tbl_driver_location.d_l_driver_id','left')
                ->join('drive_license', 'drive_license.User_Id=tbl_assign_vehicle_to_driver.a_v_t_d_driver_id','left')
                ->where(array("vehicle.v_status" => 1,"vehicle.v_delete" => 0,"vehicle.v_owner_id" =>$ownerId ))
                ;
        $this->db->order_by("d_l_id", "DESC");            
        $this->db->GROUP_BY('d_l_driver_id');
       
        $query = $this->db->get();
        //  echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['VehicleId']=$row->v_Id ;
                    $cat[$counter]['VehicleName']=$row->v_t_vehicle_name ;
                    $cat[$counter]['VehicleNumber']=$row->v_vehicle_number ;
                    $cat[$counter]['VehicleModelNo']=$row->v_vehicle_model_no;
                    $cat[$counter]['VehicleDescription']=$row->v_vehicle_detail;
                    $cat[$counter]['VehicleCapacity']=$row->v_l_c_load_capacity;
                    $cat[$counter]['VehicleSize']=$row->v_d_s_dimension_size;
                    $VehicleImage = "./assets/backend/img/vehicle/vehicleImage/" . $row->v_vehicle_Image;
//                    $vehicleBack = "./assets/backend/img/vehicle/vehicleBack/" . $row->v_back_image;
//                    $vehicleEngine = "./assets/backend/img/vehicle/vehicleEngine/" . $row->v_engine_image;
//                    $vehicleFront = "./assets/backend/img/vehicle/vehicleFront/" . $row->v_front_image;
//                    $vehicleLeft = "./assets/backend/img/vehicle/vehicleLeft/" . $row->v_left_image;
//                    $vehicleRight = "./assets/backend/img/vehicle/vehicleRight/" . $row->v_right_image;
                    if((file_exists($VehicleImage)) && $row->v_vehicle_Image!=''){                        
                        $cat[$counter]['VehicleImage']=$VehicleImage; 
                    } else {
                        $cat[$counter]['VehicleImage']=''; 
                    } 
//                    if((file_exists($vehicleBack)) && $row->v_back_image!=''){                        
//                        $cat[$counter]['vehicleBack']=$vehicleBack; 
//                    } else {
//                        $cat[$counter]['vehicleBack']=''; 
//                    } 
//                    if((file_exists($vehicleEngine)) && $row->v_engine_image!=''){                        
//                        $cat[$counter]['vehicleEngine']=$vehicleEngine; 
//                    } else {
//                        $cat[$counter]['vehicleEngine']=''; 
//                    } 
//                    if((file_exists($vehicleFront)) && $row->v_front_image!=''){                        
//                        $cat[$counter]['vehicleFront']=$vehicleFront; 
//                    } else {
//                        $cat[$counter]['vehicleFront']=''; 
//                    } 
//                    if((file_exists($vehicleLeft)) && $row->v_left_image!=''){                        
//                        $cat[$counter]['vehicleLeft']=$vehicleLeft; 
//                    } else {
//                        $cat[$counter]['vehicleLeft']=''; 
//                    } 
//                    if((file_exists($vehicleRight)) && $row->v_right_image!=''){                        
//                        $cat[$counter]['vehicleRight']=$vehicleRight; 
//                    } else {
//                        $cat[$counter]['vehicleRight']=''; 
//                    } 
                    if($row->a_v_t_d_driver_id){
                      $cat[$counter]['DriverId']=$row->a_v_t_d_driver_id;  
                    } else {
                        $cat[$counter]['DriverId']='';
                    }
                    
                    if($row->a_v_t_d_driver_id>0){
                    $cat[$counter]['DriverName']=$row->Name;   
                    } else {
                    $cat[$counter]['DriverName']='Currently vehicle is not assign !';     
                    }
                    if($row->Mobile){
                       $cat[$counter]['Mobile']=$row->Mobile; 
                    } else {
                        $cat[$counter]['Mobile']='';
                    }
                    
                    if($row->Email){
                        $cat[$counter]['Email']=$row->Email;
                    }else {
                        $cat[$counter]['Email']='';
                    }
                    if($row->License_Number){
                    $cat[$counter]['DLNumber']=$row->License_Number;
                    } else {
                      $cat[$counter]['DLNumber']='';  
                    }
                    if($row->Expiry_Date){
                       $cat[$counter]['ExpiryDate']=$row->Expiry_Date; 
                    }else {
                        $cat[$counter]['ExpiryDate']='';
                    }
                    if($row->Address){
                        $cat[$counter]['Address']=$row->Address;  
                    }else {
                          $cat[$counter]['Address']='';
                    }
                    if($row->d_l_latitude){
                    $cat[$counter]['Latitude']=$row->d_l_latitude;
                    } else{
                      $cat[$counter]['Latitude']='';  
                    }
                    if($row->d_l_longitude){
                        $cat[$counter]['Longitude']=$row->d_l_longitude;
                    } else {
                        $cat[$counter]['Longitude']='';
                    }
                    
                    if($row->v_vehicle_on_off=='ON'){
                    $cat[$counter]['VehicleOnOff']=$row->v_vehicle_on_off;
                    } else {
                     $cat[$counter]['VehicleOnOff']='OFF';   
                    }
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByCustomerApi($userId,$status,$roleId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link")
                ->join('tbl_trip', 'tbl_book_trip_link.b_l_t_trip_id =tbl_trip.t_id')
                ->join('tbl_vehicle_type', 'tbl_book_trip_link.b_l_t_vehicle_type=tbl_vehicle_type.v_t_id','left')
                ->join('vehicle', 'vehicle.v_Id=tbl_book_trip_link.b_l_t_vehicle_id','left')
                ->join('tbl_book_trip_fare', 'tbl_book_trip_fare.b_t_f_id=tbl_book_trip_link.b_l_t_fare_id','left')
                ->join('users', 'users.Id=tbl_book_trip_link.b_l_t_customer_id','left')
                ->join('roles', 'users.Role_Id=roles.Id','left');
        
        
        if(isset($userId)>0 && $status>0){
             $this->db->where(array(
                    "tbl_book_trip_link.b_l_t_customer_id" => $userId ,
                    "tbl_book_trip_link.b_l_t_status" => $status,
                    "tbl_book_trip_link.b_l_t_active_status" => 1,
                    "users.Role_Id" => $roleId ,
                    "users.status" => 1,
                    "users.deletion_status" => 0)
        );}
        $query = $this->db->get();
//        echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    if(($row->v_vehicle_number)>0){
                       $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;  
                    } else {
                        $cat[$counter]['vehicleNumber']=''; 
                    }
                    
                    $cat[$counter]['fare']='₹ '.$row->b_t_f_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    if($row->t_type==1){
                    $cat[$counter]['tripType']='Personal Trip';
                    } 
                    if($row->t_type==2){
                    $cat[$counter]['tripType']='Busniss Trip';
                    }
                    if(($row->t_start_date)>0){
                       $cat[$counter]['startDate']=$row->t_start_date; 
                    } else {
                        $cat[$counter]['startDate']='';
                    }
                    if(($row->t_end_date)>0){
                       $cat[$counter]['endDate']=$row->t_end_date; 
                    } else {
                        $cat[$counter]['endDate']='';
                    }
                    
                    if(($row->t_start_time)>0){
                      $cat[$counter]['pickupTime']=$row->t_start_time;
                    } else {
                       $cat[$counter]['pickupTime']='';
                    }
                    if(($row->t_end_time)>0){
                       $cat[$counter]['dropTime']=$row->t_end_time;
                    } else {
                        $cat[$counter]['dropTime']='';
                    }
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByMillUserApi($userId,$status,$roleId) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link")
                ->join('tbl_trip', 'tbl_book_trip_link.b_l_t_trip_id =tbl_trip.t_id','left')
                ->join('tbl_vehicle_type', 'tbl_book_trip_link.b_l_t_vehicle_type=tbl_vehicle_type.v_t_id','left')
                ->join('vehicle', 'vehicle.v_Id=tbl_book_trip_link.b_l_t_vehicle_id','left')
                ->join('tbl_book_trip_fare', 'tbl_book_trip_fare.b_t_f_id=tbl_book_trip_link.b_l_t_fare_id','left')
                ->join('users', 'users.Id=tbl_book_trip_link.b_l_t_customer_id','left')
                ->join('roles', 'users.Role_Id=roles.Id','left');
        
        
        if(isset($userId)>0 && $status>0){
             $this->db->where(array(
                    "tbl_book_trip_link.b_l_t_customer_id" => $userId ,
                    "tbl_book_trip_link.b_l_t_status" => $status,
                    "tbl_book_trip_link.b_l_t_active_status" => 1,
                    "users.Role_Id" => $roleId ,
                    "users.status" => 1,
                    "users.deletion_status" => 0)
        );}
        $query = $this->db->get();
      //  echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_t_vehicle_name;
                    if(($row->v_vehicle_number)>0){
                       $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;  
                    } else {
                        $cat[$counter]['vehicleNumber']=''; 
                    }
                    $cat[$counter]['fare']='₹ '.$row->b_t_f_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                   
                    if($row->t_type==1){
                    $cat[$counter]['tripType']='Personal Trip';
                    } 
                    if($row->t_type==2){
                    $cat[$counter]['tripType']='Busniss Trip';
                    } 
                    if(($row->t_start_date)>0){
                       $cat[$counter]['startDate']=$row->t_start_date; 
                    } else {
                        $cat[$counter]['startDate']='';
                    }
                    if(($row->t_end_date)>0){
                       $cat[$counter]['endDate']=$row->t_end_date; 
                    } else {
                        $cat[$counter]['endDate']='';
                    }
                    
                    if(($row->t_start_time)>0){
                      $cat[$counter]['pickupTime']=$row->t_start_time;
                    } else {
                       $cat[$counter]['pickupTime']='';
                    }
                    if(($row->t_end_time)>0){
                       $cat[$counter]['dropTime']=$row->t_end_time;
                    } else {
                        $cat[$counter]['dropTime']='';
                    }
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByDriverApi($userId,$status) {
        $this->db->select(array("*"))
                ->from("tbl_book_trip_link b")
                ->join('tbl_trip t', 'b.b_l_t_trip_id =t.t_id','left')
                ->join('tbl_vehicle_type vt', 'b.b_l_t_vehicle_type=vt.v_t_id','left')
                ->join('vehicle v', 'v.v_Id=b.b_l_t_vehicle_id','left')
                ->join('tbl_book_trip_fare f', 'f.b_t_f_id=b.b_l_t_fare_id','left')
                ->join('users u', 'u.Id=b.b_l_t_customer_id','left')
                ->join('roles r', 'u.Role_Id=r.Id','left');
                
                
            if(isset($userId)>0 && $status>0){
             $this->db->where(array(
                    "b.b_l_t_driver_id" => $userId ,
                    "v.v_status" => 1 ,
                    "b.b_l_t_status" => $status,
                    "b.b_l_t_active_status" => 1,
                    "u.status" => 1,
                    "u.deletion_status" => 0)
                );}
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_t_vehicle_name;   
                    if(($row->v_vehicle_number)>0){
                       $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;  
                    } else {
                        $cat[$counter]['vehicleNumber']=''; 
                    }
                    $cat[$counter]['fare']='₹ '.$row->b_t_f_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    if($row->t_type==1){
                    $cat[$counter]['tripType']='Personal Trip';
                    } 
                    if($row->t_type==2){
                    $cat[$counter]['tripType']='Busniss Trip';
                    }
                    if($row->t_start_date!='NULL'){
                       $cat[$counter]['startDate']=$row->t_start_date; 
                    } else {
                        $cat[$counter]['startDate']='';
                    }
                    if(($row->t_start_date)>0){
                       $cat[$counter]['startDate']=$row->t_start_date; 
                    } else {
                        $cat[$counter]['startDate']='';
                    }
                    if(($row->t_end_date)>0){
                       $cat[$counter]['endDate']=$row->t_end_date; 
                    } else {
                        $cat[$counter]['endDate']='';
                    }
                    
                    if(($row->t_start_time)>0){
                      $cat[$counter]['pickupTime']=$row->t_start_time;
                    } else {
                       $cat[$counter]['pickupTime']='';
                    }
                    if(($row->t_end_time)>0){
                       $cat[$counter]['dropTime']=$row->t_end_time;
                    } else {
                        $cat[$counter]['dropTime']='';
                    }
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllTripByOwnerApi($userId,$status) {
       $this->db->select(array("*"))
                ->from("tbl_book_trip_link")
                ->join('tbl_trip', 'tbl_book_trip_link.b_l_t_trip_id =tbl_trip.t_id')
                ->join('tbl_vehicle_type', 'tbl_book_trip_link.b_l_t_vehicle_type=tbl_vehicle_type.v_t_id','left')
                ->join('vehicle', 'vehicle.v_Id=tbl_book_trip_link.b_l_t_vehicle_id','left')
                ->join('tbl_book_trip_fare', 'tbl_book_trip_fare.b_t_f_id=tbl_book_trip_link.b_l_t_fare_id','left')
                ->join('users', 'users.Id=tbl_book_trip_link.b_l_t_customer_id','left')
                ->join('roles', 'users.Role_Id=roles.Id','left');
                
                
            if(isset($userId)>0 && $status>0){
             $this->db->where(array(
                    "vehicle.v_owner_id" => $userId ,
                    "vehicle.v_status" => 1 ,
                    "tbl_book_trip_link.b_l_t_status" => $status,
                    "tbl_book_trip_link.b_l_t_active_status" => 1,
                    "users.status" => 1,
                    "users.deletion_status" => 0)
                );}
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['sourceLat']=$row->t_start_latitude ;
                    $cat[$counter]['sourceLong']=$row->t_start_longitude ;
                    $cat[$counter]['destinationLat']=$row->t_end_latitude;
                    $cat[$counter]['destinationLong']=$row->t_end_longitude;
                    $cat[$counter]['name']=$row->Name;
                    $cat[$counter]['role']=$row->Title;
                    $cat[$counter]['vehicleName']=$row->v_t_vehicle_name;   
                    if(($row->v_vehicle_number)>0){
                       $cat[$counter]['vehicleNumber']=$row->v_vehicle_number;  
                    } else {
                        $cat[$counter]['vehicleNumber']=''; 
                    }
                    $cat[$counter]['fare']='₹ '.$row->b_t_f_fare;
                    if($status==1){
                    $cat[$counter]['status']='Upcoming';
                    } 
                    if($status==2){
                    $cat[$counter]['status']='Ongoing';
                    } 
                    if($status==3){
                    $cat[$counter]['status']='Completed';
                    } 
                    if($status==4){
                    $cat[$counter]['status']='Cancel';
                    } 
                    if($row->t_type==1){
                    $cat[$counter]['tripType']='Personal Trip';
                    } 
                    if($row->t_type==2){
                    $cat[$counter]['tripType']='Busniss Trip';
                    }
                    if(($row->t_start_date)>0){
                       $cat[$counter]['startDate']=$row->t_start_date; 
                    } else {
                        $cat[$counter]['startDate']='';
                    }
                    if(($row->t_end_date)>0){
                       $cat[$counter]['endDate']=$row->t_end_date; 
                    } else {
                        $cat[$counter]['endDate']='';
                    }
                    
                    if(($row->t_start_time)>0){
                      $cat[$counter]['pickupTime']=$row->t_start_time;
                    } else {
                       $cat[$counter]['pickupTime']='';
                    }
                    if(($row->t_end_time)>0){
                       $cat[$counter]['dropTime']=$row->t_end_time;
                    } else {
                        $cat[$counter]['dropTime']='';
                    }
                   
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getAllVehicleListApi($distanceData) {
        $this->db->select(array("*"))
                ->from("tbl_vehicle_type v")
                ->where(array("v.v_t_status" => 1,"v.v_t_delete" => 0));
        $query = $this->db->get();
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter= $count=0;
                $cat = $info = array();
                
                $time = '00:1:00';   // 1 min me 1 km
                $distance = $distanceData;
                list($h,$m,$s) = explode(':',$time);
                $nbSec = $h * 3600 + $m * 60 + $s;
                $totalDuration = $nbSec * $distance;
                $ToTTimeInMineutHour = gmdate("H:i:s", $totalDuration);
                $totalTime = explode(':',$ToTTimeInMineutHour);
                
                $hour = $totalTime[0];
                $minute = $totalTime[1];
                $seconds = $totalTime[2];
                $ttinhour = $hour.' Hour '.$minute.' Minute';
                
                
                $this->db->select(array('v_i_information'))
                ->from("tbl_vehicle_info")
                ->where(array("tbl_vehicle_info.v_i_status" => 1,"tbl_vehicle_info.v_i_delete" => 0,));
                $query_result = $this->db->get();
                $vinfo= $query_result->result();
                foreach($vinfo as $v_info){
                   $info['info1']= $vinfo[0]->v_i_information;
                   $info['info2']= $vinfo[1]->v_i_information;
                   $info['info3']= $vinfo[2]->v_i_information;
                   $info['info4']= $vinfo[3]->v_i_information;
                   $info['info5']= $vinfo[4]->v_i_information;
                   $info['info6']= $vinfo[5]->v_i_information;
                   $info['VehicleName']='Tata';
                    $info['VehicleCapacity']='cap' ;
                    $info['VehicleSize']='size';
                  
                }
              // echo  '<pre>' ;print_r($vinfo);die;
              
              
                foreach($data as $row){
                    $distancePrice = $row->v_t_per_km_charge*$distanceData;
                    $cat[$counter]['VehicleId']=$row->v_t_id ;
                    $cat[$counter]['VehicleTypeId']=$row->v_t_id ;
                    $cat[$counter]['VehicleName']=$row->v_t_vehicle_name ;
                    $cat[$counter]['VehicleType']=$row->v_t_type ;
                    $cat[$counter]['VehicleFare']=$distancePrice;
                    $cat[$counter]['TimeDuration']=$ttinhour;
                    
                    $cat[$counter]['v_info']=$info;
                    $counter++;
                    }
                return $cat;
                
            } else {
            return array();
        }
    }

    public  function getVehicleinfoApi($vehicle_id) {
        $this->db->select(array("*"))
                ->from("vehicle")
                ->join('tbl_vehicle_type', 'vehicle.v_type_id=tbl_vehicle_type.v_t_id','left')
                ->join('tbl_vehicle_load_capacity', 'vehicle.v_vehicle_capacity_id =tbl_vehicle_load_capacity.v_l_c_id ','left')
                ->join('tbl_vehicle_dimension_size', 'vehicle.v_vehicle_size_id=tbl_vehicle_dimension_size.v_d_s_id','left');
                if(isset($vehicle_id)>0){
                $this->db->where(array("vehicle.v_status" => 1,"vehicle.v_delete" => 0,"vehicle.v_Id" => $vehicle_id));
                    }
                
                
        $query = $this->db->get();
       /// echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                
                $this->db->select(array('v_i_information'))
                ->from("tbl_vehicle_info")
                ->where(array("tbl_vehicle_info.v_i_status" => 1,"tbl_vehicle_info.v_i_delete" => 0,));
                $query_result = $this->db->get();
                $vinfo= $query_result->result();
                foreach($data as $row){
                    //$vehicleImage = base_url()."assets/backend/img/vehicle/vehicleImage/$row->v_vehicle_Image";
                    $cat[$counter]['VehicleId']=$row->v_Id ;
                    $cat[$counter]['VehicleName']=$row->v_t_vehicle_name ;
                  //  $cat[$counter]['VehicleImage']=$vehicleImage ;
                    $cat[$counter]['VehicleCapacity']=$row->v_l_c_load_capacity ;
                    $cat[$counter]['VehicleSize']=$row->v_d_s_dimension_size;
                    $cat[$counter]['v_info1']=$vinfo[0]->v_i_information;
                    $cat[$counter]['v_info2']=$vinfo[1]->v_i_information;
                    $cat[$counter]['v_info3']=$vinfo[2]->v_i_information;
                    $cat[$counter]['v_info4']=$vinfo[3]->v_i_information;
                    $cat[$counter]['v_info5']=$vinfo[4]->v_i_information;
                    $cat[$counter]['v_info6']=$vinfo[5]->v_i_information;
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        }
    }
    public  function getVehiclePointOnMapApi($vehicle_type_id) {
        $this->db->select(array('v.v_Id','v.v_type_id','vt.v_t_vehicle_name','a.a_v_t_d_vehicle_id'))
                ->from("tbl_assign_vehicle_to_driver a")
                ->join('vehicle v', 'v.v_Id=a.a_v_t_d_vehicle_id','left')
                ->join('tbl_vehicle_type vt', 'v.v_type_id=vt.v_t_id','left');
                if(isset($vehicle_type_id)>0){
                 $this->db->where(array("a.a_v_t_d_status" => 1,"a.a_v_t_d_delete" => 0,"v.v_type_id"=>$vehicle_type_id));
                }
        $query = $this->db->get();
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=$ubniqueUser = array();
                foreach($data as $row){
                    $cat[$counter]['vehicleId']=$row->a_v_t_d_vehicle_id ;
                    $cat[$counter]['vehicleTypeId']=$row->v_type_id ;
                    $cat[$counter]['vehicleName']=$row->v_t_vehicle_name ;
                    $counter++;
                }
                return $cat;
                
            } else {
            return array();
        }
    }
    public  function getVehicleinfoDataApi() {
                $this->db->select(array('v_i_information'))
                ->from("tbl_vehicle_info")
                ->where(array("tbl_vehicle_info.v_i_status" => 1,"tbl_vehicle_info.v_i_delete" => 0,));
                $query = $this->db->get();
               // echo  $this->db->last_query();die;
                
         if($query->num_rows() > 0){
                $vinfo= $query->result();
                $cat=array();
                    $cat['v_info1']=$vinfo[0]->v_i_information;
                    $cat['v_info2']=$vinfo[1]->v_i_information;
                    $cat['v_info3']=$vinfo[2]->v_i_information;
                    $cat['v_info4']=$vinfo[3]->v_i_information;
                    $cat['v_info5']=$vinfo[4]->v_i_information;
                    $cat['v_info6']=$vinfo[5]->v_i_information;
                
                return $cat;
            } else {
            return array();
        }
    }
    
     public  function getBookingInfoDetailsApi($vehicle_id) {
        $this->db->select(array("*"))
                ->from("tbl_vehicle_type vt")
                ->join('tbl_vehicle_load_capacity vc', 'vt.v_t_vehicle_load_capacity_id =vc.v_l_c_id ','left')
                ->join('tbl_vehicle_dimension_size cd', 'vt.v_t_vehicle_size_id=cd.v_d_s_id','left');
                if(isset($vehicle_id)>0){
                $this->db->where(array("vt.v_t_status" => 1,"vt.v_t_delete" => 0,"vt.v_t_id" => $vehicle_id));
                    }
                
                
        $query = $this->db->get();
       /// echo  $this->db->last_query();die;
         if($query->num_rows() > 0){
                $data= $query->result();
            
                $cat=array();
                
                $this->db->select(array('v_i_information'))
                ->from("tbl_vehicle_info")
                ->where(array("tbl_vehicle_info.v_i_status" => 1,"tbl_vehicle_info.v_i_delete" => 0,));
                $query_result = $this->db->get();
                $vinfo= $query_result->result();
                foreach($data as $row){
                    $cat['VehicleTypeId']=$row->v_t_id ;
                    $cat['VehicleTypeName']=$row->v_t_vehicle_name ;
                    $cat['VehicleCapacity']=$row->v_l_c_load_capacity ;
                    $cat['VehicleSize']=$row->v_d_s_dimension_size;
                    $cat['v_info1']=$vinfo[0]->v_i_information;
                    $cat['v_info2']=$vinfo[1]->v_i_information;
                    $cat['v_info3']=$vinfo[2]->v_i_information;
                    $cat['v_info4']=$vinfo[3]->v_i_information;
                    $cat['v_info5']=$vinfo[4]->v_i_information;
                    $cat['v_info6']=$vinfo[5]->v_i_information;
                    $cat['v_info7']=$vinfo[6]->v_i_information;
                   
                }
                return $cat;
            } else {
            return array();
        }
    }
    
    
      public function getvehicleOwnerDetails($vehicleId,$userId) {
         if((isset($vehicleId)>0) && (isset($userId)>0)) {
            $this->db->select(array("*"))
                ->from("vehicle");
            $this->db->where(array("v_Id" => $vehicleId, "v_owner_id" => $userId,));
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
    
    public function updateVehicleApi($data,$VehicleId){
      if ($VehicleId > 0) {
        $this->db->where(['v_Id'=>$VehicleId]);
        $this->db->update('vehicle',$data);
            return $data['v_vehicle_on_off'];
        } else {
            return false;
        }
    }
}
