<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Payment History
        <small>Manage Payment History</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Vehicles Type</h3>

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
                                <th>TripId</th>
                                <th>Transation Id</th>
                                <th>Customer</th>
                                <th>Driver</th>
                                <th>Total Amount</th>
                                <th>Pay By Customer</th>
                                <th>Payment Mode</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($fare_info as $user_data) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                            <tr>
                                    <td><?php echo $sl++; ?></td>
<!--                                    <td><?php echo $user_data['bookingId']; ?></td>-->
                                    <td><?php echo $user_data['bookingTripCode']; ?></td>
                                    <td><?php echo '#012334343423'; ?></td>
                                   <td><?php echo $user_data['customerName']; ?></td>
                                    <td><?php echo $user_data['driverName']; ?></td>
                                    <td><?php echo '₹'.$user_data['totalFare']; ?></td>
                                    <td><?php echo '₹'.$user_data['totalFare']; ?></td>
                                    <td><?php echo 'PAYTM' ?></td>
                                   
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