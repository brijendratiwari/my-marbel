<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-5">
    
           <div id="orderSuccess" class="pull-left alert alert-success hidden message"></div>
           <div id="orderError" class="pull-left alert alert-danger hidden message"></div>
        
                 </div>   

                    <div  class="col-lg-7 text-left form-group page-header"><a class='btn btn-sm btn-custom' href="<?php echo base_url('shipped'); ?>">Shipped Orders</a></div>
                
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
                            <div class="col-lg-12 text-center form-group">
                            <div class="col-lg-2 pull-right">
                               <select id="country-search" class="form-control">
                                    <option value="">By country</option>
                                    <option value="International">International</option>
                                    <option value="North America">North America</option>
                                </select>
                            </div>
                            </div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="shipping-data" style="width:100% !important;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Order Date</th>
                                            <th>Shipping Estimate</th>
                                            <th>Last Login</th>
                                            <th>Order Status</th>
                                            <th>W - Color</th>
                                            <th>W - Size</th>
                                            <th>RTY</th>
                                            <th>Country</th>
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