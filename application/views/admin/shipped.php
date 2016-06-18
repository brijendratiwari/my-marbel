<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-5">
    
           <div id="orderSuccess" class="pull-left alert alert-success hidden message"></div>
           <div id="orderError" class="pull-left alert alert-danger hidden message"></div>
                 </div>   
                
                <div  class="col-lg-7 text-left form-group page-header"><a class='btn btn-sm btn-success' href="<?php echo base_url('index.php/shipping'); ?>">Shipping Orders</a></div>

            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Shipped List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
<table id="shipped-data" class="table table-bordered table-hover">
			<thead>
				<tr>
					
					<th>First Name</th>
					<th>Last Name</th>
					<th>Order Date</th>
					<th>Tracking Number</th>
					<th>Date Shipped</th>
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