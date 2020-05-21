<?php

defined('BASEPATH') OR exit('No direct script access allowed');

?>
<style>
    .col-md-3 {
    width: 22%;
}
.container-fluid {
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
}
.media {
    
    margin-bottom: -7px;
}
.gradient-1:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
.gradient-2:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
.gradient-3:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
.gradient-4:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
</style>

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>
      Dashboard
  </h1>

  <ol class="breadcrumb">

    <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

    <li class="active">Dashboard</li>

  </ol>

</section>

<!-- Main content -->

<section class="content">

  <!-- Small boxes (Stat box) -->
  
<div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">
                                 <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $upcoming; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Upcoming Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                            </div>
                            
                           <a href="">
                           <div class="card gradient-1"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                     <a style="color: #ffffff;" href="<?php echo base_url('admin/trip/trip_by_status/1'); ?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;" class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                        
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $ongoing; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Ongoing Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                            </div>
                            <a href="">
                           <div class="card gradient-2"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                     <a style="color: #ffffff;" href="<?php echo base_url("admin/trip/trip_by_status/2")?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $completed; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Completed Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                            </div>
                            <a href="">
                           <div class="card gradient-3"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                   <a style="color: #ffffff;" href="<?php echo base_url('admin/trip/trip_by_status/3')?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">
                                 <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $cancel; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Cancel Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                            </div>
                            <a href="">
                           <div class="card gradient-4"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                     <a style="color: #ffffff;" href="<?php echo base_url("admin/trip/trip_by_status/4")?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
  
  <!-------------------------->

  <div class="box-body">
            <div class="row">
                <div class="col-md-12" >
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
                    <table id="example2" class="table table-bordered table-striped">
                        <h2>Recent Booking</h2>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($trip_info as $t_data) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                                <tr>
                                
                                
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo ucfirst($t_data['userName']); ?></td>
                                    <td><?php 
                                        if($t_data['b_l_t_status']!=4){
                                             echo "<a href='" . base_url('admin/trip/view_trip/' . $t_data['t_id'] . '') . "'>View Booking Details</a>";;
                                        } else {
                                            echo 'No Details Found';
                                        }
                                ?></td>
                                    <td><?php
                                    $date1=$t_data['t_add_date'];
                                    $date2=date('Y-m-d');
                                    $FromDate = new DateTime($date1);
                                      $ToDate   = new DateTime($date2);
                                      $Interval = $FromDate->diff($ToDate);

                                      $Difference["Weeks"] = floor($Interval->d/7);
                                      $Difference["Days"] = $Interval->d % 7;
                                      $Difference["Months"] = $Interval->m;

                                      //echo '<pre>' ;print_r($Difference);die;
                                      if($Difference["Months"]>0){
                                          $months = $Difference["Months"].' months ';
                                      } else {
                                          $months='';
                                      }

                                      if($Difference["Weeks"]>0){
                                          $weeks = $Difference["Weeks"].' weeks ';
                                      } else {
                                          $weeks='';
                                      }

                                      if($Difference["Days"]>0){
                                          $days = $Difference["Days"].' days ';
                                      } else {
                                          $days='';
                                      }
                                      if($date2==$date1){
                                         $ago = 'Today' ;
                                      } else {

                                      $ago = 'ago';

                                      }

                                      echo $months,$weeks,$days .$ago;
                                    ?></td>
                                    <td><?php echo $t_data['t_add_date']; ?></td>
                                    <td>
                                        <?php if($t_data['b_l_t_status']==4){?>
                                        <p style="background-color:red; color: white;text-align: center;padding: 4px 0 5px;border-radius: 5px; "><?php echo $t_data['tripStatus']; ?></p>
                                        <?php } else { ?>
                                        <p style="background-color: green;color: white;text-align: center;padding: 4px 0 5px;border-radius: 5px;"><?php echo $t_data['tripStatus']; ?></p>
                                        
                                        <?php } ?>
                                        
                                    </td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
        </div>

</section>