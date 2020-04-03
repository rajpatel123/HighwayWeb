<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author Pawan Nagar <pawan.nagar@docquity.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Email extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("book_trip_link_model");
        header('Content-Type: application/json');
        $this->_raw_input_stream = file_get_contents('php://input');
        
        
        
    }
    
    
    
    
    
    function driverInvoice_post() {
        $error = "";
        $driverId= $this->post('driverId');
        $tripId= $this->post('bookingId');
        if (empty($driverId)) {
            $error = "please provide driver id";
        } 
        if (empty($tripId)) {
            $error = "please provide booking id";
        } 
        $this->load->model("book_trip_link_model");
        $this->load->model("role_model");
        $roleData = $this->role_model->getroleByUserid($driverId);
        $roleId = $roleData->Role_Id;
        
        if($roleId==3){
        if (isset($error) && !empty($error)) {
            
            echo json_encode($error);
            
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "driverInvoice" => $this->book_trip_link_model->getDriverInvoiceData($tripId,$driverId),
                    ], REST_Controller::HTTP_OK);
        }
        
         
        
        
    } else {
                 $this->set_response([
                'status' => false,
                'message' => "You are not a driver",
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    
    
    }
    
    function customerInvoice_post() {
        $error = "";
        $customerId= $this->post('customerId');
        $tripId= $this->post('bookingId');
        if (empty($customerId)) {
            $error = "please provide customer id";
        } 
        if (empty($tripId)) {
            $error = "please provide booking id";
        } 
        $this->load->model("book_trip_link_model");
        $this->load->model("role_model");
        $roleData = $this->role_model->getroleByUserid($customerId);
        $roleId = $roleData->Role_Id;
        if($roleId==4){
        if (isset($error) && !empty($error)) {
            echo json_encode($error);
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "customerInvoice" => $this->book_trip_link_model->getCustomerInvoiceData($tripId,$customerId),
                    ], REST_Controller::HTTP_OK);
        }
    } else {
                 $this->set_response([
                'status' => false,
                'message' => "You are not a customer",
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    
    
    }
    
    
    function distanceTrip_post() {
        $error = "";
        $tripId= $this->post('bookingId');
        $startLatitude= $this->post('startLatitude');
        $startlongitude= $this->post('startlongitude');
        $endLatitude= $this->post('endLatitude');
        $endlongitude= $this->post('endlongitude');
        
        if (empty($tripId)) {
            $error = "please provide booking id";
        } 
        if (empty($startLatitude)) {
            $error = "please provide start Latitude";
        } 
        if (empty($startlongitude)) {
            $error = "please provide start longitude";
        } 
        if (empty($endLatitude)) {
            $error = "please provide start latitude";
        } 
        if (empty($endlongitude)) {
            $error = "please provide end longitude";
        } 
        $this->load->model("trip_model");
        $this->load->model("role_model");
        $roleData = $this->role_model->getroleByUserid($customerId);
        $roleId = $roleData->Role_Id;
        
        if (isset($error) && !empty($error)) {
            echo json_encode($error);
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
               // "customerInvoice" => $this->trip_model->getCustomerInvoiceData($tripId,$customerId),
                    ], REST_Controller::HTTP_OK);
        }
  
    }
    
    
    
     
    
}


