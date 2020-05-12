



<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        TRIP DETAILS
        <small>Trip Details </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('owner/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('owner/trip'); ?>"><i class="fa fa-cogs"></i> Manage Trip</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Trip </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div style="    padding: 10px;    font-size: 18px;
    color: #4e4e4e;" class="box box-block bg-white">
            <h3 style="text-align: center">TRIP DETAILS </h3>
            <a href="owner/trip/requestHistory" class="btn btn-default pull-right">
               <i class="fa fa-angle-left"></i> Back 
            </a>
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <?php  if($user_data['t_trip_id']) { ?>
                        <dt class="col-sm-5">Trip ID :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['t_trip_id']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['tripType']) { ?>
                        <dt class="col-sm-5">Trip Type :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['tripType']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['pickupAddress']) { ?>
                        <dt class="col-sm-5">Pickup Address :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['pickupAddress']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['dropAddress']) { ?>
                        <dt class="col-sm-5">Drop Address :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['dropAddress']; ?></dd>
                        <?php } ?>
                            
                        <?php  if($user_data['distance']) { ?>
                        <dt class="col-sm-5">Distance :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['distance'].' KM' ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['basePrice']) { ?>
                        <dt class="col-sm-5">Base Price :</dt>
                        <dd class="col-sm-7"><?php echo '₹ '.$user_data['basePrice'] ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['v_t_gst']) { ?>
                        <dt class="col-sm-5">GST:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['v_t_gst']; ?></dd>
                        <?php } ?>
                        
                         <?php  if($user_data['totalAmount']) { ?>
                        <dt class="col-sm-5">Total Amount:</dt>
                        <dd class="col-sm-7"><?php echo '₹ '.$user_data['totalAmount']; ?></dd>
                        <?php } ?>
                            
                        <?php  if($user_data['tripType']) { ?>
                        <dt class="col-sm-5">TRIP Type :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['tripType']; ?></dd>
                        <?php } ?>
                                                    
                        <?php  if($user_data['t_start_date']) { ?>
                        <dt class="col-sm-5">Trip Start Time :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['t_start_date']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['t_end_date']) { ?>
                        <dt class="col-sm-5">Trip End Date :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['t_end_date']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['t_start_date']) { ?>
                        <dt class="col-sm-5">Trip Start time :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['t_start_time']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['t_end_time']) { ?>
                        <dt class="col-sm-5">Trip End Time :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['t_end_time']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['t_add_date']) { ?>
                        <dt class="col-sm-5">Trip Add Date :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['t_add_date']; ?></dd>
                        <?php } ?>
                            
                        <?php  if($user_data['vehicleType']) { ?>
                        <dt class="col-sm-5">Vehicle Type :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['vehicleType']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['vehicleName']) { ?>
                        <dt class="col-sm-5">Vehicle :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['vehicleName']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['vehicle_dimension_size']) { ?>
                        <dt class="col-sm-5">Dimension Size:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['vehicle_dimension_size']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['vehicle_load_capacity']) { ?>
                        <dt class="col-sm-5">Load Capacity:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['vehicle_load_capacity']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['userName']) { ?>
                        <dt class="col-sm-5">Customer:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['userName']; ?></dd>
                        <?php } ?>
                        
                         <?php  if($user_data['customerMobile']) { ?>
                        <dt class="col-sm-5">Mobile:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['customerMobile']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['driverName']) { ?>
                        <dt class="col-sm-5">Driver:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['driverName']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['driverMobile']) { ?>
                        <dt class="col-sm-5">Mobile:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['driverMobile']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['ownerName']) { ?>
                        <dt class="col-sm-5">Owner:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['ownerName']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['ownerMobile']) { ?>
                        <dt class="col-sm-5">Mobile:</dt>
                        <dd class="col-sm-7"><?php echo $user_data['ownerMobile']; ?></dd>
                        <?php } ?>
                        
                        <?php  if($user_data['tripStatus']) { ?>
                        <dt class="col-sm-5">Status :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['tripStatus']; ?></dd>
                        <?php } ?>
                        
                         <?php  if($user_data['a_b_t_accept_status']) { ?>
                        <dt class="col-sm-5">Trip Status :</dt>
                        <dd class="col-sm-7"><?php echo $user_data['a_b_t_accept_status']; ?></dd>
                        <?php } ?>
                        
                       
                        
                                            </dl>
                </div>
                <div class="col-md-6">
                    <div id="map" style="position: relative; overflow: hidden;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28002.281478917885!2d76.99991379836673!3d28.681114523723693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d05e99a2757a5%3A0x805b990cc78523f6!2sMundka%2C%20New%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1588331611504!5m2!1sen!2sin" width="500" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>

</div>
        </div>
</section>

