<?php
if (isset($_POST['cd-submit'])) {
	$order_number = $_POST['cd-order_number'];
	$delivery_address = $_POST['cd-address'];
	$delivery_address_2 = $_POST['cd-address2'];
	$city = $_POST['cd-city'];
	$state = $_POST['cd-state'];
	$zip = $_POST['cd-zip'];
	$country = $_POST['cd-country'];
	$wheel_color = $_POST['cd-wheel_color'];
	$wheel_size = $_POST['cd-wheel_size'];
	$product = $_POST['cd-product'];
	$order_total = $_POST['cd-order_total'];
	$shipping_cost = $_POST['cd-shipping_cost'];
	$order_status = $_POST['cd-order_status'];
	$invoice_url = $_POST['cd-invoice_url'];
	$est_ship_date = $_POST['cd-est_ship_date'];
	$est_ship_location = $_POST['cd-est_ship_location'];
	$firmware_version = $_POST['cd-firmware_version'];
	$deck_serial_number = $_POST['cd-deck_serial_number'];
	$main_serial_number = $_POST['cd-main_serial_number'];
	$tracking_number = $_POST['cd-tracking_number'];
	$notes = $_POST['cd-notes'];
	$priority = $_POST['cd-priority'];
	$error = adminUpdateOrder($_SESSION['marbel_user']['user_id'], $_GET['id'], $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, 
		$country, $wheel_color, $wheel_size, $product,$order_total, $shipping_cost, $order_status, $invoice_url, $est_ship_date, $est_ship_location, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority, $db);
}
if (isset($_GET['id'])) {
	$order = getOrder($_GET['id'], $db);
	$recentOrderLog = getRecentOrderLog($_GET['id'], $db);
	$customer = getCustomer($order['user_id'], $db);
}
?>


<section id="main-content">
	<section class="wrapper" style="padding-top: 50px;">
		<div class="container">
			<div class="row-fluid">
				<div class="col-md-9" style="background-color: #fafafa; color: #666;padding-bottom: 20px;">
					<form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
						<fieldset>
							<input type="hidden" name="cd-order_number" value="<?php echo $order['order_number']; ?>" />
							<h1 style="padding: 0">
								<span style="float: left">Order Details: #<?php echo $order['order_number']; ?> <small><?php echo date('m/d/Y', $order['order_date']); ?></small></span>
								<span style="float: right">
									<p class="cd-select">
										<select name="cd-order_status">
											<option value="deposit" <?php if (strcmp($order['order_status'], 'deposit') == 0) { echo 'selected="selected"'; }?>>Deposit Paid</option>
											<option value="balance" <?php if (strcmp($order['order_status'], 'balance') == 0) { echo 'selected="selected"'; }?>>Balance Paid</option>
											<option value="refunded" <?php if (strcmp($order['order_status'], 'refunded') == 0) { echo 'selected="selected"'; }?>>Refunded</option>
											<option value="building" <?php if (strcmp($order['order_status'], 'building') == 0) { echo 'selected="selected"'; }?>>Building</option>
											<option value="qa" <?php if (strcmp($order['order_status'], 'qa') == 0) { echo 'selected="selected"'; }?>>Quality Assurance</option>
											<option value="shipping" <?php if (strcmp($order['order_status'], 'shipping') == 0) { echo 'selected="selected"'; }?>>Shipping</option>
											<option value="shipped" <?php if (strcmp($order['order_status'], 'shipped') == 0) { echo 'selected="selected"'; }?>>Shipped</option>
											<option value="hold" <?php if (strcmp($order['order_status'], 'hold') == 0) { echo 'selected="selected"'; }?>>On Hold</option>
										</select>
									</p>
								</span>
                                <span style="float: right; margin-right: 20px;">
									<p class="cd-select">
										<select name="cd-priority">
											<option value="1" <?php if ($order['priority'] == 1) { echo 'selected="selected"'; }?>>1 - Highest</option>
											<option value="2" <?php if ($order['priority'] == 2) { echo 'selected="selected"'; }?>>2</option>
											<option value="3" <?php if ($order['priority'] == 3) { echo 'selected="selected"'; }?>>3</option>
											<option value="4" <?php if ($order['priority'] == 4) { echo 'selected="selected"'; }?>>4</option>
											<option value="5" <?php if ($order['priority'] == 5) { echo 'selected="selected"'; }?>>5 - Lowest</option>
	
										</select>
									</p>
								</span>
                                
                                
							</h1>
							<br /><p style="margin-left: 20px;"><?php echo '<a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum='.$order['tracking_number'].'" target="_blank">'.$order['tracking_number'].'</a>';?></p>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-4">
										<p class="cd-select">
											<select name="cd-product">
												<option value="Marbel Board" <?php if (strcmp($order['product'], 'Marbel Board') == 0) { echo 'selected="selected"'; }?>>Marbel Board</option>
											</select>
										</p>
									</div>
									<div class="col-md-4">
										<p class="cd-select">
											<select class="cd-wheel_size" name="cd-wheel_size" id="cd-wheel_size">
												<option <?php if (strcmp($order['wheel_size'], '76') == 0) { echo 'selected="selected"'; } ?> value="76" <?php echo ($order['wheel_size'] == 76 ? 'selected' : ''); ?>>76mm</option>
												<option <?php if (strcmp($order['wheel_size'], '100') == 0) { echo 'selected="selected"'; } ?> value="100" <?php echo ($order['wheel_size'] == 100 ? 'selected' : ''); ?>>100mm</option>
											</select>
										</p>
									</div>
									<div class="col-md-4">
										<p class="cd-select">
											<select class="cd-wheel_color" name="cd-wheel_color" id="cd-wheel_color" required>
												<option <?php if (strcmp($order['wheel_color'], 'blue') == 0) { echo 'selected="selected"'; } ?> value="blue" <?php echo ($order['wheel_color'] == 'blue' ? 'selected' : ''); ?>>Electric Blue</option>
												<option <?php if (strcmp($order['wheel_color'], 'black') == 0) { echo 'selected="selected"'; } ?> value="black" <?php echo ($order['wheel_color'] == 'black' ? 'selected' : ''); ?>>Jet Black</option>
											</select>
										</p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-9">
										<p><input class="address" type="text" name="cd-address" id="cd-address" value="<?php echo $order['delivery_address']; ?>" placeholder="Address"></p>
									</div>
									<div class="col-md-3">
										<p><input class="address" type="text" name="cd-address2" id="cd-address2" value="<?php echo $order['delivery_address_2']; ?>" placeholder="Apt,Suite,etc"></p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-5">
										<p><input class="city" type="text" name="cd-city" id="cd-city" value="<?php echo $order['city']; ?>" placeholder="City"></p>
									</div>
									<div class="col-md-5">
										<p><input class="state" type="text" name="cd-state" id="cd-state" value="<?php echo $order['state']; ?>" placeholder="State"></p>
									</div>
									<div class="col-md-2">
										<p><input class="zip" type="text" name="cd-zip" id="cd-zip" value="<?php echo $order['zip']; ?>" placeholder="Zip/Postal Code"></p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-12">
										<p class="cd-select">
											<select class="cd-country" name="cd-country" id="cd-country">
												<option value="">Please select a country...</option> 
												<?php
												foreach (getCountries() as $c) {
													echo '<option value="'.$c['code'].'" '.((strcmp($order['country'], $c['code']) == 0) ? 'selected="selected"' : '').'>'.$c['name'].'</option>';
												}
												?>
											</select>
										</p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-4">
										<p><input class="main_serial_number" type="text" name="cd-main_serial_number" id="cd-main_serial_number" value="<?php echo $order['main_serial_number']; ?>" placeholder="Main Serial Number"></p>
									</div>
									<div class="col-md-4">
										<p><input class="deck_serial_number" type="text" name="cd-deck_serial_number" id="cd-deck_serial_number" value="<?php echo $order['deck_serial_number']; ?>" placeholder="Deck Serial Number"></p>
									</div>
									<div class="col-md-4">
										<p><input class="firmware_version" type="text" name="cd-firmware_version" id="cd-firmware_version" value="<?php echo $order['firmware_version']; ?>" placeholder="Firmware Version"></p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
										<p><input class="tracking_number" type="text" name="cd-tracking_number" id="cd-tracking_number" value="<?php echo $order['tracking_number']; ?>" placeholder="Tracking Number"></p>
									</div>
									<div class="col-md-6">
										<p><input class="shipping_cost" type="text" name="cd-shipping_cost" id="cd-shipping_cost" value="<?php echo $order['shipping_cost']; ?>" placeholder="Shipping Costs"></p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
										<p><input type="date" name="cd-est_ship_date" id="cd-est_ship_date" style="padding: 9px;" value="<?php if ($order['est_ship_date'] > 0) { echo date("Y-m-d", $order['est_ship_date']); } ?>" placeholder="Estimate Shipping Date"></p>
									</div>
									<div class="col-md-6">
										<p><input class="est_ship_location" type="text" name="cd-est_ship_location" id="cd-est_ship_location" value="<?php echo $order['est_ship_location']; ?>" placeholder="Estimate Shipping Location"></p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-2">
										<p><input class="order_total" type="text" name="cd-order_total" id="cd-order_total" value="<?php echo $order['order_total']; ?>" placeholder="Total"></p>
									</div>
									<div class="col-md-10">
										<p><input class="invoice_url" type="text" name="cd-invoice_url" id="cd-invoice_url" value="<?php echo $order['invoice_url']; ?>" placeholder="Invoice URL"></p>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-12">
										<p><textarea class="notes" name="cd-notes" id="cd-notes" placeholder="Add notes to this order"><?php echo $order['notes']; ?></textarea></p>
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
						</fieldset>
					</form>
				</div>
				<div class="col-md-3">
					<div class="row-fluid">
						<div class="col-md-12" style="background-color: #fafafa; color: #666;margin-bottom: 20px;">
							<h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span style="float: left;">Customer Details</span><span style="float: right"><a href="/admin/edit-customer?id=<?php echo $order['user_id']; ?>">edit</a></span></small></h1>
							<p><?php echo $customer['first_name'].' '.$customer['last_name']; ?></p>
							<hr style="margin: 5px 0;" />
							<p><?php 
								if (sizeof($customer['phone']) > 10) {
									echo '+'.substr($customer['phone'], 0, sizeof($customer['phone']) - 10).' ';
									$customer['phone'] = substr($customer['phone'], sizeof($customer['phone']) - 10);
								}
								echo preg_replace('/(\d{3})(\d{3})(\d{4})/', "$1-$2-$3", $customer['phone']);
								?></p>
								<hr style="margin: 5px 0;" />
								<p><?php echo $customer['email']; ?></p>
                                <br/>
                                <h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span style="float: left;">Last Login</span></small></h1>
                                <p><?php echo date("M j, Y", $customer['last_activity']); ?></p>
							</div>
						</div>
						<div class="row-fluid">
							<div class="col-md-12" style="background-color: #fafafa; color: #666;margin-bottom: 20px;">
								<h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span style="float: left;">Tasks regarding this customer</span><span style="float: right"><a href="#">new</a></span></small></h1>
							</div>
						</div>
						<div class="row-fluid">
							<div class="col-md-12" style="background-color: #fafafa; color: #666">
								<h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span style="float: left;">Repairs related to this order</span><span style="float: right"><a href="/new-service?id=<?php echo $order['user_id'].'&order_id='.$_GET['id']; ?>">new</a></span></small></h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="wrapper">
			<div class="container" style="background-color: #fafafa; color: #666;margin-top: 20px;">
				<h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span style="float: left;">Order Update Log</span></small></h1>
				<?php foreach ($recentOrderLog as $i => $log): ?>
					<div class="row-fluid">
						<div class="col-md-12">
							<div class="col-md-1"><?php echo (sizeof($recentOrderLog) - ($i + 1) + 1); ?></div>
							<div class="col-md-2">
								<span><?php echo $log['name']; ?></span>
							</div>
							<div class="col-md-6">
								<span><?php echo $log['notes']; ?></span>
							</div>
							<div class="col-md-3">
								<span><?php echo $log['date']; ?></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</section>