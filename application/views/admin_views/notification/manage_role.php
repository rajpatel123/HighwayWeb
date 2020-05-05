<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
        <small><?php echo $title; ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
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
                                <th>Role</th>
                                <th>Status</th>
                                <th>Send Notification</th>
                                <th>User  List</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($role_info as $role_data) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                            <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $role_data['Title']; ?></td>
                                    <td><?php echo $role_data['status']; ?></td>
                                    <td>
                                    <a href="<?php echo base_url('admin/notification/send_notification_role/' . $role_data['Id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Send Notification by role">Send Notification</a>
                                     </td> <td>                     
                                         <a href="<?php echo base_url('admin/notification/manage_user/' . $role_data['Id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="User list">User List</a>

                                    </td>
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