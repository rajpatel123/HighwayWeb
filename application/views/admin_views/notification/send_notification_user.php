<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section style="    margin-top: 74px;" class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Send Notification</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            </div>
        </div>

        <!-- form start -->
        <form role="form" name="add_form" action="<?php echo base_url('admin/notification/create_notification_user/' . $userId . ''); ?>" method="post"  class="form-validation" enctype="multipart/form-data">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Name">Message</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="p_n_message" value="<?php echo set_value('p_n_message'); ?>" class="form-control required" id="p_n_message" placeholder="Enter message">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('p_n_message'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Image">Image<span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name' => 'notificationFile', 'class' => 'form-control']) ?>
                            </div>
                            <span class="help-block error-message"><?php if (isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                </div>


                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/notification'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit"  value="upload" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
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
                                <th>Notification Message</th>
                                <th>Image</th>
                                <th>Send By</th>
                                <th>Recive By</th>
                                <th>Role</th>
                                <th>Message Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($single_user as $notification) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $notification['notificationMessage']; ?></td>
                                     <?php if ($notification['notificationImage']) { ?>
                                        <td><img src="<?php echo base_url() ?>/assets/backend/img/notification/<?php echo $notification['notificationImage'] ?>" style="width: 40px;height: 40px;"></td>
                                        <?php } else { ?>
                                        <td><?php echo'No Image'; ?></td> 
                                    <?php } ?>
                                    <td><?php echo $notification['senderName']; ?></td>
                                    <td><?php echo $notification['reciverName']; ?></td>
                                   
                                    <td><?php echo $notification['role']; ?></td>
                                    <td><?php
                                    if($notification['messageStatus']==1){
                                        $messageStatus = 'Single User';
                                    } else {
                                         $messageStatus = 'No User';
                                    }
                                    echo $messageStatus; ?></td>

                                </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>