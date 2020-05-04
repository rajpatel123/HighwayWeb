<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehicle Type
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/vehicleType'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle Type</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Vehicle Type </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
    <div class="table-responsive panel">
    <table class="table">
    <tbody>
        <tr>

        <td class="text-success"><i class="fa fa-user"></i> Vehicle Type :</td>

        <td class="text-left"><?php echo $vehicle_data[0]['v_t_type']; ?></td>
    </tr>

        <tr>
            <td class="text-success"><i class="fa fa-envelope-o"></i>Vehicle Name :</td>
            <td><?php echo $vehicle_data[0]['v_t_vehicle_name']; ?></td>
        </tr>
        <tr>
            <td class="text-success"><i class="fa fa-envelope-o"></i>Vehicle Size :</td>
            <td><?php echo $vehicle_data[0]['v_d_s_dimension_size']; ?></td>
        </tr>
        <tr>
            <td class="text-success"><i class="fa fa-envelope-o"></i>Vehicle Capacity :</td>
            <td><?php echo $vehicle_data[0]['v_l_c_load_capacity']; ?></td>
        </tr>
        <tr>
            <td class="text-success"><i class="fa fa-calendar"></i> Vehicle Per km charge :</td>
            <td><?php echo $vehicle_data[0]['v_t_per_km_charge']; ?></td>
        </tr>
        <tr>
            <td class="text-success"><i class="fa fa-home"></i> Vehicle Night Per km charge  :</td>
            <td><?php echo $vehicle_data[0]['v_t_nigh_charge_per_km']; ?></td>
        </tr>

        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
</section>
