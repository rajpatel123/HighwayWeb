<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>highway <?php echo $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/backend/img/favicon.png">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/iCheck/square/blue.css">

        
    </head>
     <style type="text/css">
     
    .bg-img{background-image: url("<?php echo base_url(); ?>assets/backend/img/admin/highway_login.jpg");background-repeat: no-repeat;}

     #userform .nav-tabs.nav-justified>.active>a, #userform .nav-tabs.nav-justified>.active>a:hover, #userform .nav-tabs.nav-justified>.active>a:focus {
    border: 0;
    background: #F7CA18;
    color: white;
    border-radius: 0;
}
#userform {
    background: rgba(0, 0, 0, 0.8);
    margin: 20px 0 95px 0;
    color: white;
}
#userform .tab-pane h2 {
    margin: 10px 0;
    color: #FFF;
}
#userform .tab-content {
    padding: 20px;
}
.btn-larger:hover, .btn-larger:focus, .btn-larger:active, .btn-larger.active, .open .dropdown-toggle.btn-larger {
    border-color: #F7CA18;
    color: #fff;
    background-color: #F7CA18;
    border-radius: 0;
}
.btn-larger {
    padding: 15px 40px !important;
    border: 2px solid #F7CA18 !important;
    border-radius: 0px !important;
    text-transform: uppercase;
    font-family: 'Helvetica', sans-serif;
    font-size: 18px;
    font-weight: 300;
    color: #F7CA18;
    background-color: transparent;
    -webkit-transition: all .6s;
    -moz-transition: all .6s;
    transition: all .6s;
}
#userform .form-group input.form-control {
    height: auto;
    background-color: rgba(237, 235, 250, 0.1);
    /* color: #FFF; */
}
.logo-section img {
    height: 55px;
    margin-top: 55px;
}
#userform .form-group input, #userform .form-group textarea {
    padding: 10px;
}
.nav>li>a {
    position: relative;
    display: block;
    padding: 20px 15px;
}
     </style>
    <body class="hold-transition login-page">
        

        <!-- /.login-box -->
<div class="bg-img">
    <div class="container">
      <div class="col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-3 col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="logo-section text-center">
                        
<!--    ye change kar lena url dika diay or super admin se login hoga abhi <img width="50px" src="img/logo.png" alt="">-->
                            <img width="50px" src="<?php echo base_url() ?>/assets/backend/img/admin/logo.png" alt="">
                        </div>
                    </div>
                </div>
                <div id="userform">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="active"><a href="#superadmin" role="tab" data-toggle="tab">Super Admin</a></li>
                        <li><a href="#admin" role="tab" data-toggle="tab">Admin</a></li>
                        <li><a href="#driver" role="tab" data-toggle="tab">Driver</a></li>
                        <li><a href="#owner" role="tab" data-toggle="tab">Owner</a></li>
                    </ul>
                    
                     
                    
                     <!--super admin -->
                    <div class="tab-content">
                        <div class="tab-pane fade  active  in" id="superadmin">
                            <h2 class="text-uppercase text-center"> Sign In</h2>
                            <?php
                $success = $this->session->userdata('success');
                
                $exception = $this->session->userdata('exception');
                //echo '<pre>' ;print_r($exception);die;
                if (!empty($success)) {
                    echo "<div class='alert alert-success alert-dismissible' id='message_success'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <span><i class='icon fa fa-check'></i> " . $success . "</span>
                </div>";
                    $this->session->unset_userdata('success');
                } else if (!empty($exception)) {
                    echo "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <span> " . $exception . "</span>
                </div>";
                    $this->session->unset_userdata('exception');
                } else {
                    echo "<div class='alert alert-warning alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <span><i class='icon fa fa-warning'></i> Login in to start your session.</span>
                </div>";
                }
                ?>
                            <form id="login" role="form" method="POST" action="<?php echo base_url('index.php/admin/admin_login/check_admin_login'); ?>">
                                <input type="hidden" name="_token" value="TZFHnsbmi5uRinuPUFwnvbvmNfuXxgElQSyG5CrS">
                                <div class="form-group">
                                    <label>Super Admin E-mail<span class="req">*</span> </label>
                                    <input type="text "placeholder="Username or Email" name="username_or_email_address" class="form-control" id="username_or_email_address" required="" data-validation-required-message="Please enter your email address." autocomplete="off">
                                                                    </div>
                                <div class="form-group">
                                    <label> Password<span class="req">*</span> </label>
                                    <input type="password" placeholder="Password" name="password" class="form-control" id="password" required="" data-validation-required-message="Please enter your password" autocomplete="off">
                                                                    </div>
                                <div class="mrgn-30-top">
                                    <button type="submit" class="btn btn-larger btn-block"> Log in
                                    </button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="details">
                                                                        </div>
                                </div>
                            </div>
                        </div>
                    
                    
                     <!-- admin -->
                        <div class="tab-pane fade  in" id="admin">
                            <h2 class="text-uppercase text-center">Sign In</h2>
                            <form id="login" role="form" method="POST" action="<?php echo base_url('index.php/admin/admin_login/check_login_admin'); ?>">
                             <input type="hidden" name="_token" value="TZFHnsbmi5uRinuPUFwnvbvmNfuXxgElQSyG5CrS">
                                <div class="form-group">
                                    <label>Admin E-mail<span class="req">*</span> </label>
                                    <input type="text "placeholder="Username or Email" name="username_or_email_address" class="form-control" id="username_or_email_address" required="" data-validation-required-message="Please enter your email address." autocomplete="off">
                                                                        </div>
                                <div class="form-group">
                                    <label> Password<span class="req">*</span> </label>
                                    <input type="password" placeholder="Password" name="password" class="form-control" id="password" required="" data-validation-required-message="Please enter your password" autocomplete="off">
                                                                    </div>
                                <div class="mrgn-30-top">
                                    <button type="submit" class="btn btn-larger btn-block"> Log in
                                    </button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="details">
                                                                           </div>
                                </div>
                            </div>
                        </div>
                     
                     <!-- Driver -->
                        <div class="tab-pane fade  in" id="driver">
                            <h2 class="text-uppercase text-center">Sign in</h2>
                            <form id="login" role="form" method="POST" action="<?php echo base_url('index.php/admin/admin_login/check_driver_login'); ?>">
                             <input type="hidden" name="_token" value="TZFHnsbmi5uRinuPUFwnvbvmNfuXxgElQSyG5CrS">
                                <div class="form-group">
                                    <label>Driver Administrator E-mail<span class="req">*</span> </label>
                                    <input type="text "placeholder="Username or Email" name="username_or_email_address" class="form-control" id="username_or_email_address" required="" data-validation-required-message="Please enter your email address." autocomplete="off">
                                                                    </div>
                                <div class="form-group">
                                    <label> Password<span class="req">*</span> </label>
                                    <input type="password" placeholder="Password" name="password" class="form-control" id="password" required="" data-validation-required-message="Please enter your password" autocomplete="off">
                                                                    </div>
                                <div class="mrgn-30-top">
                                    <button type="submit" class="btn btn-larger btn-block"> Log in
                                    </button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="details">
                                                                            </div>
                                </div>
                            </div>
                        </div>
                        <!-- Owner -->
                        <div class="tab-pane fade  in" id="owner">
                            <h2 class="text-uppercase text-center">Sign In</h2>
                            <form id="login" role="form" method="POST" action="<?php echo base_url('index.php/admin/admin_login/check_owner_login'); ?>">
                             <input type="hidden" name="_token" value="TZFHnsbmi5uRinuPUFwnvbvmNfuXxgElQSyG5CrS">
                                <div class="form-group">
                                    <label>Owner Administrator E-mail<span class="req">*</span> </label>
                                    <input type="text "placeholder="Username or Email" name="username_or_email_address" class="form-control" id="username_or_email_address" required="" data-validation-required-message="Please enter your email address." autocomplete="off">
                                                                        </div>
                                <div class="form-group">
                                    <label> Password<span class="req">*</span> </label>
                                    <input type="password" placeholder="Password" name="password" class="form-control" id="password" required="" data-validation-required-message="Please enter your password" autocomplete="off">
                                                                    </div>
                                <div class="mrgn-30-top">
                                    <button type="submit" class="btn btn-larger btn-block"> Log in
                                    </button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="details">
                                                                        </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
    </div>
  </div>
        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
