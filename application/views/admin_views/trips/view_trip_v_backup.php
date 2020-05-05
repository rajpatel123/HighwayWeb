<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Content
        <small>View Content </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/trip'); ?>"><i class="fa fa-cogs"></i> Manage Trip</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Content </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <!--<div class="box-header with-border">-->
        <!--    <h3 class="box-title">View Content </h3>-->

        <!--    <div class="box-tools pull-right">-->
        <!--        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
                
        <!--    </div>-->
        <!--</div>-->
        <div style="    padding: 10px;    font-size: 18px;
    color: #4e4e4e;" class="box box-block bg-white">
            <h4>Request details</h4>
            <!--<a href="" class="btn btn-default pull-right">-->
            <!--    <i class="fa fa-angle-left"></i> Back-->
            <!--</a>-->
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">User Name :</dt>
                        <dd class="col-sm-8">
                                                        N/A
                                                    </dd>

                        <dt class="col-sm-4">Provider Name :</dt>
                                                <dd class="col-sm-8">Provider not yet assigned!</dd>
                        
                        <dt class="col-sm-4">Total Distance :</dt>
                        <dd class="col-sm-8">-</dd>

                                                                        
                        <dt class="col-sm-4">OTP :</dt>
                        <dd class="col-sm-8">3557</dd>


                        <dt class="col-sm-4">Pickup Address :</dt>
                        <dd class="col-sm-8">Noida Sector 18, Noida, Uttar Pradesh, India</dd>

                        <dt class="col-sm-4">Drop Address :</dt>
                        <dd class="col-sm-8">-</dd>

                        
                        <dt class="col-sm-4">Ride Status : </dt>
                                                <dd class="col-sm-8">
                            CANCELLED
                        </dd>
                                            </dl>
                </div>
                <div class="col-md-6">
                    <div id="map" style="position: relative; overflow: hidden;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28002.281478917885!2d76.99991379836673!3d28.681114523723693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d05e99a2757a5%3A0x805b990cc78523f6!2sMundka%2C%20New%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1588331611504!5m2!1sen!2sin" width="500" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>

</div>
</section>
