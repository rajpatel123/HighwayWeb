<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Driver_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_users = 'users'; 
    private $_drive_license = 'drive_license'; 
    
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
    
    public function add_driver_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_users, $data); 
        
        return $this->db->insert_id(); 
    }  
    
    public function add_driver_licence_data($dataDriver) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_drive_license, $dataDriver); 
        
        return $this->db->insert_id(); 
    } 
    public function get_dropdownData() { 
        $this->db->select(array('*')) 
                ->from('vehicle')
                ->join('tbl_vehicle_type', 'vehicle.v_Id=tbl_vehicle_type.v_t_id')
                ->where(array('v_status' => 1,'v_t_status' => 1,'v_delete'=>0,'v_t_delete'=>0));
        $query_result = $this->db->get(); 
        $result = $query_result->result(); 
        if($query_result->num_rows() > 0){
            return $result;
            } else {
               return array();  
            }
            
    }
    
    public function get_StateDropdown() { 
        $this->db->select(array('*')) 
                ->from('state')
                ->where(array('status' => 1));
         $this->db->order_by('state_name', 'ASC');
        $query_result = $this->db->get(); 
        $result = $query_result->result(); 
        if($query_result->num_rows() > 0){
            return $result;
            } else {
               return array();  
            }
            
    }
    
    
      public function fetchstateidwisedata($state_id)
        {
            $this->db->select('*');
            $this->db->from('city');
            $this->db->where('state_id', $state_id);
            $query  = $this->db->get();
            $output = '<option value="">----------Select City----------</option>';
            foreach ($query->result() as $row)
            {
                $output .= '<option value="' . $row->c_id . '">' . $row->city_name . '</option>';
            }
            return $output;
        }
    
      public function get_CityDropdown($cityId) { 
        $this->db->select(array('*')) 
                ->from('city')
                ->where(array('status' => 1,'c_id'=>$cityId));
         $this->db->order_by('city_name', 'ASC');
        $query_result = $this->db->get(); 
        $result = $query_result->result(); 
        if($query_result->num_rows() > 0){
            return $result;
            } else {
               return array();  
            }
            
    }
    
        function fetch_city($s_id)
         {
          $this->db->where('s_id', $s_id);
          $this->db->order_by('city_name', 'ASC');
          $query = $this->db->get('city');
          $output = '<option value="">Select City</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->c_id.'">'.$row->city_name.'</option>';
          }
          return $output;
         }
	
    public function get_driver_info() { 
        $this->db->select('*') 
                ->from('users u')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_driver_id=u.Id','left')
                ->join('vehicle v', 'v.v_Id=a.a_v_t_d_vehicle_id','left')
                ->where('Role_Id', 3)
                ->where('u.deletion_status', 0)
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 
    public function getDriverViewData($driver_id) { 
        $this->db->select('u.*,o.Name as OwnerName,d.License_Number,d.Image as dl_image,d.Status as dl_status,vt.*,v.*,vs.v_d_s_dimension_size,vc.v_l_c_load_capacity') 
                ->from('users u')
                ->join('drive_license d','d.User_Id=u.Id','left')
                ->join('tbl_assign_vehicle_to_driver a', 'a.a_v_t_d_driver_id=u.Id','left')
                ->join('vehicle v', 'v.v_Id=a.a_v_t_d_vehicle_id','left')
                ->join('users o', 'v.v_owner_id=o.Id','left')
                ->join('tbl_vehicle_type vt','vt.v_t_id=v.v_type_id','left')
                ->join('tbl_vehicle_load_capacity vc', 'vt.v_t_vehicle_load_capacity_id =vc.v_l_c_id ','left')
                ->join('tbl_vehicle_dimension_size vs', 'vt.v_t_vehicle_size_id=vs.v_d_s_id','left')
                ->where(array('u.Id' => $driver_id , 'u.deletion_status' => 0,'u.Role_Id' => 3));
        $this->db->limit(1);
        $query_result = $this->db->get(); 
        //echo  $this->db->last_query();die;
        $result = $query_result->row_array(); 
        return $result; 
    } 

    public function get_Driver_by_driver_id($driver_id) { 
        $result = $this->db->get_where($this->_users, array('Id' => $driver_id , 'deletion_status' => 0)); 
        return $result->row_array(); 
    } 

    public function published_driver_by_id($driver_id) { 
        $this->db->update($this->_users, array('Status' => 1), array('Id' => $driver_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_driver_by_id($driver_id) { 
        $this->db->update($this->_users, array('Status' => 0), array('Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_driver($driver_id, $data) { 
        $this->db->update($this->_users, $data, array('Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 
    public function update_driver_dl($driver_id, $data) { 
        $this->db->update($this->_drive_license, $data, array('User_Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_driver_by_id($driver_id) { 
        $this->db->update($this->_users, array('deletion_status' => 1), array('Id' => $driver_id)); 
        return $this->db->affected_rows(); 
    } 
    
}

