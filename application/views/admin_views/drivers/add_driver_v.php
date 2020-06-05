<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Driver
        <small>Add Driver</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/driver'); ?>"><i class="fa fa-cogs"></i> Manage Drivers</a></li>
        <li><a class="active"><i class="fa fa-cogs"></i> Add Driver</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Add Driver</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
        
       



        <!-- form start -->
        <form role="form" name="add_form" action="<?php echo base_url('admin/driver/create_driver'); ?>" method="post" enctype="multipart/form-data" class="form-validation" >
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
                    
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="License_Number">License Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="License_Number" value="<?php echo set_value('License_Number'); ?>" class="form-control required" id="License_Number" placeholder="Enter license number">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('License_Number'); ?></span>
                        </div>
                    </div>
                    
                   </div>
                
                <div class="row">
                            <div class="col-md-6">
                        <div class="form-group">
                            <label for="state">State</label>
                            <select name="state" class="form-control " id="state">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($state as $rows) {
                                      echo '<option value ="'.$rows->s_id.'">'.$rows->state_name.'</option>';
                                    
                                }
                                ?>
                            </select>
                           
                        </div>
                    </div>
                    
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" class="form-control" id="city">
                               
                                 <option value="">----------Select City----------</option>
                            </select>
                          
                        </div>
                    </div>
                  </div>   
                    
                   
                
                <div class="row">
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
                    
                    </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Email"  class="form-control" id="Email" placeholder="Enter email">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Email'); ?></span>
                        </div>
                    </div>
                    
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
                
                    
                    
                    
                  </div>  
                
                 
                
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Dl_front">Dl Front Image <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'dlfrontfile','class'=>'form-control'])?>
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dl_back">Dl Back Image<span class="required">*</span></label>
                        <div class="input-group">
                            <?php echo form_upload(['name'=>'dlbackfile','class'=>'form-control'])?>
                        </div>
                        <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                    </div>
                </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Aadhar_front">Aadhar Front Image <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'aadharfrontfile','class'=>'form-control'])?>
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Aadhar_back">Aadhar Back Image<span class="required">*</span></label>
                        <div class="input-group">
                            <?php echo form_upload(['name'=>'aadharbackfile','class'=>'form-control'])?>
                        </div>
                        <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                    </div>
                </div>
                </div>
                <div class="row">                   
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="Image"> Profile Image <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'userfile','class'=>'form-control'])?>
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    
                      </div>
                 </div>
                   
            <div class="box-footer">
                <a href="<?php echo base_url('admin/driver'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" value="upload" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
            </div>
        </form>
    </div>
</section>
<script>
    /* JQuery to bind City according to State selection */
    $(document).ready(function () {
        $('#state').change(function () {
            var state_id = $('#state').val();
            if (state_id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/driver/fetchcity",
                    method: "POST",
                    data: { state_id: state_id },
                    success: function (data) {
                        $('#city').html(data);
                    }
                });
            }
            else {
                $('#city').html('<option value="">Select City</option>');
            }
        });
    });
</script>
<script type="text/javascript">
    document.forms['add_form'].elements['Status'].value = '<?php echo set_value('Status'); ?>';
     $(function () {
                $('#datepicker').datetimepicker();
            });
</script>