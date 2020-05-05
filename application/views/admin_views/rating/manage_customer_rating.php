<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.checked {
  color: orange;
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo $title ?>
        <small><?php echo $title ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title ?></h3>

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
                                <th>User Name</th>
                                <th>Rating</th>
                                <th>Date & Time</th>
                                <th>Comments</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($rating_info as $rate_data) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                            <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $rate_data['tripCodeId']; ?></td>
                                    <td><?php echo $rate_data['userName']; ?></td>
                                    <?php if($rate_data['rate']==1){
                                        $rateStar = '<span class="fa fa-star checked"></span>';
                                    } elseif ($rate_data['rate']==2) {
                                    $rateStar = '<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>';
                                    } elseif ($rate_data['rate']==3) {
                                    $rateStar = '<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>';
                                    } elseif ($rate_data['rate']==4) {
                                    $rateStar = '<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>';
                                   
                                    } elseif ($rate_data['rate']==5) {
                                    $rateStar = '<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>'.'<span class="fa fa-star checked"></span>';
                                    } 
                                    ?>
                                    <td><?php echo $rateStar; ?></td>
                                    <td><?php echo $rate_data['dateTime']; ?></td>
                                    <td><?php echo $rate_data['comment']; ?></td>
                                   
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