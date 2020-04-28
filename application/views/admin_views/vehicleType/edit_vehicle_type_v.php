<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        vehicles
        <small>Edit Vehicle Type </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/vehicle/vehicle-type'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Vehicle Type </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Vehicle Type </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/vehicleType/update_vehicle_type/' . $user_data['v_t_id'] . ''); ?>" method="post" class="form-validation" >
           
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_vehicle_name" value="<?php echo $user_data['v_t_vehicle_name'];  ?>" class="form-control required" id="v_vehicle_name" placeholder="Enter vehicle name">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_name'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Vehicle">Vehicle Size</label>
                            <select name="v_t_vehicle_size_id" class="form-control required" id="v_t_vehicle_size_id">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($SizeDropdownData as $row) {
                                 echo '<option value ="'.$row->v_d_s_id.'">'.$row->v_d_s_dimension_size.'</option>';
                                    
                                }
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('vehicle_id'); ?></span>
                        </div>
                    </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Vehicle">Vehicle Load Capacity</label>
                            <select name="v_t_vehicle_load_capacity_id" class="form-control required" id="v_t_vehicle_load_capacity_id">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($LoadCapacityDropdownData as $row) {
                                 echo '<option value ="'.$row->v_l_c_id.'">'.$row->v_l_c_load_capacity.'</option>';
                                    
                                }
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('vehicle_id'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle Based Fare</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_t_fare" value="<?php echo $user_data['v_t_fare'];  ?>" class="form-control required" id="v_t_fare" placeholder="Enter vehicle based fare">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_t_fare'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle per km charge</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_t_per_km_charge" value="<?php echo $user_data['v_t_per_km_charge'];  ?>" class="form-control required" id="v_t_per_km_charge" placeholder="Enter vehicle per km charge">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_t_per_km_charge'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle night charge per km</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_t_nigh_charge_per_km" value="<?php echo $user_data['v_t_nigh_charge_per_km'];  ?>" class="form-control required" id="v_t_nigh_charge_per_km" placeholder="Enter vehicle night charge per km">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_t_nigh_charge_per_km'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle GST</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_t_gst" value="<?php echo $user_data['v_t_gst'];  ?>" class="form-control required" id="v_t_gst" placeholder="Enter vehicle gst">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_t_gst'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle Min KM</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_t_min_km" value="<?php echo $user_data['v_t_min_km'];  ?>" class="form-control required" id="v_t_min_km" placeholder="Enter vehicle min km">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_t_min_km'); ?></span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
                
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/vehicleType'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        <!-- /.form -->
    </div>
    
    
  
</section>
<script type="text/javascript">
    document.forms['edit_form'].elements['v_t_vehicle_size_id'].value = '<?php echo $user_data['v_t_vehicle_size_id']; ?>';
   document.forms['edit_form'].elements['v_t_vehicle_load_capacity_id'].value = '<?php echo $user_data['v_t_vehicle_load_capacity_id']; ?>';
</script>