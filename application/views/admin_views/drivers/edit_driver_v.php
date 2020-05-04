<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Driver
        <small>Edit Driver </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/driver'); ?>"><i class="fa fa-cogs"></i> Manage Driver</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Driver </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Driver </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/driver/update_driver/' . $user_data['Id'] . ''); ?>" method="post" enctype="multipart/form-data" class="form-validation" >
           
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Name" value="<?php echo $user_data['Name']; ?>" class="form-control required" id="Name" placeholder="Enter name">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Name'); ?></span>
                        </div>
                    </div>
                   
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="License_Number">License Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="License_Number" value="<?php echo $user_data['License_Number']; ?>" class="form-control required" id="License_Number" placeholder="Enter license number">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('License_Number'); ?></span>
                        </div>
                    </div>
                </div>
                    
                    <div class="row">
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="Status">Active Status</label>
                            <select name="Status" class="form-control required" id="Status">
                                <option value="" selected="" disabled="">Select one</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('Status'); ?></span>
                        </div>
                    </div>
                    

                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mobile">Mobile</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Mobile" value="<?php echo $user_data['Mobile']; ?>" class="form-control required" id="Mobile" placeholder="Enter mobile">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Mobile'); ?></span>
                        </div>
                    </div>
                        </div>
                 <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Gender">Gender Type</label>
                            <select name="Gender" class="form-control required" id="Gender">
                                <option value="" selected="" disabled="">Select one</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('Gender'); ?></span>
                        </div>
                    </div>
                    
                   
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Email" value="<?php echo $user_data['Email']; ?>" class="form-control required" id="Email" placeholder="Enter email">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Email'); ?></span>
                        </div>
                    </div>
                  
                </div>
                
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Address" value="<?php echo $user_data['Address']; ?>" class="form-control required" id="Address" placeholder="Enter address">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Address'); ?></span>
                        </div>
                    </div>
                    
                 
                    
                    
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Image">Picture <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'userfile','class'=>'form-control'])?>
                            </div>
                            <div class="input-group">
                                <img src="<?php echo base_url() ?>/assets/backend/img/driver/profile/<?php echo $user_data['Image'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label for="DL">Dl Picture<span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'dlfile','class'=>'form-control'])?>
                            </div>
                            <div class="input-group">
                                <img src="<?php echo base_url() ?>/assets/backend/img/driver/dl/<?php echo $user_data['dl_image'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->
            </div>
                
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/driver'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        
        </div>
        <!-- /.form -->
    </div>
</section>
<script type="text/javascript">
    document.forms['edit_form'].elements['Status'].value = '<?php echo $user_data['Status']; ?>';
    document.forms['edit_form'].elements['Gender'].value = '<?php echo $user_data['Gender']; ?>';
</script>