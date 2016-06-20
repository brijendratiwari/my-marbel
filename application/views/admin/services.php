<?php
if ($this->input->get('status', TRUE)) {
	$status =$this->input->get('status', TRUE);;
} else {
	$status = 'finished';
}
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <div class="col-lg-6">
    
           <div id="orderSuccess" class="pull-left alert alert-success hidden message"></div>
           <div id="orderError" class="pull-left alert alert-danger hidden message"></div>
                 </div>   
                    <div  class="col-lg-4 page-header pull-right">
                        <a href="?status=pending" class="btn btn-custom <?php if($this->input->get('status') == 'pending'){ echo 'tab-active';} ?>">Pending</a>
			<a href="?status=inhouse" class="btn btn-custom <?php if($this->input->get('status') == 'inhouse'){ echo 'tab-active';} ?>">In House</a>
			<a href="?status=finished" class="btn btn-custom <?php if($this->input->get('status') == 'finished'){ echo 'tab-active';} ?>">Finished</a>
                  </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Service List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <?php  if (strcmp($status, 'finished') == 0) :?>
                                <table class="table table-striped table-bordered table-hover" id="finished-data" style="width:100% !important;">
                                    <thead>
                                        <tr>
                                            
						<th>First Name</th>
						<th>Last Name</th>
						<th>Finished Date</th>
						<th>Tracking Number</th>
						<th>Service Status</th>
                                                <th>Action</th>
                                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    </tbody>
                                </table>
                                <?php  elseif (strcmp($status, 'inhouse') == 0) :?>
                                <table id="inhouse-data" class="table table-striped table-bordered table-hover"">
				<thead>
					<tr>
						
						<th>First Name</th>
						<th>Last Name</th>
						<th>Check in Date</th>
						<th>Priority</th>
						<th>Due Date</th>
						<th>Service Status</th>
                                                <th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		<?php  elseif (strcmp($status, 'pending') == 0) :?>
                                <table id="pending-data" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						
						<th>First Name</th>
						<th>Last Name</th>
						<th>Created Date</th>
						<th>Response</th>
						<th>Inbound Tracking</th>
                                                <th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		<?php endif; ?>
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