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
class Booking extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("book_trip_link_model");
        header('Content-Type: application/json');
        $this->_raw_input_stream = file_get_contents('php://input');
        
        
        
    }
    
    function bookTripDetailsForCustomer_post() {
        $error = "";
        $customer_id = $this->post('userId');
        $booking_trip_id = $this->post('bookingTripId');
        
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($booking_trip_id)) {
            $error = "please provide booking id";
        }
        $this->load->model("book_trip_link_model");
        $this->load->model("role_model");
        
//         //==================push notification start====================// 
//         $userDetails = $this->role_model->geUserDetailsById($customer_id);
//         if($userDetails){        
//         $this->load->model("mobile_token_model");
        
//          $bookTripData = $this->book_trip_link_model->getBookTripDataByTripId($booking_trip_id);
//       //echo '<pre>' ;print_r($bookTripData->b_l_t_vehicle_type); die;
      
//       $vehicleType=$bookTripData->b_l_t_vehicle_type;
        
//         $mobileTokenData = $this->mobile_token_model->getMobileTokenData($vehicleType,$customer_id);
//       // echo '<pre>' ;print_r($vehicleType);
//     define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
//   $msg = array
// (
// 	'message' 	=> 'here is a message. message',
// 	'title'		=> 'This is a title. title',
// 	'subtitle'	=> 'This is a subtitle. subtitle',
// 	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
// 	'vibrate'	=> 1,
// 	'sound'		=> 1,
// 	'largeIcon'	=> 'large_icon',
// 	'smallIcon'	=> 'small_icon'
// );
// $fields = array
// (
//     'registration_ids' => $mobileTokenData,
//     'data' => $msg,
//     'priority' => 'high',
//     'notification' => array(
//         'title' => 'Trip Added',
//         'body' => array(
//                 'message' => 'Trip Add By Customer: ',
//                 'customer' => $userDetails->Name,
//                 'mobile' => $userDetails->Mobile, 
//                 'tripId' => $bookTripData->b_l_t_trip_id, 
//                 'source' => $bookTripData->t_source_address, 
//                 'destination' => $bookTripData->t_destination_address,
//                 'type' => 'TRIP_NEW', 
//             )
//     )
// );
// $headers = array
// (
// 	'Authorization: key=' . API_ACCESS_KEY,
// 	'Content-Type: application/json'
// );
 
// $ch = curl_init();
// curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
// curl_setopt( $ch,CURLOPT_POST, true );
// curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
// curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
// curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
// curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
// $result=curl_exec($ch );
// curl_close( $ch );
// echo $result;
// }

//  //==================push notification End====================//    
        
        
        
        
        
        
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
                
                "booking_trip_details" => $this->book_trip_link_model->getBookTripDetailsApi($booking_trip_id,$customer_id),
                    ], REST_Controller::HTTP_OK);
        }
    
}
    function applyCoupon_post() {
        $error = "";
        $coupon = $this->post('coupon');
        if (empty($coupon)) {
            $error = "please provide coupon";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("coupon_model");
             $couponData = $this->coupon_model->getCouponData($coupon);
             if($couponData){
             $couponId= $couponData[0]->c_id;
             //echo '<pre>' ;print_r($couponData[0]->c_id);die;
            
            
            $updateData = $this->coupon_model->updateCouponApi(array(
                "c_coupan_status" => 2
                ),$couponId);
            if ($updateData) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$updateData
                        ], REST_Controller::HTTP_OK);
            }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "invalid coupon code",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function bookingInfoForCustomer_post() {
        $error = "";
        $user_id = $this->post('userId');
        $vehicleTypeId = $this->post('vehicleTypeId');
        if (empty($user_id)) {
            $error = "please provide user id";
        } 
        if (empty($vehicleTypeId)) {
            $error = "please provide vehicle id";
        } 
        $this->load->model("vehicle_model");
        $this->load->model("user_model");
        
  
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
                "vehicle_type_info" =>array($this->vehicle_model->getBookingInfoDetailsApi($vehicleTypeId)),
                    ], REST_Controller::HTTP_OK);
        }
    }
    
    function confirmBookingApi_post() {
        $error = "";
        $customer_id = $this->post('User_id');
        $vehicleType = $this->post('VehicleTypeId'); // vehicle type ID
        $trip_reciver_id = $this->post('TripRecevirId');
        $goodsType_id = $this->post('GoodsTypeId');
        $start_latitude = $this->post('SourceLat');
        $start_longitude = $this->post('SourceLong');
        $end_latitude = $this->post('DestLat');
        $end_longitude = $this->post('DestLong');
        $tripFare = $this->post('TripFare');
        $couponId = $this->post('CouponId');
        $sourceAddress = $this->post('sourceAddress');
        $destAddress = $this->post('destAddress');
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($vehicleType)) {
            $error = "please provide vehicle type";
        } else if (empty($trip_reciver_id)) {
            $error = "please provide trip recvier id";
        }  else if (empty($trip_reciver_id)) {
            $error = "please provide reciver contact";
        } else if (empty($goodsType_id)) {
            $error = "please provide goods type";
        } else if (empty($start_latitude)) {
            $error = "please provide pickup location";
        } else if (empty($start_longitude)) {
            $error = "please provide pickup location";
        } else if (empty($end_latitude)) {
            $error = "please provide drop location";
        } else if (empty($end_longitude)) {
            $error = "please provide drop locatoion";
        }  else if (empty($tripFare)) {
            $error = "please provide fare";
        } else if (empty($sourceAddress)) {
            $error = "please provide source Address";
        } else if (empty($destAddress)) {
            $error = "please provide destination Address";
        }
        
        $this->load->model("book_trip_link_model");
        $this->load->model("book_trip_fare_model");
        $this->load->model("trip_model");
        $this->load->model("role_model");
        $this->load->model("coupon_model");
        $this->load->model("mobile_token_model");
        $couponData = $this->coupon_model->getCouponByCupanID($couponId);
        if($couponData){
            $cupan_id=$couponData[0]->c_id;
           
        } else {
            $cupan_id =0;
        }
        $userDetails = $this->role_model->geUserDetailsById($customer_id);
       // echo '<pre>' ;print_r($userDetails->Name);die;
        $userRole = $this->role_model->getroleByUserid($customer_id);
        $roleId=$userRole->Role_Id;
//        if($roleId==2){
//        $tripType = $this->post('TripType');
//            if (empty($tripType)) {
//                $error = "please provide trip type";
//            }
//        }
//        if($roleId==4){
//          $tripType = 1;
//            
//        }
        //$roleName=$userRole->Title;
        
       // echo '<pre>' ;print_r($userRole->Title);die;
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $t_trip_id='#HIG'.rand(1000, 9999);
         
            if(($roleId==2) or ($roleId==4)){
                $trip_id = $this->trip_model->addTripApi(array(
                "t_user_Id" => $customer_id,
                "t_type" => 1,
                "t_trip_id" => $t_trip_id,
                "t_start_latitude"=>$start_latitude,
                "t_start_longitude"=>$start_longitude,
                "t_end_latitude"=>$end_latitude,
                "t_end_longitude"=>$end_longitude,
                "t_status"=>1,
                "t_active_status"=>1,
                "t_add_by" => $customer_id,
                "t_source_address"=>$sourceAddress,
                "t_destination_address" => $destAddress,    
                "t_add_date" =>date("Y-m-d"),
            ));
            $saveBookFareId = $this->book_trip_fare_model->addBookingFareApi(array(
                "b_t_f_trip_id" => $trip_id,
                "b_t_f_user_id" => $customer_id,
                "b_t_f_fare" => $tripFare,
                "b_t_f_status" => 1,
                "b_t_f_add_by" => $customer_id,
                "b_t_f_date" =>date("Y-m-d"),
            ));
            
            $saveData = $this->book_trip_link_model->addConfirmBookingApi(array(
                "b_l_t_trip_id" => $trip_id,
                "b_l_t_customer_id" => $customer_id,
                "b_l_t_reciver_id" => 1,
                "b_l_t_vehicle_type" => $vehicleType,
                "b_l_t_goodsType_id" => $goodsType_id,
                "b_l_t_fare_id" => $saveBookFareId,
                "b_l_t_coupon_id" => $cupan_id,
                "b_l_t_status" => 1,
                "b_l_t_active_status" => 1,
                "b_l_t_trip_status" => 'TRIP_NEW',
                "b_l_t_add_by" => $customer_id,
                "b_l_t_date" =>date("Y-m-d"),
            ));
            if (($saveData) && ($saveBookFareId) && ($trip_id)) {
                
    //==================push notification start====================// 
    if($userDetails){        
        $this->load->model("mobile_token_model");
        $bookTripData = $this->book_trip_link_model->getBookTripDataByTripId($trip_id);
      //  echo '<pre>' ;print_r($bookTripData->t_end_latitude); die;
      $mobileTokenData = $this->mobile_token_model->getMobileTokenData();
      //$token =array();
       
       // echo '<pre>' ;print_r($mobileTokenData); die;
      
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
  
   $msg = array
(
	'message' 	=> 'here is a message. message',
//	'message' => json_decode($payload_info)->aps->alert,
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);

$fields = array
(
    'registration_ids' => $mobileTokenData,
    'data' => array(
                'message' => 'Trip Add By Customer: ',
                'customer' => $userDetails->Name,
                'mobile' => $userDetails->Mobile, 
                'tripId' => $bookTripData->b_l_t_trip_id, 
                'source' => $bookTripData->t_source_address, 
                'destination' => $bookTripData->t_destination_address,
                'type' => $bookTripData->b_l_t_trip_status,
            ),
    'priority' => 'high'
    
);
//echo '<pre>' ;print_r(json_encode( $fields )); die;
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );
}
// echo $result;






 //==================push notification End====================//               
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'bookIdCode'=>$t_trip_id,
                    'bookId'=>$trip_id
                        ], REST_Controller::HTTP_OK);
            }
            else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            } else {
                if($roleId!=2){
                $this->set_response([
                    'status' => false,
                    'message' => 'You are not MillUser',
                        ], REST_Controller::HTTP_BAD_REQUEST);
                }
                if($roleId!=4){
                $this->set_response([
                    'status' => false,
                    'message' => 'You are not Customer',
                        ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }
    
    
    
    
    
    //  function sendNotification()
    // {
    //     $token = 'cE2ay0bokdA:APA91bHA1Z-aJHVrFS9ILNQQIw25h3bLXbJWv80Ze9NztSeXXcUp5wJBL2G79kByKm0yNyS8325h7v1aI146NtumXHwElWCdRKup6A7TROQc7d86vBM22BJXiNshrMQE7YqcvNmas8c0'; // push token
    //     $message = "Test notification message";

    //     $this->load->library('fcm');
    //     $this->fcm->setTitle('Test FCM Notification');
    //     $this->fcm->setMessage($message);

    //     /**
    //      * set to true if the notificaton is used to invoke a function
    //      * in the background
    //      */
    //     $this->fcm->setIsBackground(true);

    //     /**
    //      * payload is userd to send additional data in the notification
    //      * This is purticularly useful for invoking functions in background
    //      * -----------------------------------------------------------------
    //      * set payload as null if no custom data is passing in the notification
    //      */
    //     $payload = array('notification' => '');
    //     $this->fcm->setPayload($payload);

    //     /**
    //      * Send images in the notification
    //      */
    //     $this->fcm->setImage('https://firebase.google.com/_static/9f55fd91be/images/firebase/lockup.png');

    //     /**
    //      * Get the compiled notification data as an array
    //      */
    //     $json = $this->fcm->getPush();

    //     $p = $this->fcm->send($token, $json);

    //     print_r($p);
        
    //     echo '<pre>' ;print_r($p) ;die;
    // }
    
   function acceptBookTrip_post() {
        $error = "";
        $bookTripId = $this->post('tripId');
        $userId = $this->post('driverId');
        $tripStatus = $this->post('TRIP_STATS');
        $updatedAt = $this->post('updatedAt');
        $Otp=rand(10000, 99999);
    if($tripStatus == 'TRIP_ACCEPTED'){
        $drive_rAccept_Only_One = 1;
    } else {
        $drive_rAccept_Only_One = 0; 
    }
        
        if (empty($bookTripId)) {
            $error = "please provide trip id";
        } else if (empty($userId)) {
            $error = "please provide driver id";
        }  else if (empty($tripStatus)) {
            $error = "please provide trip Status";
         
        }  else if (empty($updatedAt)) {
            $error = "please provide time";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
              $this->load->model("book_trip_link_model");
              $this->load->model("accept_booking_trip_model");
              $this->load->model("user_model");
              $this->load->model("assign_vehicle_to_driver_model");
              $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
              
              if($checkRole[0]->Role_Id==3){
              $driverData = $this->assign_vehicle_to_driver_model->geDriverDetailsById($userId); 
              
               $accepOnlyOneDriver = $this->accept_booking_trip_model->getAcceptTripOnlyOneAccept($bookTripId);
               
               if($accepOnlyOneDriver){
                   $only1Accept = $accepOnlyOneDriver[0]->a_b_t_accept_driver_status;
                   if($only1Accept==1){
                       
                $this->set_response([
                    'status' => false,
                    'message' => "One Driver All ready Accepted",
                        ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                   
               } else {
              
              if($driverData){
                $atripData = $this->accept_booking_trip_model->getAcceptTripData($bookTripId,$userId);
           
                if($atripData){
                
                $acceptTripData = $this->accept_booking_trip_model->updateAcceptBooking(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_otp" => $Otp,
                "a_b_t_otp_status" =>0,
                 "a_b_t_accept_driver_status" =>$drive_rAccept_Only_One,
                "a_b_t_updatedAt"=>$updatedAt,
                "a_b_t_status" => 1,
                ),$bookTripId,$userId);
            }else {
                $acceptTripData = $this->accept_booking_trip_model->getAcceptBookingTripApi(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus, 
                "a_b_t_otp" => $Otp,
                "a_b_t_otp_status" =>0,
                "a_b_t_status" => 1,
                 "a_b_t_accept_driver_status" =>$drive_rAccept_Only_One,
                "a_b_t_add_by" => $userId,
                "a_b_t_updatedAt"=>$updatedAt,
                "a_b_t_date" => date("Y-m-d")
                )); 
            }
                    
                    if($tripStatus=='TRIP_REJECTED'){
                        $rateTripStatus = $this->book_trip_link_model->updateBookingStatusApi(array(
                             "b_l_t_status" => 4,
                             "b_l_t_edit_by" => $userId,
                             "b_l_t_rating_status"=>1,
                         ),$bookTripId);
                    }
                    
                    if($tripStatus=='TRIP_ACCEPTED'){
                    $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
                        "b_l_t_status"=>1,
                        "b_l_t_vehicle_id"=>$driverData->a_v_t_d_vehicle_id,
                        "b_l_t_driver_id"=>$driverData->a_v_t_d_driver_id,
                    ),$bookTripId);
                    }
                   
             }
             
             
        //echo '<pre>' ; print_r($bookStatusUpdate) ;die;
        
        
                        
                //==================push notification start====================//
        $tripData = $this->book_trip_link_model->getBookTripDetailsByTripIdApi($bookTripId,$userId);
    
    
    if($tripData){    
        $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($tripData['customerId']);
        
    
        if($customerMobileToken){  
   define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
 
    switch ($tripStatus) {
    case "TRIP_ACCEPTED":
     $fields = array('registration_ids' => $customerMobileToken,
     'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'otp'=>$tripData['otp'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );
    break;
    case "TRIP_REJECTED":
    $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
    );
    break;
      
   }
   
   //echo '<pre>' ; print_r($fields) ;die;
   $headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    curl_exec($ch );
    curl_close( $ch );
   // echo $result; die;
     } 
    }
//==================push notification End====================// 

$customerData = $this->book_trip_link_model->getBookTripCustomerDetailsByTripIdApi($bookTripId,$userId);
        if ($acceptTripData) {
            $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'customerDetails'=>$customerData
                        ], REST_Controller::HTTP_OK);
            }
             else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            
               }
              
           }else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not a driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function startTripDriver_post() {
        $error = "";
        $userId = $this->post('userId');
        $bookTripId = $this->post('bookTripId');
        $startTime = $this->post('startTime');
        $startDate = $this->post('startDate');
        $tripStatus = $this->post('tripStatus');
        if (empty($bookTripId)) {
            $error = "please provide book trip id";
        } else if (empty($startTime)) {
            $error = "please provide start time";
        } else if (empty($startDate)) {
            $error = "please provide start date";
        } 
        else if (empty($userId)) {
            $error = "please provide user id";
        } else if (empty($tripStatus)) {
            $error = "please provide trip status";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("accept_booking_trip_model");
            $this->load->model("user_model");
            $this->load->model("assign_vehicle_to_driver_model");
            $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
            if($checkRole[0]->Role_Id==3){
                $bookTripData = $this->book_trip_link_model->getBookTripDataById($bookTripId);
             if($bookTripData){
             $booktrip_id= $bookTripData[0]->b_l_t_id;
             $updateData = $this->accept_booking_trip_model->addStartTripByDriverApi(array(
                "a_b_t_start_time" => $startTime,
                "a_b_t_start_date" => $startDate,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_add_by" => $userId,
                ),$booktrip_id,$userId);
             $driverData = $this->assign_vehicle_to_driver_model->geDriverTripStartData($userId,$bookTripId); 
              if($driverData){
                  $vehicleId=$driverData['vehicleId'];
                  if($tripStatus=='TRIP_START'){
            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
                "b_l_t_status"=>2,
                "b_l_t_vehicle_id"=>$vehicleId,
            ),$bookTripId);
                  }
                  
                  
            if (($updateData) && ($bookStatusUpdate)) {
                $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverData['customerId']);
         if($customerMobileToken){  
        
        
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
 
$fields = array
(
    'registration_ids' => $customerMobileToken,
     'priority' => 'high',
    'data' => array(
                'message' => $tripStatus,
                'startTime' => $driverData['satrtTime'],
                'startDate' => $driverData['startDate'],
                'driver' => $driverData['driverName'],
                'mobile' => $driverData['driverMobile'], 
                'type' => $tripStatus, 
            )
   
    );
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );
//echo $result;
}
 //==================push notification End====================// 
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'startTripDetails'=>$driverData
                        ], REST_Controller::HTTP_OK);
            }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
         } else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function noResponceByDriver_post() {
        $error = "";
        $userId = $this->post('userId');
        $bookTripId = $this->post('bookTripId');
        $tripStatus = $this->post('tripStatus');
        if (empty($bookTripId)) {
            $error = "please provide book trip id";
        } else if (empty($userId)) {
            $error = "please provide user id";
        } else if (empty($tripStatus)) {
            $error = "please provide trip status";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("accept_booking_trip_model");
            $this->load->model("user_model");
            $this->load->model("assign_vehicle_to_driver_model");
            $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
            if($checkRole[0]->Role_Id==3){
                $bookTripData = $this->book_trip_link_model->getBookTripDataById($bookTripId);
             if($bookTripData){
                 $atripData = $this->accept_booking_trip_model->getAcceptTripData($bookTripId,$userId);
           
            if($atripData){
                $noResponceTripData = $this->accept_booking_trip_model->updateAcceptBooking(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_status" => 1,
                ),$bookTripId,$userId);
            }else {
                $noResponceTripData = $this->accept_booking_trip_model->getAcceptBookingTripApi(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus,    
                "a_b_t_status" => 1,
                "a_b_t_add_by" => $userId,
                "a_b_t_date" => date("Y-m-d")
                )); 
            }
             
             $driverData = $this->assign_vehicle_to_driver_model->geNoResponceData($userId,$bookTripId); 
              if($driverData){
                  $vehicleId=$driverData['vehicleId'];
//                  if($tripStatus=='TRIP_NORESPONCE'){
//            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
//                "b_l_t_status"=>4,
//                "b_l_t_vehicle_id"=>$vehicleId,
//            ),$bookTripId);
//                  }
                   
                  
            if ($noResponceTripData) {
                $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverData['customerId']);
         if($customerMobileToken){  
        
        
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
   $msg = array
(
	'message' 	=> 'here is a message. message',
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);
$fields = array
(
    'registration_ids' => $customerMobileToken,
    'priority' => 'high',
    'data' =>  array(
                'message' => $tripStatus,
                'driver' => $driverData['driverName'],
                'mobile' => $driverData['driverMobile'], 
                'type' => $tripStatus, 
            )
);
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );

//echo $result;
}
 //==================push notification End====================// 
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'noResponceData'=>$driverData
                        ], REST_Controller::HTTP_OK);
            }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
         } else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    function endTripDriver_post() {
        $error = "";
        $userId = $this->post('userId');
        $bookTripId = $this->post('bookTripId');
        $endTime = $this->post('endTime');
        $endDate = $this->post('endDate');
        $tripStatus = $this->post('tripStatus');
        if (empty($bookTripId)) {
            $error = "please provide book trip id";
        } else if (empty($endTime)) {
            $error = "please provide end time";
        } else if (empty($endDate)) {
            $error = "please provide end date";
        } 
        else if (empty($userId)) {
            $error = "please provide user id";
        } else if (empty($tripStatus)) {
            $error = "please provide trip status";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("accept_booking_trip_model");
            $this->load->model("user_model");
            $this->load->model("assign_vehicle_to_driver_model");
            $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
            if($checkRole[0]->Role_Id==3){
                $bookTripData = $this->book_trip_link_model->getBookTripDataById($bookTripId);
             if($bookTripData){
             $booktrip_id= $bookTripData[0]->b_l_t_id;
             $updateData = $this->accept_booking_trip_model->addStartTripByDriverApi(array(
                "a_b_t_end_time" => $endTime,
                "a_b_t_end_date" => $endDate,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_add_by" => $userId,
                ),$booktrip_id,$userId);
             $driverData = $this->assign_vehicle_to_driver_model->geDriverTripEndData($userId,$bookTripId); 
              if($driverData){
            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
                "b_l_t_status"=>3,
            ),$bookTripId);
            if (($updateData) && ($bookStatusUpdate)) {
                $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverData['customerId']);
         if($customerMobileToken){  
        
        
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
   $msg = array
(
	'message' 	=> 'here is a message. message',
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);
$fields = array
(
    'registration_ids' => $customerMobileToken,
    'priority' => 'high',
    'data' => array(
                'message' => $tripStatus,
                'endTime' => $driverData['endTime'],
                'endDate' => $driverData['endDate'],
                'driver' => $driverData['driverName'],
                'driver' => $driverData['driverName'],
                'mobile' => $driverData['driverMobile'], 
                'type' => $tripStatus, 
            )
        
    
);
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );

//echo $result;
}
 //==================push notification End====================// 
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'endTripDetails'=>$driverData
                        ], REST_Controller::HTTP_OK);
            }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
         } else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    
    function cancelTripReason_post(){
        $error = "";
        $customer_id = $this->post('userId');
        if (empty($customer_id)) {
            $error = "please provide user id";
        }
        $this->load->model("cancel_trip_reason_model");
        $this->load->model("user_model");
         $roleData = $this->user_model->getUserDetailsById($customer_id);
         $roleId = $roleData->Role_Id;
        // echo '<pre>' ;print_r($roleId);
        if($roleId==4){
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->set_response([
                'status' => true,
                "cancelTripReson" =>  $this->cancel_trip_reason_model->getCancelTripReasonApi(),
                    ], REST_Controller::HTTP_OK);
        }
         } else {
            $this->set_response([
                    'status' => false,
                    'message' => "You are not customer",
                        ], REST_Controller::HTTP_BAD_REQUEST); 
         }
        
    }
    function cancelTripByCustomer_post() {
        $error = "";
        $customer_id = $this->post('userId');
        $cancel_book_trip_id = $this->post('cancelBookId');
        $cancel_reason_id = $this->post('cancelReasonId');
        $cancel_reason_comment = $this->post('cancelReasonComment');
        if (empty($customer_id)) {
            $error = "please provide user id";
        } else if (empty($cancel_book_trip_id)) {
            $error = "please provide trip id";
        } else if (empty($cancel_reason_id)) {
            $error = "please provide cancel reson id";
        } else if (empty($cancel_reason_comment)) {
            $error = "please provide cancel reason comment";
        }  
            $this->load->model("user_model");
            $this->load->model("book_trip_link_model");
            $this->load->model("trip_rating_model");
         $roleData = $this->user_model->getUserDetailsById($customer_id);
         $roleId = $roleData->Role_Id;
        if($roleId==4){
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("cancel_trip_reason_model");
            $checkCancelData = $this->cancel_trip_reason_model->getCancelTripDataByUser($cancel_book_trip_id,$customer_id);
           
            if($checkCancelData){
                $c_t_r_c_id = $checkCancelData->c_t_r_c_id;
                $saveData = $this->cancel_trip_reason_model->updateCancelTripReasonCommentApi(array(
                "c_t_r_c_booking_trip_id" => $cancel_book_trip_id,
                "c_t_r_c_user_id" => $customer_id,
                "c_t_r_c_reason_id" => $cancel_reason_id,
                "c_t_r_c_reason_comment" => $cancel_reason_comment,
            ),$c_t_r_c_id);
            } else {
              $saveData = $this->cancel_trip_reason_model->addCancelTripReasonCommentApi(array(
                "c_t_r_c_booking_trip_id" => $cancel_book_trip_id,
                "c_t_r_c_user_id" => $customer_id,
                "c_t_r_c_reason_id" => $cancel_reason_id,
                "c_t_r_c_reason_comment" => $cancel_reason_comment,
                "c_t_r_c_status" => 1,
                "c_t_r_c_add_by" => $customer_id,
                "c_t_r_c_date" =>date("Y-m-d"),
            ));  
            }
            
            
             $cancelTripStatus = $this->book_trip_link_model->updateBookingStatusApi(array(
                 "b_l_t_status" => 4,
                 "b_l_t_edit_by" => $customer_id,
                 "b_l_t_rating_status"=>1,
                 "b_l_t_trip_status"=>'TRIP_CANCELED',
            ),$cancel_book_trip_id);
            
             $chectRatingData = $this->trip_rating_model->getRatingData($customer_id,$cancel_book_trip_id);
            if($chectRatingData){
                $ratingId=$chectRatingData->t_r_id;
            $ratingTripData = $this->trip_rating_model->updateRatingTripByUser(array(
                "t_r_trip_id" => $cancel_book_trip_id,
                "t_r_user_id" => $customer_id,
                "t_r_rate" => 1,
                "t_r_status" => 1,
                "t_r_date" => date("Y-m-d h:i:sa")
            ),$ratingId);
            } else {
             $ratingTripData = $this->trip_rating_model->insertRatingTripByUser(array(
                "t_r_trip_id" => $cancel_book_trip_id,
                "t_r_user_id" => $customer_id,
                "t_r_rate" => 1,
                "t_r_status" => 1,
                "t_r_add_by" => $customer_id,
                "t_r_date" => date("Y-m-d h:i:sa")
            ));   
            }
            
            
            if ($saveData) {
        $checkDriver = $this->book_trip_link_model->getCustomerTripDataByID($cancel_book_trip_id,$customer_id);  
        if($checkDriver){
            $driverId = $checkDriver[0]->b_l_t_driver_id;
            $tripData = $this->book_trip_link_model->getBookTripDetailsByTripIdApi($cancel_book_trip_id,$driverId); 
        if($tripData){
            $this->load->model("mobile_token_model");
            $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($customer_id);
            //echo '<pre>' ;print_r($driverNotificationData['driverName']);die;
        define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );

        
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripData['trip_status'],'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripData['trip_status'],'tripId'=>$tripData['tripId'],'bookingTripCode'=>$tripData['bookingTripCode'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
    );
  
      //echo '<pre>' ;print_r($fields);die;
   
   $headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    curl_exec($ch );
    curl_close( $ch );
    //echo $result; die;
        }      
                
        }
                
                
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveData
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        } else {
            $this->set_response([
                    'status' => false,
                    'message' => "You are not customer",
                        ], REST_Controller::HTTP_BAD_REQUEST); 
         }
    }
    function cancelTripByDriverApi_post() {
        $error = "";
        $driver_id = $this->post('userId');
        $cancel_book_trip_id = $this->post('cancelBookId');
        $cancel_reason_id = $this->post('cancelReasonId');
        $cancel_reason_comment = $this->post('cancelReasonComment');
        $start_latitude = $this->post('sourceLat');
        $start_longitude = $this->post('sourceLong');
        if (empty($driver_id)) {
            $error = "please provide user id";
        } else if (empty($cancel_book_trip_id)) {
            $error = "please provide trip id";
        } else if (empty($cancel_reason_id)) {
            $error = "please provide cancel reson id";
        } else if (empty($cancel_reason_comment)) {
            $error = "please provide cancel reason comment";
        }  else if (empty($start_latitude)) {
            $error = "please provide pickup location";
        } else if (empty($start_longitude)) {
            $error = "please provide pickup location";
        } 
        
         $this->load->model("user_model");
         $this->load->model("trip_rating_model");
         $roleData = $this->user_model->getUserDetailsById($driver_id);
         $roleId = $roleData->Role_Id;
        if($roleId==3){
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("cancel_trip_reason_model");
          
            $checkCancelData = $this->cancel_trip_reason_model->getCancelTripDataByUser($cancel_book_trip_id,$driver_id);
           
            if($checkCancelData){
                $c_t_r_c_id = $checkCancelData->c_t_r_c_id;
                $saveData = $this->cancel_trip_reason_model->updateCancelTripReasonCommentApi(array(
                "c_t_r_c_booking_trip_id" => $cancel_book_trip_id,
                "c_t_r_c_user_id" => $driver_id,
                "c_t_r_c_reason_id" => $cancel_reason_id,
                "c_t_r_c_reason_comment" => $cancel_reason_comment,
                "c_t_r_c_source_lat" => $start_latitude,
                "c_t_r_c_source_long" => $start_longitude,
            ),$c_t_r_c_id);
            } else {
              $saveData = $this->cancel_trip_reason_model->addCancelTripReasonCommentApi(array(
                "c_t_r_c_booking_trip_id" => $cancel_book_trip_id,
                "c_t_r_c_user_id" => $driver_id,
                "c_t_r_c_reason_id" => $cancel_reason_id,
                "c_t_r_c_reason_comment" => $cancel_reason_comment,
                "c_t_r_c_source_lat" => $start_latitude,
                "c_t_r_c_source_long" => $start_longitude,
                "c_t_r_c_status" => 1,
                "c_t_r_c_add_by" => $driver_id,
                "c_t_r_c_date" =>date("Y-m-d"),
            ));  
            }
            $cancelTripStatus = $this->book_trip_link_model->updateBookingStatusApi(array(
                 "b_l_t_status" => 4,
                 "b_l_t_edit_by" => $driver_id,
                 "b_l_t_rating_status"=>1,
            ),$cancel_book_trip_id);
            
            
        $chectRatingData = $this->trip_rating_model->getRatingData($driver_id,$cancel_book_trip_id);
            if($chectRatingData){
                $ratingId=$chectRatingData->t_r_id;
            $ratingTripData = $this->trip_rating_model->updateRatingTripByUser(array(
                "t_r_trip_id" => $cancel_book_trip_id,
                "t_r_user_id" => $driver_id,
                "t_r_rate" => 1,
                "t_r_status" => 1,
                "t_r_date" => date("Y-m-d h:i:sa")
            ),$ratingId);
            } else {
             $ratingTripData = $this->trip_rating_model->insertRatingTripByUser(array(
                "t_r_trip_id" => $cancel_book_trip_id,
                "t_r_user_id" => $driver_id,
                "t_r_rate" => 1,
                "t_r_status" => 1,
                "t_r_add_by" => $driver_id,
                "t_r_date" => date("Y-m-d h:i:sa")
            ));   
            }
             $this->load->model("accept_booking_trip_model");
                $atripData = $this->accept_booking_trip_model->getAcceptTripData($cancel_book_trip_id,$driver_id);
           //echo '<pre>' ;print_r($atripData);die;
            if($atripData){
                $noResponceTripData = $this->accept_booking_trip_model->updateAcceptBooking(array(
                "a_b_t_booking_trip_id" => $cancel_book_trip_id,
                "a_b_t_accept_status" => 'TRIP_CANCELED',
                "a_b_t_status" => 1,
                "a_b_t_edit_by" => $driver_id,
                ),$cancel_book_trip_id,$driver_id);
            }else {
                $noResponceTripData = $this->accept_booking_trip_model->getAcceptBookingTripApi(array(
                "a_b_t_booking_trip_id" => $cancel_book_trip_id,
                "a_b_t_driver_id" => $driver_id,
                "a_b_t_accept_status" =>'TRIP_CANCELED',   
                "a_b_t_status" => 1,
                "a_b_t_add_by" => $driver_id,
                "a_b_t_date" => date("Y-m-d")
                )); 
            }
            
            
            
            if ($saveData) {
                
                
               //==================push notification start====================// 
               
               $checkCustomerData = $this->book_trip_link_model->getViewTripDataById($cancel_book_trip_id,$driver_id);  
    if($checkCustomerData){        
        $this->load->model("mobile_token_model");
        $bookTripData = $this->book_trip_link_model->getBookTripDataByTripId($cancel_book_trip_id);
        if($bookTripData){
      //  echo '<pre>' ;print_r($bookTripData->t_end_latitude); die;
      $mobileTokenData = $this->mobile_token_model->getMobileTokenBbydriverId($driver_id);
     
      
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
  $fields = array
(
    'registration_ids' => $mobileTokenData,
    'data' => array(
                'message' => $bookTripData->a_b_t_accept_status,
                'customer' => $checkCustomerData[0]->Name,
                'mobile' => $checkCustomerData[0]->Mobile, 
                'tripId' => $bookTripData->b_l_t_trip_id, 
                'bookTripCode' => $bookTripData->t_trip_id,
                'source' => $bookTripData->t_source_address, 
                'destination' => $bookTripData->t_destination_address,
                'type' => $bookTripData->a_b_t_accept_status,
            ),
    'priority' => 'high'
    
);
//echo '<pre>' ;print_r(json_encode( $fields )); die;
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );
}
}
// echo $result;






 //==================push notification End====================// 
                
                
                
                
                
                
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveData
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
         } else {
            $this->set_response([
                    'status' => false,
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST); 
         }
        
    }
    function NoDriverFound_post() {
        $error = "";
        $user_id = $this->post('userId');
        $bookTripId = $this->post('bookTripId');
        $tripStatus = $this->post('tripStatus');
        if (empty($bookTripId)) {
            $error = "please provide book trip id";
        }  else if (empty($tripStatus)) {
            $error = "please provide trip status";
        }  else if (empty($user_id)) {
            $error = "please provide user id";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $this->load->model("book_trip_link_model");
            $this->load->model("accept_booking_trip_model");
            $this->load->model("user_model");
            $this->load->model("assign_vehicle_to_driver_model");
            $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
//            if($checkRole[0]->Role_Id==3){
                $bookTripData = $this->book_trip_link_model->getBookTripDataById($bookTripId);
             if($bookTripData){
                 $atripData = $this->accept_booking_trip_model->getAcceptTripData($bookTripId,$userId);
           
            if($atripData){
                $noResponceTripData = $this->accept_booking_trip_model->updateAcceptBooking(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                //"a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_status" => 1,
                ),$bookTripId,$userId);
            }else {
                $noResponceTripData = $this->accept_booking_trip_model->getAcceptBookingTripApi(array(
                "a_b_t_booking_trip_id" => $bookTripId,
               // "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus,    
                "a_b_t_status" => 1,
               // "a_b_t_add_by" => $userId,
                "a_b_t_date" => date("Y-m-d")
                )); 
            }
             
             $driverData = $this->assign_vehicle_to_driver_model->geNoResponceData($userId,$bookTripId); 
              if($driverData){
                  $vehicleId=$driverData['vehicleId'];
//                  if($tripStatus=='TRIP_NORESPONCE'){
//            $bookStatusUpdate= $this->book_trip_link_model->updateBookingStatusApi(array(
//                "b_l_t_status"=>4,
//                "b_l_t_vehicle_id"=>$vehicleId,
//            ),$bookTripId);
//                  }
                   
                  
//            if ($noResponceTripData) {
//                $this->load->model("mobile_token_model");
//        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverData['customerId']);
//         if($customerMobileToken){  
//        
//        
//    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
//   $msg = array
//(
//	'message' 	=> 'here is a message. message',
//	'title'		=> 'This is a title. title',
//	'subtitle'	=> 'This is a subtitle. subtitle',
//	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
//	'vibrate'	=> 1,
//	'sound'		=> 1,
//	'largeIcon'	=> 'large_icon',
//	'smallIcon'	=> 'small_icon'
//);
//$fields = array
//(
//    'registration_ids' => $customerMobileToken,
//    'data' => $msg,
//    'priority' => 'high',
//    'notification' => array(
//        'title' => $tripStatus,
//        'body' => array(
//                'message' => $tripStatus,
//                'driver' => $driverData['driverName'],
//                'mobile' => $driverData['driverMobile'], 
//                'type' => $tripStatus, 
//            )
//        
//    )
//);
//$headers = array
//(
//	'Authorization: key=' . API_ACCESS_KEY,
//	'Content-Type: application/json'
//);
// 
//$ch = curl_init();
//curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
//curl_setopt( $ch,CURLOPT_POST, true );
//curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
//curl_exec($ch );
//curl_close( $ch );
//
////echo $result;
//}
 //==================push notification End====================// 
                
                
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'noResponceData'=>$driverData
                        ], REST_Controller::HTTP_OK);
           // }
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
//         } else {
//                $this->set_response([
//                    'status' => false,
//                    'message' => "You are not driver",
//                        ], REST_Controller::HTTP_BAD_REQUEST);
//            }
        }
    }
    
    
    
    function updateDriverLocation_post(){
        $error = "";
        $latitude = $this->post('lat');
        $longitude = $this->post('long');
        $driver_id = $this->post('driverId');
        $this->load->model("driver_location_model");
        $this->load->model("assign_vehicle_to_driver_model");
        $chekDriver = $this->assign_vehicle_to_driver_model->geDriverDetailsById($driver_id);
        if($chekDriver){
       if (empty($latitude)) {
            $error = "please provide latitude";
        } else if (empty($driver_id)) {
            $error = "please provide driver id";
        } else if (empty($longitude)) {
            $error = "please provide longitude";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $saveData = $this->driver_location_model->addDriverLocation(array(
                "d_l_driver_id" => $driver_id,
                "d_l_latitude" => $latitude,
                "d_l_longitude" => $longitude,
                "d_l_delete" =>0,
                "d_l_add_by" =>$driver_id,
                "d_l_date" =>date("Y-m-d"),
            ));
            if ($saveData) {
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'id'=>$saveData
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
         }else {
                $this->set_response([
                    'status' => false,
                    'message' => "Driver not approved",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        
    }
    
     
    function getNearByDriverLocation_get(){
        $this->load->model("assign_vehicle_to_driver_model");
        $this->load->model("driver_location_model");
        $driverData = $this->driver_location_model->getNearByDriverLocation();
        if ($driverData){
            $driverData = $this->driver_location_model->getNearByDriverLocation(); 
            if($driverData){
                $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'nearByLocationData'=>$driverData
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
                 $this->set_response([
                'status' => false,
                'message' => "No driver Found",
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    function addCurrentLocationOfVehicle_post(){
        $error = "";
        $tripId = $this->post('tripId');
        $latitude = $this->post('currentLat');
        $longitude = $this->post('currentLong');
        $driver_id = $this->post('driverId');
        $this->load->model("driver_location_model");
       // $this->load->model("book_trip_link_model");
        $chekDriverData = $this->driver_location_model->getDriverDetails($driver_id,$tripId);
        
        //echo '<pre>' ;print_r($chekDriverData) ;die;
        if($chekDriverData){
       if (empty($latitude)) {
            $error = "please provide latitude";
        } else if (empty($driver_id)) {
            $error = "please provide driver id";
        } else if (empty($longitude)) {
            $error = "please provide longitude";
        }  else if (empty($tripId)) {
            $error = "please provide trip id";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $saveData = $this->driver_location_model->addDriverLocation(array(
                "d_l_trip_id" => $tripId,
                "d_l_driver_id" => $driver_id,
                "d_l_latitude" => $latitude,
                "d_l_longitude" => $longitude,
                "d_l_delete" =>0,
                "d_l_add_by" =>$driver_id,
                "d_l_date" =>date("Y-m-d"),
            ));
            
//==================push notification start====================// 
           
        $this->load->model("mobile_token_model");
        $this->load->model("book_trip_link_model");
        $driverNotificationData = $this->driver_location_model->getDriverDataForNotification($driver_id,$tripId);
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($driverNotificationData['b_l_t_customer_id']);
        //echo '<pre>' ;print_r($driverNotificationData['driverName']);die;
    define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
 $fields = array
(
    'registration_ids' => $customerMobileToken,
    'data' => array(
                'message' => 'Driver Current Location Added',
                'DriverName' => $driverNotificationData['driverName'],
                'DriverMobile' => $driverNotificationData['driverMobile'], 
                'tripId' => $driverNotificationData['tripId'], 
                'driverCurrentLat' => $driverNotificationData['driverCurrentLat'],
                'driverCurrentLong' => $driverNotificationData['driverCurrentLong'],
                'vehicleName' =>  $driverNotificationData['vehicleName'],
            ),
    'priority' => 'high'
    
);
//echo '<pre>' ;print_r(json_encode( $fields ));
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
curl_exec($ch );
curl_close( $ch );

 //echo $result;

 //==================push notification End====================//       


            
            
            
            
            
            if ($saveData) {
                $this->set_response([
                    'status' => true,
                    'message' => 'current location added',
                    'id'=>$saveData
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
         }else {
                $this->set_response([
                    'status' => false,
                    'message' => "Driver not approved",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        
    }
    
    function getCurentLocationOfVehicle_get(){
        $error = "";
        $tripId = $this->post('tripId');
        $currentLat = $this->post('currentLat');
        $currentLong = $this->post('currentLong');
        $driverId = $this->post('driverId');
        $this->load->model("driver_location_model");
        $chekDriverData = $this->driver_location_model->getDriverDetails($driver_id,$tripId);
        if($chekDriverData){
       if (empty($currentLat)) {
            $error = "please provide latitude";
        } else if (empty($driverId)) {
            $error = "please provide driver id";
        } else if (empty($currentLong)) {
            $error = "please provide longitude";
        } else if (empty($tripId)) {
            $error = "please provide trip id";
        } 
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
                "data" => array("vehicle_details" => $this->vehicle_model->getVehicleDetailsApi($ownerId)),
                    ], REST_Controller::HTTP_OK);
        }
    } else {
                 $this->set_response([
                'status' => false,
                'message' => "No driver Found",
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    
    
    }
    
    
  
       function getCustomerCurrentTripStatus_post(){
        $error = "";
        $userId = $this->post('customerId');
        $this->load->model("book_trip_link_model");
        $this->load->model("role_model");
        $roleData = $this->role_model->getroleByUserid($userId);
        $roleId = $roleData->Role_Id;
        //echo '<pre>' ;print_r($roleData->Role_Id);die;
        if($roleId==4){
        if (empty($userId)) {
            $error = "please provide user id";
        } 
         if (isset($error) && !empty($error)) {
            
            echo json_encode($error);
            
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $customerData =$this->book_trip_link_model->getCustomerStatus($userId);
            if($customerData){
            $this->set_response([
                'status' => true,
                "tripStatus" => $this->book_trip_link_model->getCustomerStatus($userId),
                    ], REST_Controller::HTTP_OK);
            }else {
                $this->set_response([
                    'status' => false,
                    'message' => "No trip accepted by driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }        
        }
        } else {
                $this->set_response([
                    'status' => false,
                    'message' => "Yor are not a customer",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
    
       }
       
    function getDriverCurrentTripStatus_post(){
        $error = "";
        $userId = $this->post('driverId');
        $this->load->model("book_trip_link_model");
        $this->load->model("role_model");
        $roleData = $this->role_model->getroleByUserid($userId);
        $roleId = $roleData->Role_Id;
        //echo '<pre>' ;print_r($roleData->Role_Id);die;
        if(($roleId)==3){
        if (empty($userId)) {
            $error = "please provide user id";
        } 
         if (isset($error) && !empty($error)) {
            
            echo json_encode($error);
            
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
            $driverData =$this->book_trip_link_model->getDriverStatus($userId);
            if($driverData){
            $this->set_response([
                'status' => true,
                "tripStatus" => $this->book_trip_link_model->getDriverStatus($userId),
                    ], REST_Controller::HTTP_OK);
            }else {
                $this->set_response([
                    'status' => false,
                    'message' => "No trip accepted by driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        } else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
    
       }
    
     function updateTripStatusByDriver_post() {
        $error = "";
        $bookTripId = $this->post('trip_id');
        $userId = $this->post('driver_id');
        $tripStatus = $this->post('TRIP_STATS');
        $updatedAt = $this->post('updatedAt');
        if (empty($bookTripId)) {
            $error = "please provide trip id";
        } else if (empty($userId)) {
            $error = "please provide driver id";
        }  else if (empty($tripStatus)) {
            $error = "please provide trip Status";
         
        }  else if (empty($updatedAt)) {
            $error = "please provide time";
        } 
        if (isset($error) && !empty($error)) {
            $this->set_response([
                'status' => false,
                'message' => $error,
                    ], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            return;
        } else {
              $this->load->model("book_trip_link_model");
              $this->load->model("accept_booking_trip_model");
              $this->load->model("user_model");
              $this->load->model("assign_vehicle_to_driver_model");
              
              $checkRole =$this->user_model->getCheckUserRoleByUserId($userId);
              if($checkRole[0]->Role_Id==3){
              $driverData = $this->assign_vehicle_to_driver_model->geDriverDetailsById($userId); 
              if($driverData){
             $atripData = $this->accept_booking_trip_model->getAcceptTripData($bookTripId,$userId);
         // echo '<pre>' ;print_r($driverData);die;
            if($atripData){
                $acceptTripData = $this->accept_booking_trip_model->updateAcceptBooking(array(
                "a_b_t_booking_trip_id" => $bookTripId,
                "a_b_t_driver_id" => $userId,
                "a_b_t_accept_status" => $tripStatus,
                "a_b_t_updatedAt"=>$updatedAt,
                "a_b_t_status" => 1,
                ),$bookTripId,$userId);
                
                if($tripStatus=='RATING'){
                    
                 $updateTripStatus = $this->book_trip_link_model->updateBookingStatusApi(array(
                 "b_l_t_status" => 3,
                 "b_l_t_edit_by" => $userId,
                 "b_l_t_rating_status"=>1,
            ),$bookTripId);
                    
                }
            
          
        
        
                        
    //==================push notification start====================//
    $tripData = $this->book_trip_link_model->getBookTripDetailsByTripIdApi($bookTripId,$userId);
    // echo '<pre>' ;print_r($tripData);die;
    if($tripData){    
        $this->load->model("mobile_token_model");
        $customerMobileToken = $this->mobile_token_model->getCustomerTokenById($tripData['customerId']);
        
       // echo '<pre>' ;print_r($customerMobileToken);die;
        if($customerMobileToken){  
   define( 'API_ACCESS_KEY', 'AAAAC-LH2JY:APA91bHF18YDdTSldhyjKAQO368TLVhHi2Re4kR6tVLWye5_lQirRCxghOMs99qhtZ19NqLIeunrUSrC5SIGDsp1h3W4NIlt6JFWXnwX80LjI13wdz8XM1ZMD-3DbQfg4NSA143KJT9q' );
 
 
    switch ($tripStatus) {
    case "ARRIVED":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );
        
     
        
    case "SEARCHING":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );
    case "TRIP_CANCELED":
        $fields = array(
            'registration_ids' => $customerMobileToken,
            'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );
        break;
    case "PICKEDUP":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );  
    case "DROPPED":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );   
        
     case "INVOICE":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array(
            'message' => $tripData['tripAcceptStatus'],
            'DriverName'=>$tripData['driverName'],
            'DriverImage'=>$tripData['driverImage'],
            'BookTypeId'=>$tripData['tripId'],
            'BookingTripCode'=>$tripData['bookingTripCode'],
            'type'=>$tripData['tripAcceptStatus'],
           
           )
        ); 
       // echo '<pre>' ;print_r($fields);die;
    case "COMPLETED":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );
    case "RATING":
        $fields = array(
        'registration_ids' => $customerMobileToken,
        'priority' => 'high',
        'data' => array('message' => $tripStatus,'driver'=>$tripData['driverName'],'mobile'=>$tripData['driverMobile'],'type'=>$tripStatus,'tripId'=>$tripData['tripId'],'vehicleType'=>$tripData['vehicleType'],'vehicleNumber'=>$tripData['vehicleNumber'],'vehicleImage'=>$tripData['vehicleImage'])
        );
    
        
           
   }
    $headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    curl_exec($ch );
    curl_close( $ch );
  // echo $result; die;
}
}
}




 //==================push notification End====================// 

$customerData = $this->book_trip_link_model->getBookTripCustomerDetailsByTripIdApi($bookTripId,$userId);
        if ($acceptTripData) {
            $this->set_response([
                    'status' => true,
                    'message' => 'success',
                    'customerDetails'=>$customerData
                        ], REST_Controller::HTTP_OK);
            }
             else {
                $this->set_response([
                    'status' => false,
                    'message' => "unable to save the reply. please try again",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
              }
           }else {
                $this->set_response([
                    'status' => false,
                    'message' => "You are not a driver",
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    
   
    
    
     
    
}


