<?php 

	if (isset($_GET['id'])) {
		$customer = getCustomer($_GET['id'], $db);
		$orders = getOrders($_GET['id'], $db);
		$totalServiceRecords = getTotalServiceRecords($db);
		$admins = getAdmins($db);
	}
	if (isset($_GET['order_id'])) {
		$orderId = $_GET['order_id'];
	}
	if (isset($_GET['service_id'])){
		$service = getService($_GET['service_id'], $db);
	}

	if (isset($_POST['cd-submit'])) {
		if (isset($service)) {
			updateNewService($service['id'], $_POST['tracking_in'], $_POST['type'], $_POST['status'], $_POST['priority'], $_POST['due_date'], $_POST['issue'], $_POST['response'], $_POST['admin_id'], $db);
		} else {
			insertService($_POST['order_number'], $_POST['tracking_in'], $_POST['type'], $_POST['status'], $_POST['priority'], $_POST['due_date'], $_POST['issue'], $_POST['response'], $_POST['admin_id'], $db);
		}
	}
?>
<section id="main-content">
	<section class="wrapper" style="padding-top:20px;">
		<?php

			if (isset($_POST['cd-submit'])) {
				echo '<div id="msg" class="alert">Service Record has been added for order #'.$_POST['order_number'].'</div>';
			}
			if (!isset($customer)) {
				echo '<div id="msg" class="alert">A customer id needs to be specified to add a service record</div>';			
			} else {
		?>
		<div class="row-fluid">
			<div class="col-md-12">
				<div class="col-md-6">
					<h1 style="text-align: left">New Service Record: <small> for <?php echo $customer['first_name'].' '.$customer['last_name']; ?></small></h1>
				</div>
				<div class="col-md-6">
					<h1 style="text-align: right">Service # <?php echo $totalServiceRecords + 1; ?></h1>
				</div>
			</div>
		</div>
		<form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
			<div class="row-fluid">
				<div class="col-md-12">
					<div class="col-md-3">
						<select name="order_number">
							<?php 
								foreach ($orders as $o) {
									echo '<option value="'.$o['id'].'"'.(isset($orderId) && $orderId == $o['order_number'] ? ' selected="true"' : '').'>Order #'.$o['order_number']."</option>";
								}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<select name="product">
							<option value="Marbel Board">Product: Marbel Board</option>
						</select>
					</div>
					<div class="col-md-3">
						<select name="admin_id">
							<option value="">Requires Response from: None</option>
							<?php 
								foreach ($admins as $a) {
									echo '<option value="'.$a['user_id'].'"'.(isset($service) && $service['suggested_response_admin'] == $a['user_id'] ? ' selected="true"' : '').'>Requires Response from '.$a['first_name'].' '.$a['last_name'].' ['.$a['email'].']</option>';
								}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<input type="text" name="tracking_in" placeholder="Tracking Number" <?php if (isset($service)) { echo 'value="'.$service['tracking_in'].'"'; } ?>/>
					</div>
				</div>
			</div>
            <!-- Just a spacer to make it look a little nicer -->
            <div class="row-fluid">
				<div class="col-md-12">
                <br />
                </div>
            </div>
			
            <div class="row-fluid">
				<div class="col-md-12">
					<div class="col-md-3">
						<select name="type">
							<option value="">Service Type: None</option>
							<option value="warrenty"<?php if (isset($service) && strcmp($service['type'], 'warrenty') == 0 ) { echo ' selected="true"'; } ?>>Service Type: Warrenty</option>
							<option value="service"<?php if (isset($service) && strcmp($service['type'], 'service') == 0 ) { echo ' selected="true"'; } ?>>Service Type: Service</option>
							<option value="refund"<?php if (isset($service) && strcmp($service['type'], 'refund') == 0 ) { echo ' selected="true"'; } ?>>Service Type: Refund</option>
						</select>
					</div>
					<div class="col-md-3">
						<select name="status">
							<option value="">Service Status: None</option>
							<option value="pending"<?php if (isset($service) && strcmp($service['status'], 'pending') == 0 ) { echo ' selected="true"'; } ?>>Service Status: Pending</option>
							<option value="inhouse"<?php if (isset($service) && strcmp($service['status'], 'inhouse') == 0 ) { echo ' selected="true"'; } ?>>Service Status: In House</option>
							<option value="onhold"<?php if (isset($service) && strcmp($service['status'], 'onhold') == 0 ) { echo ' selected="true"'; } ?>>Service Status: On Hold</option>
							<option value="finished"<?php if (isset($service) && strcmp($service['status'], 'finished') == 0 ) { echo ' selected="true"'; } ?>>Service Status: Finished</option>
							<option value="shipped"<?php if (isset($service) && strcmp($service['status'], 'shipped') == 0 ) { echo ' selected="true"'; } ?>>Service Status: Shipped</option>
						</select>
					</div>
					<div class="col-md-3">
						<select name="priority">
							<option value="1"<?php if (isset($service) && $service['priority'] == 1 ) { echo ' selected="true"'; } ?>>Priority: Highest</option>
							<option value="2"<?php if (isset($service) && $service['priority'] == 2 ) { echo ' selected="true"'; } ?>>Priority: High</option>
							<option value="3"<?php if (isset($service) && $service['priority'] == 3 ) { echo ' selected="true"'; } ?>>Priority: Medium</option>
							<option value="4"<?php if (isset($service) && $service['priority'] == 4 ) { echo ' selected="true"'; } ?>>Priority: Low</option>
							<option value="5"<?php if (isset($service) && $service['priority'] == 5 ) { echo ' selected="true"'; } ?>>Priority: Lowest</option>
						</select>
					</div>
					<div class="col-md-3">
						<input type="date" name="due_date" placeholder="Due Date" <?php if (isset($service)) { echo ' value="'.date('Y-m-d',$service['due_date']).'"'; } ?>/>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="col-md-12">
					<div class="col-md-6">
						<h1 style="text-align: left">Customer Reported Issues:</h1>
					</div>
					<div class="col-md-6">
						<h1 style="text-align: left">Suggested Issue/Response</h1>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="col-md-12">
					<div class="col-md-6">
						<textarea name="issue" placeholder="Input customer reported issue here"><?php if (isset($service)) { echo $service['issue']; } ?></textarea>
					</div>
					<div class="col-md-6">
						<textarea name="response" placeholder="Awaiting initial response..."><?php if (isset($service)) { echo $service['suggested_response']; } ?></textarea>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="col-md-12">
					<div class="col-md-offset-9 col-md-3">
						<input type="submit" name="cd-submit" class="btn btn-primary btn-lg outline text-center" value="Save Changes">
					</div>
				</div>
			</div>
		</form>
		<?php } ?>
	</section>
</section>