<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>
        Driver
        <small>View Driver </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('owner/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('owner/driver'); ?>"><i class="fa fa-cogs"></i> Manage Driver</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Driver </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Driver </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-lg-2 col-md-3">
                        <img src="<?php echo base_url() ?>/assets/backend/img/driver/profile/<?php echo $user_data['Image'] ?>" class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <img src="<?php echo base_url() ?>/assets/backend/img/driver/dl/<?php echo $user_data['dl_image'] ?>" class="img-responsive img-thumbnail">
                    </div>
                </div>
            <div class="col-md-6">
                    <div class="table-responsive panel">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-success"><i class="fa fa-user"></i> Name :</td>
                                    <td class="text-left"><?php echo $user_data['Name']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-user"></i> Mobile :</td>
                                    <td><?php echo $user_data['Mobile']; ?></td>
                                </tr>

                                <tr>
                                    <td class="text-success"><i class="fa fa-envelope-o"></i> Email :</td>
                                    <td><?php echo $user_data['Email']; ?></td>
                                </tr>

                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Address :</td>
                                    <td><?php echo $user_data['Address']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Owner Name :</td>
                                    <td><?php echo $user_data['OwnerName']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Vehicle Type :</td>
                                    <td><?php echo $user_data['v_type']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Vehicle Number :</td>
                                    <td><?php echo $user_data['v_vehicle_number']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Vehicle Model No :</td>
                                    <td><?php echo $user_data['v_vehicle_model_no']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> License Number :</td>
                                    <td><?php echo $user_data['License_Number']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Vehicle Detail :</td>
                                    <td><?php echo $user_data['v_vehicle_detail']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Vehicle Load Capacity :</td>
                                    <td><?php echo $user_data['v_l_c_load_capacity']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Vehicle Dimension Size :</td>
                                    <td><?php echo $user_data['v_d_s_dimension_size']; ?></td>
                                </tr>
                               

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
