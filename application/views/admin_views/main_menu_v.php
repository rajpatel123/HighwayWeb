<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<li class="header">MAIN NAVIGATION</li>

<li class="<?php
if ($active_menu == 'dashboard') {
    echo 'active';
}
?>"><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a></li>


<li class="<?php
if ($active_menu == 'customer') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/customer'); ?>"><i class="fa fa-user"></i> <span> Customer</span></a></li>

<li class="<?php
if ($active_menu == 'owner') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/owner'); ?>"><i class="fa fa-user"></i> <span> Owner</span></a></li>

<li class="<?php
if ($active_menu == 'driver') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/driver'); ?>"><i class="fa fa-user"></i> <span> Driver</span></a></li>

<li class="<?php
if ($active_menu == 'vehicleType') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/vehicleType'); ?>"><i class="fa fa-truck "></i> <span> Vehicle Type</span></a>
</li>

<li class="<?php
if ($active_menu == 'vehicle') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/vehicle'); ?>"><i class="fa fa-truck "></i> <span> Vehicle</span></a>

</li>
<!--<li class="<?php
if ($active_menu == 'assign driver to vehicle') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/assignVehicle'); ?>"><i class="fa fa-truck "></i> <span> Assign Vehicle</span></a>

</li>-->
<li class="<?php
if ($active_menu == 'milluser') {
    echo 'active';
}
?>"><a href="<?php  echo base_url('admin/milluser'); ?>"><i class="fa fa-user"></i> <span> Goods Provider </span></a></li>




<!--<li class="<?php
if ($active_menu == 'trip') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/trip'); ?>"><i class="fa fa-road"></i> <span>Trip</span></a>

</li>-->
<li class="<?php
if ($active_menu == 'requestHistory') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/trip/requestHistory'); ?>"><i class="fa fa-road"></i> <span> Request History</span></a>
</li>

<li class="<?php
if ($active_menu == 'paymentHistory') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/paymentHistory'); ?>"><i class="fa fa-money"></i> <span> Payment History</span></a>
</li>

<li class="<?php
if ($active_menu == 'content') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/content'); ?>"><i class="fa fa-file-text-o "></i> <span> Content</span></a>
</li>


<li class="<?php
if ($active_menu == 'notification') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/notification'); ?>"><i class="fa fa-bell fa-lg "></i> <span> Notification</span></a>
</li>

<!--<li class="<?php
if ($active_menu == 'content/edit_content/1') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/content/edit_content/1'); ?>"><i class="fa fa-server "></i> <span> Privacy Policy</span></a>
</li>


<li class="<?php
if ($active_menu == 'content/edit_content/2') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/content/edit_content/2'); ?>"><i class="fa fa-server "></i> <span> Terms</span></a>
</li>


<li class="<?php
if ($active_menu == 'content/edit_content/3') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/content/edit_content/3'); ?>"><i class="fa fa-server "></i> <span> About Us</span></a>
</li>

<li class="<?php
if ($active_menu == 'content/edit_content/4') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/content/edit_content/4'); ?>"><i class="fa fa-server "></i> <span> Help</span></a>
</li>

<li class="<?php
if ($active_menu == 'content/edit_content/5') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/content/edit_content/5'); ?>"><i class="fa fa-server "></i> <span> FAQ</span></a>
</li>-->

<li data-toggle="collapse" data-target="#new" class="collapsed">
    <a href="#"><i class="fa fa-star"></i> Rating & Review<span class="arrow"></span></a>
 </li>
<ul class="sub-menu collapse" id="new">
                  <li><a href="<?php echo base_url('admin/rating'); ?>"><i class="fa fa-star"></i> Driver Rating<span class="arrow"></span></a></li>
                  <li><a href="<?php echo base_url('admin/rating/customerRating'); ?>"><i class="fa fa-star"></i> Customer Rating<span class="arrow"></span></a></li>
</ul>



  


<!--<li data-toggle="collapse" data-target="#new" class="collapsed">
    <a href="<?php echo base_url('admin/content/edit_content/2'); ?>"><i class="fa fa-server"></i> Privacy Policy <span class="arrow"></span></a>
 </li>
                
    
    <ul class="sub-menu collapse" id="new">
                  <li>New New 1</li>
                  <li>New New 2</li>
                  <li>New New 3</li>
                </ul>-->
                
<li class="<?php
if ($active_menu == 'coupan') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/coupan'); ?>"><i class="fa fa-file-text-o "></i> <span>coupan</span></a>

</li>

<li class="<?php
if ($active_menu == 'coupan') {
    echo 'active';
}
?>"><a href="<?php echo base_url('admin/coupan'); ?>"><i class="fa fa-file-text-o "></i> <span>coupan</span></a>

</li>

                




</ul>
</li>
</ul>
</li> 