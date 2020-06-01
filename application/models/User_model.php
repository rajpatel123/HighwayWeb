<?php
class User_model extends CI_Model {
    
    public  function get_users($user_id,$username) {
        $this->db->where([
                'Id'=>$user_id,
                'Name'=>$username,
                'Status'=>1
                ]);
        $query =$this->db->get('users');
        return $query->result();
    }
     public  function getUserData($user_id,$roleId) {
        $this->db->where([
                'Id'=>$user_id,
                'Role_id'=>$roleId,
                'Status'=>1,
                ]);
        $query =$this->db->get('users');
       //echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
        
    }
    
    public  function getActiveUserData($user_id,$roleId) {
        $this->db->where([
                'Id'=>$user_id,
                'Role_id'=>$roleId,
                'Status'=>1,
                ]);
        $query =$this->db->get('users');
       //echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
        
    }
     public  function getLoginData($mobile) {
        $this->db->where([
                'Mobile'=>$mobile,
                'deletion_status'=>0,
                ]);
        $query =$this->db->get('users');
       //echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
        
    }
    
     
    
    public  function getLoginWithRoleData($mobile,$RoleId) {
        if((isset($mobile)>0) && isset($RoleId)>0){
        $this->db->where([
                'Mobile'=>$mobile,
                'Role_Id'=>$RoleId,
                'deletion_status'=>0,
                ]);
        $query =$this->db->get('users');
       }
       //echo  $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
        
    }
    
    
     public  function getCheckUserRole($mobile) {
      if(isset($mobile)>0){
         $this->db->select(array('u.Mobile','u.Role_Id','r.Title'))
                ->from("users u")
               ->join("roles r" ,"r.Id=u.Role_Id",'left')
                ->where(array("u.Mobile" => $mobile,"u.deletion_status"=>0));
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
    
    
     public  function getOtpData($mobile) {
       $this->db->select(array('Otp_Status','Otp','Role_Id'))
                ->from("users")
                ->where(array("users.Mobile" => $mobile));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public  function getRoleByMobile($mobile) {
       $this->db->select(array('Title','u.Id'))
                ->from("users u")
                ->join('roles r', 'r.Id=u. Role_Id','left')
                ->where(array("u.Mobile" => $mobile));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public function create_users($data){
        $this->db->insert('users',$data);
    }
    
    public function insertUserApi($data) {
        $this->db->insert("users", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public function update_users($data,$id){
       // echo '<pre>' ; print_r($id);die;
        $this->db->where(['Id'=>$id]);
        $this->db->update('users',$data);
        if ($id > 0) {
            return $id;
        } else {
            return false;
        }
    }
    
    public function update_users_mobile($data,$mobile,$role){
       // echo '<pre>' ; print_r($id);die;
        $this->db->where(['Mobile'=>$mobile,'Role_Id'=>$role]);
        $this->db->update('users',$data);
        if ($mobile > 0) {
            return $mobile;
        } else {
            return false;
        }
    }
    public function update_otp_status($data,$mobile,$Otp){
       // echo '<pre>' ; print_r($id);die;
        $this->db->where(['Mobile'=>$mobile,'Otp'=>$Otp]);
        $this->db->update('users',$data);
        if ($mobile > 0) {
            return $mobile;
        } else {
            return false;
        }
    }
     public  function getUserOtpDataApi($mobile) {
                $this->db->select(array('*'))
                ->from("users");
                if(isset($mobile)>0){
                $this->db->where(array("users.Mobile" => $mobile));
                }    
                        
                $this->db->limit(1); 
                $query = $this->db->get();
               // echo  $this->db->last_query();die;
                
         if($query->num_rows() > 0){
                $row= $query->result();
                $user=array();
                $user['User_Id'] = $row[0]->Id;
                $user['Name'] = $row[0]->Name;
                $user['Mobile'] = $row[0]->Mobile;
                //$user['Image'] = URL.'images/'.$row[0]->Image;
                $user['Email'] = $row[0]->Email;
                $user['Gender'] = $row[0]->Gender;
                $user['Role_Id'] = $row[0]->Role_Id;
                $user['Address'] = $row[0]->Address;
                $user['User_Status'] = $row[0]->Status;
                $user['Otp_Status'] = $row[0]->Otp_Status;
                $user['isBoolean'] = $row[0]->isBoolean;
                
                $roleData =$this->getCheckUserRoleByUserId($row[0]->add_by);
                if($roleData){
                    if($roleData[0]->Role_Id=='5'){
                     $user['driverVerifyBy'] = $row[0]->add_by;
                }} else {
                    $user['driverVerifyBy'] = $row[0]->add_by;
                    }
                
                
                return $user;
            } else {
            return array();
        }
    }

    public function delete_user($id){
        $this->db->where(['Id'=>$id]);
        $this->db->delete('users');
    }
    public function getUserList($user_id) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public function getCheckUserRoleByUserId($user_id) {
        $this->db->select(array("Role_Id"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
   public function getUserDetailsById($user_id) {
       
        if(isset($user_id)>0){
             $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.Status" => 1));
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
    
    
    public function getUserDetailsForToken($user_id) {
       
        if(isset($user_id)>0){
             $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Id" => $user_id, "users.deletion_status" => 0));
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
    
    public function getUserAddBy($add_by,$receiverMobile) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.add_by" => $add_by,"users.Mobile" => $receiverMobile, "users.Status" => 1));
        
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
    public function getUserDetailsByMobile($mobile_id) {
        $this->db->select(array("*"))
                ->from("users")
                ->where(array("users.Mobile" => $mobile_id, "users.Status" => 1));
        $query = $this->db->get();
        $resultData = $query->result();
        if (count($resultData) > 0) {
            $result = $resultData[0];
             return $result;
        } else {
            return array();
        }
       
    }
    public  function getSignupDataApi($user_id) {
                $this->db->select(array('*'))
                ->from("users");
                if(isset($user_id)>0){
                $this->db->where(array("users.Id" => $user_id));
                }    
                        
                $this->db->limit(1); 
                $query = $this->db->get();
               // echo  $this->db->last_query();die;
                
         if($query->num_rows() > 0){
                $row= $query->result();
                
                $user=array();
                $user['User_Id'] = $row[0]->Id;
                $user['Name'] = $row[0]->Name;
                $user['Mobile'] = $row[0]->Mobile;
                //$user['Image'] = URL.'images/'.$row[0]->Image;
                $user['Email'] = $row[0]->Email;
               // $user['Gender'] = $row[0]->Gender;
                $user['Role_Id'] = $row[0]->Role_Id;
               // $user['Address'] = $row[0]->Address;
                $user['User_Status'] = $row[0]->Status;
                $user['Otp_Status'] = $row[0]->Otp_Status;
                $user['isBoolean'] = $row[0]->isBoolean;
                
                return $user;
            } else {
            return array();
        }
    }
    
    public function update_signup_data($data,$user_id){
        $this->db->where(['Id'=>$user_id]);
        $this->db->update('users',$data);
        if ($user_id> 0) {
            return $user_id;
        } else {
            return false;
        }
    }
     public  function getDataByMobile($mobile) {
        $this->db->where([
                'Mobile'=>$mobile,
                'deletion_status'=>0,
                ]);
        $query =$this->db->get('users');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
        
    }
    public function getStateDropdownApi() {
         $this->db->select(array("*"))
                ->from("state");
        $queryData = $this->db->get();
        if($queryData->num_rows() > 0){
            $query =$this->db->get('state');
            if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['StateId']=$row->s_id;
                    $cat[$counter]['StateName']=$row->state_name;
                    $counter++;
                }
                return $cat;
            }
        
        } else {
            return array();
        }
         
        
    }
    
     public function getCityDropdownApi($state_id) {
         $this->db->select(array("*"))
                ->from("city")
               ->where(array("city.state_id" => $state_id));
        $queryData = $this->db->get();
        if($queryData->num_rows() > 0){
            $this->db->where([
                'state_id'=>$state_id,
                ]);
            $query =$this->db->get('city');
            if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['CityId']=$row->c_id;
                    $cat[$counter]['CityName']=$row->city_name;
                    $counter++;
                }
                return $cat;
            }
        
        } else {
            return array();
        }
         
        
    }
    
   
}
