<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehicle
        <small>View Vehicle </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/vehicle'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Vehicle </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Vehicle </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
<div class="box-body">
    
    <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <h3 style="text-align: center;">Vehicle Image </h3>
                        <?php if ($vehicle_data['v_vehicle_Image']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleImage/<?php echo $vehicle_data['v_vehicle_Image'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="http://dev.thehighways.in//assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                    
                    <div class="col-md-3">
                        <h3 style="text-align: center;">RC Image</h3>
                        <?php if ($vehicle_data['v_vehicle_rc']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/rcpic/<?php echo $vehicle_data['v_vehicle_rc'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                    
                    <div class="col-md-3">
                        <h3 style="text-align: center;">Vehicle Front Image </h3>
                        <?php if ($vehicle_data['v_front_image']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleFront/<?php echo $vehicle_data['v_front_image'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                    
                    <div class="col-md-3">
                        <h3 style="text-align: center;">Vehicle Back Image </h3>
                        <?php if ($vehicle_data['v_back_image']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleBack/<?php echo $vehicle_data['v_back_image'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                    
                   
                    
                </div>
                <br>
                
                
                <div class="col-md-6">
                    <div class="table-responsive panel">
                        <table class="table">
                            <tbody>
                                 <tr>

        <td class="text-success"> Vehicle Type :</td>

        <td class="text-left"><?php echo $vehicle_data['v_vehicle_name']; ?></td>
    </tr>

        <tr>
            <td class="text-success">Vehicle Name :</td>
            <td><?php echo $vehicle_data['v_vehicle_name']; ?></td>
        </tr>
        <tr>
            <td class="text-success"></i>Vehicle Number :</td>
            <td><?php echo $vehicle_data['v_vehicle_number']; ?></td>
        </tr>
        <tr>
            <td class="text-success">Chechis Number:</td>
            <td><?php echo $vehicle_data['v_chechis_number']; ?></td>
        </tr>
        <tr>
            <td class="text-success"> Vehicle Model :</td>
            <td><?php echo $vehicle_data['v_vehicle_model_no']; ?></td>
        </tr>
        <tr>
            <td class="text-success"> Vehicle Details  :</td>
            <td><?php echo $vehicle_data['v_vehicle_detail']; ?></td>
        </tr>

                                
                               

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                 <div class="col-md-6">
                        <h3 style="text-align: center;">Vehicle Left Image </h3>
                        <?php if ($vehicle_data['v_left_image']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleLeft/<?php echo $vehicle_data['v_left_image'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                 <div class="col-md-6">
                        <h3 style="text-align: center;">Vehicle Right Image </h3>
                        <?php if ($vehicle_data['v_right_image']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleRight/<?php echo $vehicle_data['v_right_image'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                 <div class="col-md-6">
                        <h3 style="text-align: center;">Vehicle Engine </h3>
                        <?php if ($vehicle_data['v_engine_image']) {?>
                           <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleEngine/<?php echo $vehicle_data['v_engine_image'] ?>" class="img-responsive img-thumbnail">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                </div>
                
</div>
</div>
</div>
</section>
