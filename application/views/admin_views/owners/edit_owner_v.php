<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        owners
        <small>Edit Owner </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/owner'); ?>"><i class="fa fa-cogs"></i> Manage Owner</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Owner </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Owner </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/owner/update_owner/' . $user_data['Id'] . ''); ?>" method="post" class="form-validation" enctype="multipart/form-data"  >
           
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
                            <label for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="Email" value="<?php echo $user_data['Email']; ?>" class="form-control" id="Email" placeholder="Enter email">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('Email'); ?></span>
                        </div>
                    </div>
                       </div>
                
                 <div class="row">
                            <div class="col-md-6">
                        <div class="form-group">
                            <label for="state">State</label>
                            <select name="state" class="form-control required" id="state">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($state as $rows) {
                                      echo '<option value ="'.$rows->s_id.'">'.$rows->state_name.'</option>';
                                    
                                }
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('state'); ?></span>
                        </div>
                    </div>
                    
                    
                      <?php if($user_data['u_city_id']){ ?>
                        <div class="col-md-6">
                     <div class="form-group">
                                <label for="city">City</label>
                                <select name="city" class="form-control required" id="city">
                                    <option value="" selected="" disabled="">select</option>
                                    <?php
                                    foreach ($city as $row) {
                                          echo '<option value ="'.$row->c_id.'">'.$row->city_name.'</option>';

                                    }
                                    ?>
                                </select>
                                <span class="help-block error-message"><?php echo form_error('city'); ?></span>
                        </div>
                        </div>
                   <?php }  else {?>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" class="form-control required" id="city">
                               
                                 <option value="">----------Select City----------</option>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('city'); ?></span>
                        </div>
                    </div>
                     
                      <?php } ?>
                  </div> 
                
                   
                     
                    

                     <div class="row">
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

                    <div class="col-md-6">
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
                            <label for="Aadhar_front">Aadhar Front Picture <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'aadharfrontfile','class'=>'form-control'])?>
                            </div>
                            <div class="input-group">
                                <img src="<?php echo base_url() ?>/assets/backend/img/owner/aadhar/<?php echo $user_data['aadhar_front_image'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label for="Aadhar_back">Aadhar Back Picture<span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'aadharbackfile','class'=>'form-control'])?>
                            </div>
                            <div class="input-group">
                                <img src="<?php echo base_url() ?>/assets/backend/img/owner/aadhar/<?php echo $user_data['aadhar_back_image'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
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
                                <img src="<?php echo base_url() ?>/assets/backend/img/owner/profile/<?php echo $user_data['Image'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                    </div>
                  
             
                <!-- /.row -->
            </div>
             
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/owner'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
           </div>
        <!-- /.form -->
   
</section>
<script>
    /* JQuery to bind City according to State selection */
    $(document).ready(function () {
        $('#state').change(function () {
            var state_id = $('#state').val();
            if (state_id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/owner/fetchcity",
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
    document.forms['edit_form'].elements['Gender'].value = '<?php echo $user_data['Gender']; ?>';
    document.forms['edit_form'].elements['state'].value = '<?php echo $user_data['u_state_id']; ?>';
    document.forms['edit_form'].elements['city'].value = '<?php echo $user_data['u_city_id']; ?>';
</script>