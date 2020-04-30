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
                                     <a href="<?php echo base_url('admin/trip/trip_by_status/1'); ?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;" class="fa fa-angle-right"></i></p></a>
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
                                     <a href="<?php echo base_url("admin/trip/trip_by_status/2")?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
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
                                   <a href="<?php echo base_url('admin/trip/trip_by_status/3')?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
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
                                     <a href="<?php echo base_url("admin/trip/trip_by_status/4")?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
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
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>Trip<br>Id</th>
                                <th>Trip<br>Type</th>
                                <th>Trip<br>By</th>
                                <th>Trip<br>User</th>
                                <th>vehicle<br>Name</th> 
                                <th>Driver<br>Name</th> 
                                <th>Owner<br>Name</th> 
                                <th>Trip<br>Status</th> 
                                <th>Trip<br>Start<br>Date</th> 
                                <th>Trip<br>End<br>Date</th> 
                                <th>Added<br>Date</th> 
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($trip_info as $t_data) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                            <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $t_data['t_trip_id']; ?></td>
                                    <td><?php echo $t_data['tripType']; ?></td>
                                    <td><?php echo $t_data['userRole']; ?></td>
                                    <td><?php echo $t_data['userName']; ?></td>
                                    <td><?php echo $t_data['vehicleName']; ?></td>
                                    <td><?php echo $t_data['driverName']; ?></td>
                                    <td><?php echo $t_data['ownerName']; ?></td>
                                    <td><?php echo $t_data['tripStatus']; ?></td>
                                    <td><?php echo $t_data['t_start_date']; ?></td>
                                    <td><?php echo $t_data['t_end_date']; ?></td>
                                    <td><?php echo $t_data['t_add_date']; ?></td>
                                    <td>
                                         <?php
                                        $status = $t_data['t_active_status'];
                                        if ($status == 1) {
                                            echo "<a href='" . base_url('admin/trip/inactive_trip/' . $t_data['t_id'] . '') . "' class='btn btn-block btn-success btn-xs' data-toggle='tooltip' title='Click to inactive'><i class='fa fa-arrow-down'></i>Active</a>";
                                        } else {
                                            echo "<a href='" . base_url('admin/trip/active_trip/' . $t_data['t_id'] . '') . "' class='btn btn-block btn-warning btn-xs' data-toggle='tooltip' title='Click to active'><i class='fa fa-arrow-up'></i>Inactive</a>";
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <a href="<?php echo base_url('admin/trip/edit_trip/' . $t_data['t_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo base_url('admin/trip/view_trip/' . $t_data['t_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo base_url('admin/trip/remove_trip/' . $t_data['t_id'] . '') ?>" class="btn btn-danger btn-xs check_delete" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
        </div>

 