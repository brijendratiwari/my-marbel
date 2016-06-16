<?php
if (isset($_POST['cd-email'], $_POST['cd-address'], $_POST['cd-number'], $_POST['cd-address2'], $_POST['cd-city'], $_POST['cd-state'], $_POST['cd-zip'], $_POST['cd-country'], $_POST['cd-status'], $_POST['cd-invoice'], $_POST['cd-date'], $_POST['cd-est-ship-date'], $_POST['cd-product'], $_POST['cd-wheel-color'], $_POST['cd-wheel-size'], $_POST['cd-firmware'], $_POST['cd-deck'], $_POST['cd-main-serial'], $_POST['cd-tracking'], $_POST['cd-notes'])) {
	$email = $_POST['cd-email'];
	$order_number = $_POST['cd-number'];
	$delivery_address = $_POST['cd-address'];
	$delivery_address_2 = $_POST['cd-address2'];
	$city = $_POST['cd-city'];
	$state = $_POST['cd-state'];
	$zip = $_POST['cd-zip'];
	$country = $_POST['cd-country'];
	$status = $_POST['cd-status'];
	$invoice_url = $_POST['cd-invoice'];
	$date = strtotime($_POST['cd-date']);
	$est_ship_date = strtotime($_POST['cd-est-ship-date']);
	$est_ship_location = $_POST['cd-est-ship-location'];
	$product = $_POST['cd-product'];
	$wheel_color = $_POST['cd-wheel-color'];
	$wheel_size = $_POST['cd-wheel-size'];
	$firmware_version = $_POST['cd-firmware'];
	$deck_serial_number = $_POST['cd-deck'];
	$main_serial_number = $_POST['cd-main-serial'];
	$tracking_number = $_POST['cd-tracking'];
	$notes = $_POST['cd-notes'];
	$priority = $_POST['cd-priority'];
	$error = insertOrder($email, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $status, $invoice_url, $date, $est_ship_date, $est_ship_location, $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority, $db);
}
?>

<section id="main-content">
	<section class="wrapper" style="padding-top:20px;">
		<div id="msg" class="alert" style="display: none;"></div>

		<div class="row-fluid" style="text-align:center;">
			<button type="button" class="btn btn-success m-b-sm" data-toggle="modal" data-target="#ordersModal">Add New Order</button>
		</div>
		<table id="orders" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td></td>
					<td>Order Number</td>
					<td>Order Date</td>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Order Status</td>
					<td>Tracking Number</td>
					<td>Total</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</section>

	<form id="add-row-form" action="" method="POST">
		<div class="modal fade" id="ordersModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel">Add New Order</h4>
					</div>
					<div class="modal-body">
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-12">
									<input type="text" name="cd-email" class="form-control" placeholder="Email" required="">
								</div>
							</div>
						</div>
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-9">
									<input type="text" name="cd-address" class="form-control" placeholder="Delivery Address" required="">
								</div>
								<div class="col-md-3">
									<input type="text" name="cd-address2" class="form-control" placeholder="Apt,Suite,etc" />
								</div>
							</div>
						</div>  
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-4">
									<input type="text" name="cd-city" class="form-control" placeholder="City" required="">
								</div>
								<div class="col-md-4">
									<input type="text" name="cd-state" class="form-control" placeholder="State" required="">
								</div>
								<div class="col-md-4">
									<input type="text" name="cd-zip" class="form-control" placeholder="Zip Code" required="">
								</div>
							</div>
						</div> 
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-12">
									<select name="cd-country" type="text" class="form-control" placeholder="Country" > 
										<option value="">Please select a country...</option> 
										<?php
										foreach (getCountries() as $c) {
											echo '<option value="'.$c['code'].'" >'.$c['name'].'</option>';
										}
										?>
									</select>  
								</div>
							</div>
						</div>
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-4">
									<select name="cd-status" type="text" class="form-control" placeholder="Order Status" >
										<option value="">Select Order Status</option>
										<option value="deposit">Deposit Paid</option>
										<option value="balance">Balance Paid</option>
										<option value="refunded">Refunded</option>
										<option value="building">Building</option>
										<option value="qa">Quality Assurance</option>
										<option value="shipping">Shipping</option>
										<option value="shipped">Shipped</option>
										<option value="hold">On Hold</option>
									</select>
								</div>
								<div class="col-md-8">
									<input name="cd-number" type="text" class="form-control" placeholder="Order Number" />   
								</div>
							</div>
						</div>
						<div class="form-group" style="height:60px">
							<div class="row-fluid">
								<div class="col-md-4">
									<span>Order Date</span>  
								</div>
								<div class="col-md-4">
									<span>Estimate Ship Date</span>
								</div>
								<div class="col-md-4">&nbsp;</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-4">
									<input name="cd-date" type="date" class="form-control" placeholder="Order Date" />   
								</div>
								<div class="col-md-4">
									<input name="cd-est-ship-date" type="date" class="form-control" placeholder="Estimated Ship Date" />   
								</div>
								<div class="col-md-4">
									<input name="cd-est-ship-location" type="text" class="form-control" placeholder="Estimated Ship Location" />   
								</div>
							</div>
						</div>
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-4">
									<select name="cd-product" type="text" class="form-control" placeholder="Product" >
										<option value="">Select Product</option>
										<option value="Marbel Board" >Marbel Board</option>
									</select> 
								</div>
								<div class="col-md-4">
									<select name="cd-wheel-color" type="text" class="form-control" placeholder="Wheel Color" >
										<option value="">Select Wheel Color</option>
										<option value="black">Jet Black</option>
										<option value="blue">Electric Blue</option>
									</select> 
								</div>
								<div class="col-md-4">
									<select name="cd-wheel-size" type="text" class="form-control" placeholder="Wheel Size" >  
										<option value="">Select Wheel Size</option>
										<option value="76">76mm</option>
										<option value="100">100mm</option>
									</select> 
								</div>
							</div>
						</div>
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-4">
									<input name="cd-firmware" type="text" class="form-control" placeholder="Firmware Version" />
								</div>
								<div class="col-md-4">
									<input name="cd-deck" type="text" class="form-control" placeholder="Deck Serial Number" />
								</div>
								<div class="col-md-4">
									<input name="cd-main-serial" type="text" class="form-control" placeholder="Main Serial Number" />
								</div>
							</div>
						</div>
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-6">
									<input name="cd-tracking" type="text" class="form-control" placeholder="Tracking Number" />
								</div>
								<div class="col-md-6">
									<input name="cd-invoice" type="text" class="form-control" placeholder="Invoice URL" /> 
								</div>
							</div>
						</div>
						<div class="form-group" style="height:90px">
							<div class="row-fluid">
								<div class="col-md-12"> 
									<textarea name="cd-notes" class="form-control" placeholder="Comment" style="max-height: 90px; height: 90px;"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" id="add-row" class="btn btn-success">Add</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>