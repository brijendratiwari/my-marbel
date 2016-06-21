
<div id="page-wrapper">
    
    
    <div class="row">

       <?php if($this->session->flashdata('error')){ ?>
        <div class="col-md-6 alert alert-danger">
            <?php echo $this->session->flashdata('error');  ?>
        </div>
       <?php } ?>
       <?php if($this->session->flashdata('success')){ ?>
        <div class="col-md-6 alert alert-success">
            <?php echo $this->session->flashdata('success');  ?>
        </div>
       <?php }?>

			<div class="col-md-12">
				<div class="col-md-6">
					<h1 style="text-align: left">New Service Record: <small> for <?php echo $customer['first_name'].' '.$customer['last_name']; ?></small></h1>
				</div>
				<div class="col-md-6">
					<h1 style="text-align: right">Service # <?php echo $totalServiceRecords + 1; ?></h1>
				</div>
			</div>
		<form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
				<div class="col-md-12">
					<div class="col-md-3 form-group">
						<select name="order_number" class="form-control">
							<?php 
                                                               if(!empty($orders)){
								foreach ($orders as $o) {
									echo '<option value="'.$o['id'].'"'.(isset($orderId) && $orderId == $o['order_number'] ? ' selected="true"' : '').'>Order #'.$o['order_number']."</option>";
                                                               }}else{
                                                                   echo '<option value="">No order found</option>';
                                                               }
							?>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<select name="product" class="form-control">
							<option value="Marbel Board">Product: Marbel Board</option>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<select name="admin_id" class="form-control">
							<option value="">Requires Response from: None</option>
                                                        
							<?php 
								foreach ($admins as $a) {
									echo '<option value="'.$a['id'].'"'.(isset($service) && $service['suggested_response_admin'] == $a['id'] ? ' selected="true"' : '').'>Requires Response from '.$a['first_name'].' '.$a['last_name'].' ['.$a['email'].']</option>';
								}
							?>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<input type="text" name="tracking_in" placeholder="Tracking Number" <?php if (isset($service)) { echo 'value="'.$service['tracking_in'].'"'; } ?> class="form-control"/>
					</div>
				</div>
        
			
				<div class="col-md-12 ">
					<div class="col-md-3 form-group">
						<select name="type" class="form-control">
							<option value="">Service Type: None</option>
							<option value="warrenty"<?php if (isset($service) && strcmp($service['type'], 'warrenty') == 0 ) { echo ' selected="true"'; } ?>>Service Type: Warrenty</option>
							<option value="service"<?php if (isset($service) && strcmp($service['type'], 'service') == 0 ) { echo ' selected="true"'; } ?>>Service Type: Service</option>
							<option value="refund"<?php if (isset($service) && strcmp($service['type'], 'refund') == 0 ) { echo ' selected="true"'; } ?>>Service Type: Refund</option>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<select name="status" class="form-control">
							<option value="">Service Status: None</option>
							<option value="pending"<?php if (isset($service) && strcmp($service['status'], 'pending') == 0 ) { echo ' selected="true"'; } ?>>Service Status: Pending</option>
							<option value="inhouse"<?php if (isset($service) && strcmp($service['status'], 'inhouse') == 0 ) { echo ' selected="true"'; } ?>>Service Status: In House</option>
							<option value="onhold"<?php if (isset($service) && strcmp($service['status'], 'onhold') == 0 ) { echo ' selected="true"'; } ?>>Service Status: On Hold</option>
							<option value="finished"<?php if (isset($service) && strcmp($service['status'], 'finished') == 0 ) { echo ' selected="true"'; } ?>>Service Status: Finished</option>
							<option value="shipped"<?php if (isset($service) && strcmp($service['status'], 'shipped') == 0 ) { echo ' selected="true"'; } ?>>Service Status: Shipped</option>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<select name="priority" class="form-control">
							<option value="1"<?php if (isset($service) && $service['priority'] == 1 ) { echo ' selected="true"'; } ?>>Priority: Highest</option>
							<option value="2"<?php if (isset($service) && $service['priority'] == 2 ) { echo ' selected="true"'; } ?>>Priority: High</option>
							<option value="3"<?php if (isset($service) && $service['priority'] == 3 ) { echo ' selected="true"'; } ?>>Priority: Medium</option>
							<option value="4"<?php if (isset($service) && $service['priority'] == 4 ) { echo ' selected="true"'; } ?>>Priority: Low</option>
							<option value="5"<?php if (isset($service) && $service['priority'] == 5 ) { echo ' selected="true"'; } ?>>Priority: Lowest</option>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<input type="date" id="due_date" name="due_date" placeholder="Due Date" <?php if (isset($service)) { echo ' value="'.date('Y-m-d',$service['due_date']).'"'; } ?> class="form-control"/>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<h1 style="text-align: left">Customer Reported Issues:</h1>
					</div>
					<div class="col-md-6">
						<h1 style="text-align: left">Suggested Issue/Response</h1>
					</div>
				</div>
				<div class="col-md-12 form-group">
					<div class="col-md-6">
						<textarea class="form-control" name="issue" placeholder="Input customer reported issue here"><?php if (isset($service)) { echo $service['issue']; } ?></textarea>
					</div>
					<div class="col-md-6">
						<textarea class="form-control" name="response" placeholder="Awaiting initial response..."><?php if (isset($service)) { echo $service['suggested_response']; } ?></textarea>
					</div>
				</div>
				<div class="col-md-12 form-group">
					<div class="col-md-offset-9 col-md-3">
						<input   type="submit" name="cd-submit" class="btn btn-custom btn-lg" value="Save Changes">
					</div>
				</div>
		</form>
		
        
      
        
        
       
        
</div>
        <script>

$(document).ready(function(){
   
        /* date picker */
            $('#due_date').datepicker({
                
                'format' : 'yyyy-mm-dd' 
            });
})
</script>