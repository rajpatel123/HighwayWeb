<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Customer
        <small>Add Customer</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/customer'); ?>"><i class="fa fa-cogs"></i> Manage Customers</a></li>
        <li><a class="active"><i class="fa fa-cogs"></i> Add Customer</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Add Customer</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
        
       



        <!-- form start -->
        <form role="form" name="add_form" action="<?php echo base_url('admin/customer/create_customer'); ?>" method="post"  class="form-validation" enctype="multipart/form-data" >
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Name" value="<?php echo set_value('Name'); ?>" class="form-control required" id="Name" placeholder="Enter name">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Name'); ?></span>
                        </div>
                    </div>
                    <!-- /.col -->
                   
                    
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Gender">Gender Type</label>
                            <select name="Gender" class="form-control required" id="Gender">
                                <option value="" selected="" disabled="">Select one</option>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('Gender'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mobile">Mobile</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Mobile" value="<?php echo set_value('Mobile'); ?>" class="form-control required" id="Mobile" placeholder="Enter mobile">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Mobile'); ?></span>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Address" value="<?php echo set_value('Address'); ?>" class="form-control required" id="Address" placeholder="Enter address">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Address'); ?></span>
                        </div>
                    </div>
                    
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="emergency_contact1">Emergency Contact1</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="emergency_contact1" value="<?php echo set_value('emergency_contact1'); ?>" class="form-control " id="emergency_contact1" placeholder="Enter Emergency Contact1">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('emergency_contact1'); ?></span>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="emergency_contact2">Emergency Contact2</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="emergency_contact2" value="<?php echo set_value('emergency_contact2'); ?>" class="form-control" id="emergency_contact1" placeholder="Enter Emergency Contact2">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('emergency_contact2'); ?></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Email" value="<?php echo set_value('Email'); ?>" class="form-control required" id="Email" placeholder="Enter email">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Email'); ?></span>
                        </div>
                    </div>
                    </div>
                <div class="row">
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userImage">Profile Picture<span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'userfile','class'=>'form-control'])?>
                            </div>
                            
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                </div>
                    
                    

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/customer'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" value="upload" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
            </div>
        </form>
        <!-- /.form -->
    </div>
</section>
<script type="text/javascript">
    document.forms['add_form'].elements['Status'].value = '<?php echo set_value('Status'); ?>';
     $(function () {
                $('#datepicker').datetimepicker();
            });
</script>