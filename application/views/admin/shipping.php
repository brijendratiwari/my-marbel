<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <div class="col-lg-6">
    
           <div id="orderSuccess" class="pull-left alert alert-success hidden message"></div>
           <div id="orderError" class="pull-left alert alert-danger hidden message"></div>
                 </div>   
                    <div  class="col-lg-4 page-header pull-right">
                        <a href="<?php echo base_url('index.php/shipped'); ?>" class="btn btn-success m-b-sm">Shipped Orders</a></div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Shipping List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="shipping-data" style="width:100% !important;">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Order Date</th>
                                            <th>Shipping Estimate</th>
                                            <th>Last Login</th>
                                            <th>Order Status</th>
                                            <th>W - Color</th>
                                            <th>W - Size</th>
                                            <th>RTY</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
           
        </div>