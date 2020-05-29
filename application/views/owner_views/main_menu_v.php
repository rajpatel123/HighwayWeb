<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<li class="header">MAIN NAVIGATION</li>

<li class="<?php
if ($active_menu == 'dashboard') {
    echo 'active';
}
?>"><a href="<?php echo base_url('owner/dashboard'); ?>"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a></li>




<li class="<?php
if ($active_menu == 'driver') {
    echo 'active';
}
?>"><a href="<?php echo base_url('owner/driver'); ?>"><i class="fa fa-user"></i> <span> Driver</span></a></li>


<li class="<?php
if ($active_menu == 'vehicle') {
    echo 'active';
}
?>"><a href="<?php echo base_url('owner/vehicle'); ?>"><i class="fa fa-truck "></i> <span> Vehicle</span></a>

</li>



<li class="<?php
if ($active_menu == 'requestHistory') {
    echo 'active';
}
?>"><a href="<?php echo base_url('owner/trip/requestHistory'); ?>"><i class="fa fa-road"></i> <span> Request History</span></a>
</li>


                




</ul>
</li>
</ul>
</li> 