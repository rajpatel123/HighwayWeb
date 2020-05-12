<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Trips
        <small>Manage Trips</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>

<!-- Main trip -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Trips</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" >
<!--                    <a href="<?php // echo base_url('admin/trip/add_trip'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Trips </a>-->
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
                     <div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
                        <h5 class="mb-1">
                Providers                            </h5> 
            <div class="col-md-12"> 
            <div class="col-md-2">
            <button type="button" class="btn btn-info btn-md pull-left" data-toggle="modal" data-target="#myModal" style="margin-left: -30PX;"><span class="glyphicon glyphicon-trash"></span> Seleted Delete</button>
            </div>

             <div class="col-md-4">

            <form action="" method="GET"> 
            <div class="col-md-6">
            <input type="text" class="form-control col-md-6" name="search" value="">
            </div>
            <div class="col-md-6"> 
            <button type="submit" class="btn btn-success btn-md col-md-6"><span class="glyphicon glyphicon-search" style="font-size: 15px;"></span></button>
            </div> 
            </form>
            </div>
            <div class="col-md-2">
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModalMakeOnline"> Make Provider Online</button>
            </div> 
            <div class="col-md-2">
            <a href="" class="btn btn-primary form-control col-md-6">Download Excel</a>
            </div>
            <div class="col-md-2" style="text-align: right;">
                        <a href="" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>add New Provider</a> 
                        </div> 
            </div>  <br><br> 
            <div id="cus-table-2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap4"><div class="dt-buttons btn-group"><a class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="cus-table-2" href="#"><span>Copy</span></a><a class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="cus-table-2" href="#"><span>Excel</span></a></div><table class="table table-striped table-bordered dataTable dtr-inline collapsed" id="cus-table-2" style="width: 100%;" role="grid">
                <thead>
                    
            <tr role="row"><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 33.5px;">
              <button type="button" id="selectAll" class="main">
                        <span class="sub"></span> All </button></th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 16.5px;">ID</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 45.5px;">Fleet Name</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 46.5px;">Joined At</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 126.5px;">Full Name</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 88.5px;">Mobile</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 51.5px;">Total login Hrs</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 64.5px;">Wallet Balance</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 101.5px;">Total / Accepted / Cancelled</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 81.5px;">Vehicle Type</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 56.5px;">Vehicle Number</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 124.5px;">Documents / Service Type</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;">Status</th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;">Action</th></tr>
                </thead>
                <tbody>                                     
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                <tr role="row" class="odd">
                        <td tabindex="0" style=""><input type="checkbox" class="delete186" data-id="186"></td>
                        <td>1</td>
                        <td>--</td>
                        <td>01 Apr 2020</td>
                        <td>vishesh saxena</td> 
                                                <td>9711204331</td>
                                                <td><a href="">0.00</a></td>
                        <td>0</td> 
                        <td>0 / 0 / 0</td> 
                        <td>HATCHBACK</td>
                        <td>CY98767</td>
                        <td>
                                                            <a class="btn btn-success btn-block" href="">All Set!</a>
                                                    </td>
                        <td style="display: none;">
                                                                                                <label class="btn btn-block btn-warning">No</label>
                                                                                    </td>
                        <td style="display: none;">
                            <div class="input-group-btn">
                                                                <a class="btn btn-success btn-block" href="">Enable</a>
                                                                <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Action                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-search"></i> History</a>
                                    </li>
                                    <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-account"></i> Statements</a>
                                    </li>
                                                                        <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-pencil"></i> Edit</a>
                                    </li>
                                                                        <li>
                                        <form action="" method="POST">
                                            <input type="hidden" name="_token" value="MADpBd5hOucIlgxsSCgxIipwccSWIpSgbNkVAr3m">
                                            <input type="hidden" name="_method" value="DELETE">
                                                                                        <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>Delete</button>
                                                                                    </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr><tr role="row" class="even">
                        <td tabindex="0"><input type="checkbox" class="delete185" data-id="185"></td>
                        <td>2</td>
                        <td>--</td>
                        <td>03 Jan 2020</td>
                        <td>Raj Patel</td> 
                                                <td>8447087821</td>
                                                <td><a href="">0.00</a></td>
                        <td>-9.4</td> 
                        <td>0 / 0 / 0</td> 
                        <td></td>
                        <td></td>
                        <td>
                                                            <a class="btn btn-danger btn-block label-right" href="">Attention! <span class="btn-label">0</span></a>
                                                    </td>
                        <td style="display: none;">
                                                            <label class="btn btn-block btn-danger">N/A</label>
                                                    </td>
                        <td style="display: none;">
                            <div class="input-group-btn">
                                                                <a class="btn btn-danger btn-block" href="">Disable</a>
                                                                <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Action                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-search"></i> History</a>
                                    </li>
                                    <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-account"></i> Statements</a>
                                    </li>
                                                                        <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-pencil"></i> Edit</a>
                                    </li>
                                                                        <li>
                                        <form action="" method="POST">
                                            <input type="hidden" name="_token" value="MADpBd5hOucIlgxsSCgxIipwccSWIpSgbNkVAr3m">
                                            <input type="hidden" name="_method" value="DELETE">
                                                                                        <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>Delete</button>
                                                                                    </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr><tr role="row" class="even">
                        <td tabindex="0"><input type="checkbox" class="delete99" data-id="99"></td>
                        <td>50</td>
                        <td>--</td>
                        <td>01 Jun 2019</td>
                        <td>Juan Ferguson</td> 
                                                <td>8465562222</td>
                                                <td><a href="">0.00</a></td>
                        <td>0</td> 
                        <td>0 / 0 / 0</td> 
                        <td>HATCHBACK</td>
                        <td>4ppo3ts</td>
                        <td>
                                                            <a class="btn btn-success btn-block" href="">All Set!</a>
                                                    </td>
                        <td style="display: none;">
                                                                                                <label class="btn btn-block btn-warning">No</label>
                                                                                    </td>
                        <td style="display: none;">
                            <div class="input-group-btn">
                                                                <a class="btn btn-danger btn-block" href="">Disable</a>
                                                                <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Action                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-search"></i> History</a>
                                    </li>
                                    <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-account"></i> Statements</a>
                                    </li>
                                                                        <li>
                                        <a href="" class="btn btn-default"><i class="fa fa-pencil"></i> Edit</a>
                                    </li>
                                                                        <li>
                                        <form action="" method="POST">
                                            <input type="hidden" name="_token" value="MADpBd5hOucIlgxsSCgxIipwccSWIpSgbNkVAr3m">
                                            <input type="hidden" name="_method" value="DELETE">
                                                                                        <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i>Delete</button>
                                                                                    </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr></tbody> 
                 <tfoot>
                    <tr><th rowspan="1" colspan="1"><button type="button" id="selectAll" class="main">
                        <span class="sub"></span> All </button></th><th rowspan="1" colspan="1">ID</th><th rowspan="1" colspan="1">Fleet Name</th><th rowspan="1" colspan="1">Joined At</th><th rowspan="1" colspan="1">Full Name</th><th rowspan="1" colspan="1">Mobile</th><th rowspan="1" colspan="1">Total login Hrs</th><th rowspan="1" colspan="1">Wallet Balance</th><th rowspan="1" colspan="1">Total / Accepted / Cancelled</th><th rowspan="1" colspan="1">Vehicle Type</th><th rowspan="1" colspan="1">Vehicle Number</th><th rowspan="1" colspan="1">Documents / Service Type</th><th rowspan="1" colspan="1" style="display: none;">Status</th><th rowspan="1" colspan="1" style="display: none;">Action</th></tr>
                </tfoot>
            </table></div> 
            <ul class="pagination">
        
                    <li class="disabled"><span>«</span></li>
        
        
                    
            
            
                                                                        <li class="active"><span>1</span></li>
                                                                                <li><a href="">2</a></li>
                                                                                <li><a href="">3</a></li>
                                                        
        
                    <li><a href="" rel="next">»</a></li>
            </ul>
 
        </div>
    </div>
</div>
                    <!-- /.table -->
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>

