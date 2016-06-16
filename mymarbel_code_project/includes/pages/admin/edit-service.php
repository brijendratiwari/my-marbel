<?php
$service = array();
$customer = array();
$recentServiceLog = array();
if (isset($_POST['cd-submit'])) {
	$id = $_POST['cd-service_id'];
	$trackingOut = $_POST['cd-tracking-out'];
	$type = $_POST['cd-type'];
	$status = $_POST['cd-status'];
	$priority = $_POST['cd-priority'];
	$due_date = $_POST['cd-due'];
	$issue = $_POST['cd-issue'];
	$response = $_POST['cd-response'];
	$adminId = $_SESSION['marbel_user']['user_id'];
	$diagnostic_response = $_POST['cd-diagnostic_response'];
	$included_parts = '';
	foreach ($_POST['included_parts'] as $v) {
		if (!empty($included_parts)) {$included_parts.=',';}
		$included_parts.=$v;
	}
	$test_ride = isset($_POST['test_ride']) ? 1 : 0;
	$final_test_ride = isset($_POST['final_test_ride']) ? 1 : 0;
	$qa = isset($_POST['qa_complete']) ? 1 : 0;
	$notes = $_POST['cd-notes'];
	$customer_notes = $_POST['cd-customer_notes'];
	$service_length = intval($_POST['service_item_count']);
	$services = array();
	for ($i = 0; $i < $service_length; $i++) {
		$services[] = array(
			'name' => $_POST['service_name_'.$i],
			'quantity' => $_POST['service_qty_'.$i],
			'rate' => $_POST['service_rate_'.$i],
			'amount' => $_POST['service_amt_'.$i],
			'description' => $_POST['service_description_'.$i],
			'discount' => $_POST['service_discount_'.$i],
			'complete' => (isset($_POST['service_finish_'.$i]) ? 1 : 0)
		);
	}
	updateService($id, $trackingOut, $type, $status, $priority, $due_date, $issue, $response, $adminId, $diagnostic_response, $included_parts, $test_ride, $final_test_ride, $qa, $notes, $customer_notes, $services, $db);
}
if (isset($_POST['cd-delete'])) {
	$id = $_POST['cd-service_id'];
	deleteService($id, $db);
}
if (isset($_GET['id'])) {
	$service = getService($_GET['id'], $db);
	$recentServiceLog = getRecentServiceLog($_GET['id'], $db);
}

if (!isset($service) && !isset($_POST['cd-delete'])) { ?>

<section id="main-content">
	<section class="wrapper" style="padding-top: 50px;">
		<div class="container">
			<div class="row-fluid">
			<h1>Could not find this service record, please try another</h1>
			</div>
		</div>
	</section>
</section>
<?php } else if (!isset($service) && isset($_POST['cd-delete'])) { ?>
<section id="main-content">
	<section class="wrapper" style="padding-top: 50px;">
		<div class="container">
			<div class="row-fluid">
			<h1>Deleted the service record for service id <?php echo $_GET['id']; ?></h1>
			</div>
		</div>
	</section>
</section>
<?php } else { ?>


<section id="main-content">
	<section class="wrapper" style="padding-top: 50px;">
		<div class="container">
			<div class="row-fluid">
				<div class="col-md-12" style="background-color: #fafafa; color: #666;padding-bottom: 20px;">
					<form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
						<fieldset>
							<input type="hidden" name="cd-service_id" value="<?php echo $service['id']; ?>" />
							<h1 style="padding: 0">
								<span style="float: left">Edit Service Record: <small>for <?php echo $service['customer']['first_name'].' '.$service['customer']['last_name'] ?>.</small></span>  <span style="float: right">Created on: <small><?php echo date('F j, Y', $service['date']); ?></small></span>
							</h1>
							               <!-- Just a spacer to make it look a little nicer -->
            <div class="row-fluid">
				<div class="col-md-12">
                <hr />
                <br />
                </div>
            </div>
							<div class="row-fluid">
									<div class="col-md-12">
										<div class="col-md-3">
											<span>Order: #<small><?php echo'<a href="http://mymarbel.com/admin/edit-order?id='.$service['order_id'].'">'.$service['order']['order_number'].'</a>'; ?></small></span>
										</div>
										<div class="col-md-3">
											<span>Service: #<small><?php echo $service['id']; ?></small></span>
										</div>
										<div class="col-md-3">
											<span>Inbound: <small><?php echo '<a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum='.$service['tracking_in'].'" target="_blank">'.$service['tracking_in'].'</a>';?></small></span>
										</div>
										<div class="col-md-3">
											<input type="text" name="cd-tracking-out" value="<?php echo $service['tracking_out'] ?>" placeholder="Outbound Tracking #"/>
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
										<div class="col-md-3">Service Type: 
											<p class="cd-select">
											<select class="cd-type" name="cd-type" id="cd-type">
												<option <?php if (strcmp($service['type'], 'warrenty') == 0) { echo 'selected="selected"'; } ?> value="warrenty">Warrenty</option>
												<option <?php if (strcmp($service['type'], 'service') == 0) { echo 'selected="selected"'; } ?> value="service">Service</option>
												<option <?php if (strcmp($service['type'], 'refund') == 0) { echo 'selected="selected"'; } ?> value="refund">Refund</option>
											</select>
											</p>
										</div>
										<div class="col-md-3">Service Status:
											<p class="cd-select"> 
											<select class="cd-status" name="cd-status" id="cd-status">
												<option <?php if (strcmp($service['status'], 'pending') == 0) { echo 'selected="selected"'; } ?> value="pending">Pending</option>
												<option <?php if (strcmp($service['status'], 'inhouse') == 0) { echo 'selected="selected"'; } ?> value="inhouse">In House</option>
												<option <?php if (strcmp($service['status'], 'onhold') == 0) { echo 'selected="selected"'; } ?> value="onhold">On Hold</option>
												<option <?php if (strcmp($service['status'], 'finished') == 0) { echo 'selected="selected"'; } ?> value="finished">Finished</option>
												<option <?php if (strcmp($service['status'], 'shipped') == 0) { echo 'selected="selected"'; } ?> value="shipped">Shipped</option>
											</select></p>										
										</div>
										<div class="col-md-3">Priority:
											<p class="cd-select"> 
											<select class="cd-priority" name="cd-priority" id="cd-priority">
												<option <?php if ($service['priority'] == 1) { echo 'selected="selected"'; } ?> value="1">Highest</option>
												<option <?php if ($service['priority'] == 2) { echo 'selected="selected"'; } ?> value="2">High</option>
												<option <?php if ($service['priority'] == 3) { echo 'selected="selected"'; } ?> value="3">Default</option>
												<option <?php if ($service['priority'] == 4) { echo 'selected="selected"'; } ?> value="4">Low</option>
												<option <?php if ($service['priority'] == 5) { echo 'selected="selected"'; } ?> value="5">Lowest</option>
											</select></p>					
										</div>
										<div class="col-md-3">Due: <p><input type="date" name="cd-due" id="cd-due" style="padding:9px" value="<?php if ($service['due_date'] > 0) { echo date("Y-m-d", $service['due_date']); } ?>"/></p>
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
									<div class="col-md-6">
										<span>Customer Reported Issues: <small>Created on <?php echo date('M j, Y, g:i a', $service['date']); ?></small></span>
									</div>
									<div class="col-md-6">
										<span>Suggested Response: <?php if ($service['suggested_response_date'] > 0): ?><small>by <?php echo $service['suggested_response_admin']['first_name'].' '.$service['suggested_response_admin']['last_name'].' on '.date('M j, Y, g:i a', $service['suggested_response_date']); ?></small><?php endif; ?></span>
									</div>
								</div>
							</div>
                            
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
										<p><textarea class="issue" name="cd-issue" id="cd-issue" placeholder="Reported Issues"><?php echo $service['issue']; ?></textarea></p>
									</div>
									<div class="col-md-6">
										<p><textarea class="response" name="cd-response" id="cd-response" placeholder="Suggested Issues / Response"><?php echo $service['suggested_response']; ?></textarea></p>
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
									<div class="col-md-6">
										<span>Check In Report:</span>
									</div>
									<div class="col-md-6">
										<span>In The Box:</span>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
										<p><textarea class="diagnostic_response" name="cd-diagnostic_response" id="cd-diagnostic_response" placeholder="Diagnostic Notes"><?php echo $service['diagnostic_response']; ?></textarea></p>
									</div>
									<div class="col-md-6">
										
                                                            <!-- Just a spacer to make it look a little nicer -->
            <div class="row-fluid">
				<div class="col-md-6">
                <br />
                </div>
            </div>
                                        
                                        <div class="row-fluid">
											<div class="col-md-12">
												<div class="col-md-4">
													<span>Board: <input type="checkbox" name="included_parts[]" value="board" <?php if (in_array('board', $service['included_parts'])) { echo "checked=\"true\""; }?>/></span>
												</div>
												<div class="col-md-4">
													<span>Remote: <input type="checkbox" name="included_parts[]" value="remote" <?php if (in_array('remote', $service['included_parts'])) { echo "checked=\"true\""; }?>/></span>
												</div>
												<div class="col-md-4">
													<span>Charger: <input type="checkbox" name="included_parts[]" value="charger" <?php if (in_array('charger', $service['included_parts'])) { echo "checked=\"true\""; }?>/></span>
												</div>
											</div>
										</div>
										<div class="row-fluid">
											<div class="col-md-12">
												<div class="col-md-4">
													<span>Manual: <input type="checkbox" name="included_parts[]" value="manual" <?php if (in_array('manual', $service['included_parts'])) { echo "checked=\"true\""; }?>/></span>
												</div>
												<div class="col-md-4">
													<span>Tool: <input type="checkbox" name="included_parts[]" value="tool" <?php if (in_array('tool', $service['included_parts'])) { echo "checked=\"true\""; }?>/></span>
												</div>
												<div class="col-md-4">
													<span>Other: <input type="checkbox" name="included_parts[]" value="other" <?php if (in_array('other', $service['included_parts'])) { echo "checked=\"true\""; }?>/></span>
												</div>
											</div>
										</div>
                                        
                                                            <!-- Just a spacer to make it look a little nicer -->
            <div class="row-fluid">
				<div class="col-md-6">
                <br />
                </div>
            </div>
                                        
										<div class="row-fluid">
											<div class="col-md-12">
												<div class="col-md-6">
													<select name="included_parts[]">
														<option value="black" <?php if (in_array('black', $service['included_parts'])) { echo "selected=\"true\""; }?>>Wheel Color: Black</option>
														<option value="blue" <?php if (in_array('blue', $service['included_parts'])) { echo "selected=\"true\""; }?>>Wheel Color: Blue</option>
													</select>
												</div>
												<div class="col-md-6">
													<select name="included_parts[]">
														<option value="76" <?php if (in_array('76', $service['included_parts'])) { echo "selected=\"true\""; }?>>Wheel Size: 76mm</option>
														<option value="100" <?php if (in_array('100', $service['included_parts'])) { echo "selected=\"true\""; }?>>Wheel Size: 100mm</option>
													</select>
												</div>
											</div>
										</div>
										
                                        <div class="row-fluid">
				<div class="col-md-6">
                <br />
                </div>
            </div>
                                        
                                        <div class="row-fluid">
											<div class="col-md-12">
												<span>Test Ride: <input type="checkbox" name="test_ride" <?php if ($service['test_ride_complete'] == 1) { echo "checked=\"true\""; }?>> <?php if ($service['test_ride_complete'] == 1) { echo 'by '.$service['test_ride_admin']['first_name'].' '.$service['test_ride_admin']['last_name'] .' on '.date('M j, Y g:i a', $service['test_ride_date']); } ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>


         <!--just for spacing to make it look a little nicer -->
                <div class="row-fluid">
				<div class="col-md-12">
                <br />
                </div>
                </div>

							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
                                        <span>Service Items:</span>
									</div>
								</div>
							</div>

							<div class="row-fluid">
								<div class="col-md-12">
									<input type="hidden" id="service_item_count" name="service_item_count" value="<?php echo sizeof($service['services']); ?>" />
									<div id="service_items">
									<?php 
										foreach ($service['services'] as $i => $ss) {
											echo '
											<div class="service_item">
											    <div class="row-fluid">
											      <div class="col-md-12">
											        <div class="col-md-6">
											          <div class="col-md-12">
											            <select name="service_name_'.$i.'">
											              <option value="">Please select a service option</option>
											              <option value="replace_drive_system" '.(strcmp($ss['name'], 'replace_drive_system') == 0 ? 'selected="true"' : '').'>Replaced Drive System</option>
											              <option value="deck_replaced" '.(strcmp($ss['name'], 'deck_replaced') == 0 ? 'selected="true"' : '').'>Deck Replaced $350.00</option>
											              <option value="nose_replaced" '.(strcmp($ss['name'], 'nose_replaced') == 0 ? 'selected="true"' : '').'>Nose Replaced $99</option>
											              <option value="rear_bumper_replaced" '.(strcmp($ss['name'], 'rear_bumper_replaced') == 0 ? 'selected="true"' : '').'>Rear Bumper Replaced $15</option>
											              <option value="griptape_replaced" '.(strcmp($ss['name'], 'griptape_replaced') == 0 ? 'selected="true"' : '').'>Griptape Replaced $29.99</option>
											              <option value="electronic_circut_replaced" '.(strcmp($ss['name'], 'electronic_circut_replaced') == 0 ? 'selected="true"' : '').'>Marbel Electronic Circuit Replaced $340.00</option>
											              <option value="battery_system_replaced" '.(strcmp($ss['name'], 'battery_system_replaced') == 0 ? 'selected="true"' : '').'>Battery System Replaced $320.00</option>
											              <option value="phase_wire_repair" '.(strcmp($ss['name'], 'phase_wire_repair') == 0 ? 'selected="true"' : '').'>Phase Wire Check/Repair $29.99</option>
											              <option value="drive_system_tuned" '.(strcmp($ss['name'], 'drive_system_tuned') == 0 ? 'selected="true"' : '').'>Drive System Tuned $29.99</option>
											              <option value="full_drive_system_replaced" '.(strcmp($ss['name'], 'full_drive_system_replaced') == 0 ? 'selected="true"' : '').'>Full Drive System Replaced $195</option>
											              <option value="drive_belt_replaced" '.(strcmp($ss['name'], 'drive_belt_replaced') == 0 ? 'selected="true"' : '').'>Drive Belt Replaced $15</option>
											              <option value="motor_replaced" '.(strcmp($ss['name'], 'motor_replaced') == 0 ? 'selected="true"' : '').'>Motor Replaced $85.00</option>
											              <option value="motor_position_sensor_replaced" '.(strcmp($ss['name'], 'motor_position_sensor_replaced') == 0 ? 'selected="true"' : '').'>Motor Position Sensor Replaced $45.00</option>
											              <option value="belt_cover_replaced" '.(strcmp($ss['name'], 'belt_cover_replaced') == 0 ? 'selected="true"' : '').'>Belt Cover Replaced $29.99</option>
											              <option value="fan_cap_check_repaired" '.(strcmp($ss['name'], 'fan_cap_check_repaired') == 0 ? 'selected="true"' : '').'>Fan Cap Check/Repaired $0</option>
											              <option value="76mm_wheel_replaced" '.(strcmp($ss['name'], '76mm_wheel_replaced') == 0 ? 'selected="true"' : '').'>76mm Wheel Replaced (single) $12.50</option>
											              <option value="100mm_wheel_replaced" '.(strcmp($ss['name'], '100mm_wheel_replaced') == 0 ? 'selected="true"' : '').'>100mm Wheel Replaced (single) $18.75</option>
											              <option value="bearings_replaced" '.(strcmp($ss['name'], 'bearings_replaced') == 0 ? 'selected="true"' : '').'>Bearings Replaced $24.95</option>
											              <option value="spacers_replaced" '.(strcmp($ss['name'], 'spacers_replaced') == 0 ? 'selected="true"' : '').'>Spacers Replaced $2</option>
											              <option value="remote_repaired" '.(strcmp($ss['name'], 'remote_repaired') == 0 ? 'selected="true"' : '').'>Remote Repaired $49.99</option>
											              <option value="remote_replaced" '.(strcmp($ss['name'], 'remote_replaced') == 0 ? 'selected="true"' : '').'>Remote Replaced $99.99</option>
											              <option value="remote_firmware_update" '.(strcmp($ss['name'], 'remote_firmware_update') == 0 ? 'selected="true"' : '').'>Remote Firmware Update $0</option>
											              <option value="labor" '.(strcmp($ss['name'], 'labor') == 0 ? 'selected="true"' : '').'>Labor $75</option>
											            </select>
											          </div>
											        </div>
											        <div class="col-md-6">
											          <div class="col-md-4">
											            <div class="col-md-5">Qty:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_qty_'.$i.'" value="'.$ss['quantity'].'" /></div>
											          </div>  
											          <div class="col-md-4">
											            <div class="col-md-5">Rate:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_rate_'.$i.'" value="'.$ss['rate'].'" /></div>
											          </div>  
											          <div class="col-md-4">
											            <div class="col-md-5">Amount:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_amt_'.$i.'" value="'.$ss['amount'].'" /></div>
											          </div>  
											        </div>
											      </div>
											    </div>
											    <div class="row-fluid">
											      <div class="col-md-12" style="margin: 10px 0 20px 0;">
											        <div class="col-md-6">
											          <div class="col-md-12">
											            <input type="text" name="service_description_'.$i.'"  value="'.$ss['description'].'"/>
											          </div>
											        </div>
											        <div class="col-md-6">
											          <div class="col-md-4">
											            <div class="col-md-5">Discount:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_discount_'.$i.'"  value="'.$ss['discount'].'"/></div>
											          </div>
											          <div class="col-md-8">
											            <div class="col-md-4">Finished:</div><div class="col-md-12"><input type="checkbox" name="service_finish_'.$i.'" '.($ss['complete'] ? 'checked="true"' : '').'/> '.($ss['complete'] == true ? ' by '.$ss['admin_name'] .' on '. date('M j, Y g:i a', $ss['complete_date']): '').'</div>
											          </div>
											        </div>
											      </div>
											    </div>
											  </div>';
										}
									?>
									</div>
								</div>
							</div>

							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
										<a href="#" onClick="return false;" id="add_service_item"><span style="font-size:40px;">+</span></a>
									</div>
								</div>
							</div>
                           
                            <!--just for spacing to make it look a little nicer -->
                            <div class="row-fluid">
				<div class="col-md-12">
                <br />
                </div>
            </div>
							<div class="row-fluid">
								<div class="col-md-12" style="margin-top: 50px;">
									<div class="col-md-6">
										<span>Service Notes:</span>
									</div>
									<div class="col-md-6">
										<span>Notes to Customer:</span>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-6">
										<p><textarea class="notes" name="cd-notes" id="cd-notes" placeholder="Service Notes"><?php echo $service['notes']; ?></textarea></p>
									</div>
									<div class="col-md-6">
										<p><textarea class="customer_notes" name="cd-customer_notes" id="cd-customer_notes" placeholder="All service was covered under warranty. 

Again, thank you for the faith you've placed in us. If there's anything else we can do, just let us know."><?php echo $service['customer_notes']; ?></textarea></p>
									</div>
								</div>
							</div>
                            
                           
                            
                            
							<div class="row-fluid">
								<div class="col-md-12">
                                <div class="col-md-6">
								<span>Final Test Ride: <input type="checkbox" name="final_test_ride" <?php if ($service['final_test_ride_complete'] == 1) { echo "checked=\"true\""; }?>f> <?php if ($service['final_test_ride_complete'] == 1) { echo 'by '.$service['final_test_ride_admin']['first_name'].' '.$service['final_test_ride_admin']['last_name'].' on '.date('M j, Y g:i a', $service['final_test_ride_date']); } ?></span>
                                </div>
								</div>
							</div>
							
                            <!--just for spacing to make it look a little nicer -->
                            <div class="row-fluid">
				            <div class="col-md-12">
                            <br />
                            <br />
                            </div>
                            </div>
                            
							<div class="row-fluid">
								<div class="col-md-12" style="background-color: #00aeee; color: #fff; padding-bottom: 50px;">
									<h1 style="color: #fff; margin: 0px 0px;text-align:left;">Quality Control Checklist</h1>
									<div class="col-md-6">
										<span>- ALL Capacitors have Silicone Stakes</span><br />
										<span>- Both BT chips have Silicone Stakes</span><br />
										<span>- Wires will not rub on the I-beam or any other hard edges</span><br />
										<span>- Braided housing extended ALL the way.</span><br />
										<span>- Wires from the deck to drive systems are extended the proper length</span>
									</div>
									<div class="col-md-6">
										<span>- Main power connector insulated from vibration with siliconed</span><br />
										<span>- Fan Cap Secured! Fan Cap Secured! Fan Cap Secured!</span><br />
										<span>- Motor Mount properly torqued down (no rub on drive wheel)</span><br />
										<span>- All wires properly siliconed down</span><br />
  									<span>&nbsp;&nbsp;(Hall Sensor, 12 pin, Phase Wires, Power)</span>
									</div>
								</div>
							</div>
                            
                            <!--just for spacing to make it look a little nicer -->
                            <div class="row-fluid">
				            <div class="col-md-12">
                            <br />
                            </div>
                            </div>
                            
							<div class="row-fluid">
								<div class="col-md-12">
                                <div class="col-md-6">
									<span>Quality Control Check: <input type="checkbox" name="qa_complete" <?php if ($service['qa_complete'] == 1) { echo "checked=\"true\""; }?>f> <?php if ($service['qa_complete'] == 1) { echo 'by '.$service['qa_admin']['first_name'].' '.$service['qa_admin']['last_name'].' on '.date('M j, Y g:i a', $service['qa_date']); } ?></span>
								</div>
                                </div>
							</div>
                            
                            <!--just for spacing to make it look a little nicer -->
                            <div class="row-fluid">
				            <div class="col-md-12" style="padding-bottom: 50px;">
                            
                            </div>
                            </div>
                            
							<div class="row-fluid">
								<div class="col-md-12">
									<div class="col-md-3">
										<input type="submit" name="cd-delete" class="btn btn-primary btn-lg outline text-center" value="Delete Record">
									</div>
									<div class="col-md-offset-6 col-md-3">
										<input type="submit" name="cd-submit" class="btn btn-primary btn-lg outline text-center" value="Save Changes">
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				</div>
			</div>
		</section>

		<section class="wrapper">
			<div class="container" style="background-color: #fafafa; color: #666;margin-top: 20px;">
				<h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span style="float: left;">Service Update Log</span></small></h1>
				<?php foreach ($recentServiceLog as $i => $log): ?>
					<div class="row-fluid">
						<div class="col-md-12">
							<div class="col-md-1"><?php echo (sizeof($recentServiceLog) - ($i + 1) + 1); ?></div>
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
<?php } ?>