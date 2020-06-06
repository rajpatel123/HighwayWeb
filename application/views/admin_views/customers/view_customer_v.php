<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<section class="content-header">
    <h1>
        Customer
        <small>View Customer </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/customer'); ?>"><i class="fa fa-cogs"></i> Manage Owner</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Customer </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Customer </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <h3 style="text-align: center;">Profile </h3>
                        <?php if ($user_data['Image']) {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/customer/profile/<?php echo $user_data['Image'] ?>" class="img-responsive img-thumbnail" style="min-height: 160px;max-height: 160px;min-width: 220px;max-width: 220px;">
                        <?php } else {?>
                        <img src="<?php echo base_url() ?>/assets/backend/img/admin/pro.jfif" class="img-responsive img-thumbnail">
                         <?php } ?>
                    </div>
                   
                    
                    
                </div>
                <br>
            <div class="col-md-6">
                    <div class="table-responsive panel">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-success"><i class="fa fa-user"></i> Name :</td>
                                    <td class="text-left"><?php echo $user_data['Name']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-user"></i> Mobile :</td>
                                    <td><?php echo $user_data['Mobile']; ?></td>
                                </tr>

                                <tr>
                                    <td class="text-success"><i class="fa fa-envelope-o"></i> Email :</td>
                                    <td><?php echo $user_data['Email']; ?></td>
                                </tr>

                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Address :</td>
                                    <td><?php echo $user_data['Address']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Gender :</td>
                                    <td><?php if($user_data['Gender']==2){
                                        $gender = 'Female';
                                    } else {
                                        $gender ='Male';
                                    }
                                    echo $gender;
                                    
                                    ?></td>
                                </tr>
                                 <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Emergency contact1 :</td>
                                    <td><?php echo $user_data['emergency_contact1']; ?></td>
                                </tr>
                                 <tr>
                                    <td class="text-success"><i class="fa fa-home"></i> Emergency contact2 :</td>
                                    <td><?php echo $user_data['emergency_contact2']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>