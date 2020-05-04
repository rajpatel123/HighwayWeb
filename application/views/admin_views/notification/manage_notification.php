<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Add Vehicle Type</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
        
       



        <!-- form start -->
        <form role="form" name="add_form" action="<?php echo base_url('admin/vehicleType/create_vehicle_type'); ?>" method="post"  class="form-validation" >
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Message</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="p_n_message" value="<?php echo set_value('p_n_message'); ?>" class="form-control required" id="p_n_message" placeholder="Enter message">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('p_n_message'); ?></span>
                        </div>
                    </div>
                     <div class="col-md-6">
                       <div class="form-group">
                            <label for="Vehicle">Message Status</label>
                            <select name="p_n_one_or_al" class="form-control required" id="p_n_one_or_al">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                 echo "<option value =1>Single User</option>";
                                 echo "<option value =2>Mill User</option>";
                                 echo "<option value =3>Driver</option>";
                                 echo "<option value =4>Customer</option>";
                                 echo "<option value =5>Owner</option>";
                                    
                                
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('vehicle_id'); ?></span>
                        </div>
                    </div>
                    </div>
                
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/vehicle/vehicle-type'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
            </div>
        </form>
        <!-- /.form -->
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" style="margin-top: 25px;">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>notificationMessage</th>
                                <th>Sender Name</th>
                                <th>Reciver Name</th>
                                <th>Role</th>
                                <th>messageStatus</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($single_user as $notification) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                            <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $notification['notificationMessage']; ?></td>
                                   <td><?php echo $notification['sendBy']; ?></td>
                                    <td><?php echo $notification['reciverBY']; ?></td>
                                    <td><?php echo $notification['role']; ?></td>
                                    
                                    <?php if($notification['messageStatus']==1){
                                        $messageStatus='Single User';
                                    } else {
                                       $messageStatus= 'No User';
                                    }
                                    ?>
                                    <td><?php echo $messageStatus; ?></td>
                                   
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>