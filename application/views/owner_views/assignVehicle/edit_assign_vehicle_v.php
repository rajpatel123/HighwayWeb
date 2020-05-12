<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        vehicles
        <small>Edit Assign Vehicle </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('owner/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('owner/assignVehicle'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Assign Vehicle </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Assign Vehicle </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('owner/assignVehicle/update_assign_vehicle/' . $user_data[0]['a_v_t_d_id'] . ''); ?>" method="post" class="form-validation" >
           
            <div class="box-body">
                 <div class="row">
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="driver">Driver Name  : </label>
                                 <?php echo $user_data[0]['Name'] ?>
                           
                        </div>
                    </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="Vehicle">Vehicle</label>
                            <select name="vehicle" class="form-control required" id="vehicle">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                               
                                foreach ($vehicleData as $row) {
                                 echo '<option value ="'.$row['v_Id'].'">'.ucwords($row['v_type']).' '.$row['v_vehicle_number'].'</option>';
                                    
                                }
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('vehicle'); ?></span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('owner/vehicleType'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        <!-- /.form -->
    </div>
</section>
<script type="text/javascript">
    document.forms['edit_form'].elements['vehicle'].value = '<?php echo $user_data[0]['a_v_t_d_vehicle_id']; ?>';
</script>