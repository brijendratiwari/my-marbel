
<div id="page-wrapper">


    <div class="row">

        <div class="col-md-12" style="margin-top:10px;"><a class="btn btn-sm btn-default" href="javascript:history.back()">Go Back</a></div>
        
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="col-md-6 alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="col-md-6 alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php
        }
        if ($service) {
            ?>

            <div class="col-md-12" style="background-color: #fafafa; color: #666;padding-bottom: 20px;">
                <form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">

                    <input type="hidden" name="cd-service_id" value="<?php echo $service['id']; ?>" />
                    <h1 style="padding: 0">
                        <span style="float: left">Edit Service Record: <small>for <?php echo $service['customer']['first_name'] . ' ' . $service['customer']['last_name'] ?>.</small></span>  <span style="float: right">Created on: <small><?php echo date('F j, Y', $service['date']); ?></small></span>
                    </h1>
                  
                        <div class="col-md-12">
                            <div class="col-md-3 form-group">
                                <span>Order: #<small><?php echo'<a href="'.base_url('edit_order/' . $service['order_id'] . '').'"> '.(isset($service['order']['order_number'])?$service['order']['order_number']:'Not found').'</a>'; ?></small></span>
                            </div>
                            <div class="col-md-3 form-group">
                                <span>Service: #<small><?php echo $service['id']; ?></small></span>
                            </div>
                            <div class="col-md-3 form-group">
                                <span>Inbound: <small><?php echo '<a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=' . $service['tracking_in'] . '" target="_blank">' . $service['tracking_in'] . '</a>'; ?></small></span>
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class="form-control" name="cd-tracking-out" value="<?php echo $service['tracking_out'] ?>" placeholder="Outbound Tracking #"/>
                            </div>
                        </div>

                  

                        <div class="col-md-12">
                            <div class="col-md-3 form-group">Service Type: 
                                <p class="cd-select">
                                    <select class="cd-type form-control" name="cd-type" id="cd-type">
                                        <option <?php if (strcmp($service['type'], 'warrenty') == 0) {
                echo 'selected="selected"';
            } ?> value="warrenty">Warrenty</option>
                                        <option <?php if (strcmp($service['type'], 'service') == 0) {
                echo 'selected="selected"';
            } ?> value="service">Service</option>
                                        <option <?php if (strcmp($service['type'], 'refund') == 0) {
                echo 'selected="selected"';
            } ?> value="refund">Refund</option>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-3 form-group">Service Status:
                                <p class="cd-select"> 
                                    <select class="cd-status form-control" name="cd-status" id="cd-status">
                                        <option <?php if (strcmp($service['status'], 'pending') == 0) {
                echo 'selected="selected"';
            } ?> value="pending">Pending</option>
                                        <option <?php if (strcmp($service['status'], 'inhouse') == 0) {
                echo 'selected="selected"';
            } ?> value="inhouse">In House</option>
                                        <option <?php if (strcmp($service['status'], 'onhold') == 0) {
                echo 'selected="selected"';
            } ?> value="onhold">On Hold</option>
                                        <option <?php if (strcmp($service['status'], 'finished') == 0) {
                echo 'selected="selected"';
            } ?> value="finished">Finished</option>
                                        <option <?php if (strcmp($service['status'], 'shipped') == 0) {
                echo 'selected="selected"';
            } ?> value="shipped">Shipped</option>
                                    </select></p>										
                            </div>
                            <div class="col-md-3 form-group">Priority:
                                <p class="cd-select"> 
                                    <select class="cd-priority form-control" name="cd-priority" id="cd-priority" >
                                        <option <?php if ($service['priority'] == 1) {
                echo 'selected="selected"';
            } ?> value="1">Highest</option>
                                        <option <?php if ($service['priority'] == 2) {
                echo 'selected="selected"';
            } ?> value="2">High</option>
                                        <option <?php if ($service['priority'] == 3) {
                echo 'selected="selected"';
            } ?> value="3">Default</option>
                                        <option <?php if ($service['priority'] == 4) {
                echo 'selected="selected"';
            } ?> value="4">Low</option>
                                        <option <?php if ($service['priority'] == 5) {
                echo 'selected="selected"';
            } ?> value="5">Lowest</option>
                                    </select></p>					
                            </div>
                            <div class="col-md-3 form-group">Due: <p><input type="date" name="cd-due" id="cd-due" class="form-control" style="padding:9px" value="<?php if ($service['due_date'] > 0) {
                echo date("Y-m-d", $service['due_date']);
            } ?>"/></p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <span>Customer Reported Issues: <small>Created on <?php echo date('M j, Y, g:i a', $service['date']); ?></small></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <span>Suggested Response: <?php if ($service['suggested_response_date'] > 0): ?><small>by <?php echo $service['suggested_response_admin']['first_name'] . ' ' . $service['suggested_response_admin']['last_name'] . ' on ' . date('M j, Y, g:i a', $service['suggested_response_date']); ?></small><?php endif; ?></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <p><textarea class="issue form-control" name="cd-issue" id="cd-issue" placeholder="Reported Issues"><?php echo $service['issue']; ?></textarea></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <p><textarea class="response form-control" name="cd-response" id="cd-response" placeholder="Suggested Issues / Response"><?php echo $service['suggested_response']; ?></textarea></p>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <span>Check In Report:</span>
                            </div>
                            <div class="col-md-6 form-group">
                                <span>In The Box:</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <p><textarea class="diagnostic_response form-control" name="cd-diagnostic_response" id="cd-diagnostic_response" placeholder="Diagnostic Notes"><?php echo $service['diagnostic_response']; ?></textarea></p>
                            </div>
                            <div class="col-md-6">

                              

                                    <div class="col-md-12">
                                        <div class="col-md-4 form-group">
                                            <span>Board: <input type="checkbox" name="included_parts[]" value="board" <?php if (in_array('board', $service['included_parts'])) {
                echo "checked=\"true\"";
            } ?>/></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <span>Remote: <input type="checkbox" name="included_parts[]" value="remote" <?php if (in_array('remote', $service['included_parts'])) {
                echo "checked=\"true\"";
            } ?>/></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <span>Charger: <input type="checkbox" name="included_parts[]" value="charger" <?php if (in_array('charger', $service['included_parts'])) {
                echo "checked=\"true\"";
            } ?>/></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div class="col-md-4">
                                            <span>Manual: <input type="checkbox" name="included_parts[]" value="manual" <?php if (in_array('manual', $service['included_parts'])) {
                echo "checked=\"true\"";
            } ?>/></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Tool: <input type="checkbox" name="included_parts[]" value="tool" <?php if (in_array('tool', $service['included_parts'])) {
                echo "checked=\"true\"";
            } ?>/></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Other: <input type="checkbox" name="included_parts[]" value="other" <?php if (in_array('other', $service['included_parts'])) {
                echo "checked=\"true\"";
            } ?>/></span>
                                        </div>
                                    </div>

                                

                                    <div class="col-md-12 form-group">
                                        <div class="col-md-6">
                                            <select name="included_parts[]" class="form-control">
                                                <option value="black" <?php if (in_array('black', $service['included_parts'])) {
                echo "selected=\"true\"";
            } ?>>Wheel Color: Black</option>
                                                <option value="blue" <?php if (in_array('blue', $service['included_parts'])) {
                echo "selected=\"true\"";
            } ?>>Wheel Color: Blue</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="included_parts[]" class="form-control">
                                                <option value="76" <?php if (in_array('76', $service['included_parts'])) {
                echo "selected=\"true\"";
            } ?>>Wheel Size: 76mm</option>
                                                <option value="100" <?php if (in_array('100', $service['included_parts'])) {
                                echo "selected=\"true\"";
                            } ?>>Wheel Size: 100mm</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                              

                                    <div class="col-md-12 form-group">
                                     
                                        <span>Test Ride: <input type="checkbox" name="test_ride" <?php if ($service['test_ride_complete'] == 1) {
                                echo "checked=\"true\"";
                            } ?>> <?php if($service['test_ride_complete'] == 1) {
                                echo 'by ' . $service['test_ride_admin_id']['first_name'] . ' ' . $service['test_ride_admin_id']['last_name'] . ' on ' . date('M j, Y g:i a', $service['test_ride_date']);
                            } ?></span>
                                    </div>
                            </div>


               

                        <div class="col-md-12 form-group">
                            <div class="col-md-6">
                                <span>Service Items:</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <input type="hidden" id="service_item_count" name="service_item_count" value="<?php echo sizeof($service['services']); ?>" />
                            <div id="service_items">
                                <?php
                                if ($service['services']) {
                                    #echo "<pre>"; print_r($service['services']); die;
                                    foreach ($service['services'] as $i => $ss) {
                                       ?>
											<div class="service_item">
											      <div class="col-md-12">
											        <div class="col-md-6">
											          <div class="col-md-12">
											            <select class="form-control" name="service_name_<?php echo $i ?>">
											              <option value="">Please select a service option</option>
											              <option value="replace_drive_system"  <?php echo (strcmp($ss['name'], 'replace_drive_system') == 0 ? 'selected="true"' : '') ?>>Replaced Drive System</option>
											              <option value="deck_replaced" <?php echo (strcmp($ss['name'], 'deck_replaced') == 0 ? 'selected="true"' : '') ?>>Deck Replaced $350.00</option>
											              <option value="nose_replaced" <?php echo (strcmp($ss['name'], 'nose_replaced') == 0 ? 'selected="true"' : '') ?>>Nose Replaced $99</option>
											              <option value="rear_bumper_replaced" <?php echo (strcmp($ss['name'], 'rear_bumper_replaced') == 0 ? 'selected="true"' : '')?>>Rear Bumper Replaced $15</option>
											              <option value="griptape_replaced" <?php echo (strcmp($ss['name'], 'griptape_replaced') == 0 ? 'selected="true"' : '')?>>Griptape Replaced $29.99</option>
											              <option value="electronic_circut_replaced" <?php echo (strcmp($ss['name'], 'electronic_circut_replaced') == 0 ? 'selected="true"' : '') ?>>Marbel Electronic Circuit Replaced $340.00</option>
											              <option value="battery_system_replaced" <?php echo (strcmp($ss['name'], 'battery_system_replaced') == 0 ? 'selected="true"' : '') ?>>Battery System Replaced $320.00</option>
											              <option value="phase_wire_repair" <?php echo (strcmp($ss['name'], 'phase_wire_repair') == 0 ? 'selected="true"' : '') ?>>Phase Wire Check/Repair $29.99</option>
											              <option value="drive_system_tuned" <?php echo (strcmp($ss['name'], 'drive_system_tuned') == 0 ? 'selected="true"' : '') ?>>Drive System Tuned $29.99</option>
											              <option value="full_drive_system_replaced" <?php echo (strcmp($ss['name'], 'full_drive_system_replaced') == 0 ? 'selected="true"' : '') ?>>Full Drive System Replaced $195</option>
											              <option value="drive_belt_replaced" <?php echo (strcmp($ss['name'], 'drive_belt_replaced') == 0 ? 'selected="true"' : '') ?>>Drive Belt Replaced $15</option>
											              <option value="motor_replaced" <?php echo (strcmp($ss['name'], 'motor_replaced') == 0 ? 'selected="true"' : '') ?>>Motor Replaced $85.00</option>
											              <option value="motor_position_sensor_replaced" <?php echo (strcmp($ss['name'], 'motor_position_sensor_replaced') == 0 ? 'selected="true"' : '') ?>>Motor Position Sensor Replaced $45.00</option>
											              <option value="belt_cover_replaced" <?php echo (strcmp($ss['name'], 'belt_cover_replaced') == 0 ? 'selected="true"' : '') ?>>Belt Cover Replaced $29.99</option>
											              <option value="fan_cap_check_repaired" <?php echo (strcmp($ss['name'], 'fan_cap_check_repaired') == 0 ? 'selected="true"' : '') ?>>Fan Cap Check/Repaired $0</option>
											              <option value="76mm_wheel_replaced" <?php echo (strcmp($ss['name'], '76mm_wheel_replaced') == 0 ? 'selected="true"' : '') ?>>76mm Wheel Replaced (single) $12.50</option>
											              <option value="100mm_wheel_replaced" <?php echo (strcmp($ss['name'], '100mm_wheel_replaced') == 0 ? 'selected="true"' : '') ?>>100mm Wheel Replaced (single) $18.75</option>
											              <option value="bearings_replaced" <?php echo (strcmp($ss['name'], 'bearings_replaced') == 0 ? 'selected="true"' : '') ?>>Bearings Replaced $24.95</option>
											              <option value="spacers_replaced" <?php (strcmp($ss['name'], 'spacers_replaced') == 0 ? 'selected="true"' : '') ?>>Spacers Replaced $2</option>
											              <option value="remote_repaired" <?php echo (strcmp($ss['name'], 'remote_repaired') == 0 ? 'selected="true"' : '') ?>>Remote Repaired $49.99</option>
											              <option value="remote_replaced" <?php echo (strcmp($ss['name'], 'remote_replaced') == 0 ? 'selected="true"' : '') ?>>Remote Replaced $99.99</option>
											              <option value="remote_firmware_update" <?php echo (strcmp($ss['name'], 'remote_firmware_update') == 0 ? 'selected="true"' : '')?>>Remote Firmware Update $0</option>
											              <option value="labor" <?php echo (strcmp($ss['name'], 'labor') == 0 ? 'selected="true"' : '') ?>>Labor $75</option>
											            </select>
											          </div>
											        </div>
											        <div class="col-md-6">
											            <div class="col-md-3 form-group">Qty:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_qty_<?php echo $i; ?>" value=" <?php echo $ss['quantity'] ;?>" /></div>
											            <div class="col-md-3 form-group">Rate:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_rate_<?php echo $i ; ?>" value="<?php echo $ss['rate']; ?>" /></div>
											            <div class="col-md-3 form-group">Amount:</div><div class="col-md-9 form-group"><input class="col-md-12 form-control" type="text" name="service_amt_<?php echo $i; ?>" value="<?php echo $ss['amount']; ?>" /></div>
											        </div>
											      </div>
											      <div class="col-md-12" style="margin: 10px 0 20px 0;">
											        <div class="col-md-6 form-group">
											          <div class="col-md-12">
											            <input class="form-control" type="text" name="service_description_<?php echo $i ?>"  value="<?php echo $ss['description'] ?>"/>
											          </div>
											        </div>
											        <div class="col-md-6">
											            <div class="col-md-3 form-group">Discount:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_discount_<?php echo $i; ?>"  value="<?php echo $ss['discount'] ?>"/></div>
											            <div class="col-md-3 form-group">Finished:</div><div class="col-md-9"><input class="" type="checkbox" name="service_finish_<?php echo $i; ?>" <?php echo ($ss['complete'] ? 'checked="true"' : ''); ?> /> <?php echo  ($ss['complete'] == true ? ' by ' . $ss['admin_name'] . ' on ' . date('M j, Y g:i a', $ss['complete_date']) : ''); ?></div>
											        </div>
											      </div>
											  </div> <?php 
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <a href="#" onClick="return false;" id="add_service_item"><span style="font-size:40px;">+</span></a>
                            </div>
                        </div>

                
                        <div class="col-md-12" style="margin-top: 50px;">
                            <div class="col-md-6">
                                <span>Service Notes:</span>
                            </div>
                            <div class="col-md-6">
                                <span>Notes to Customer:</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <p><textarea class="notes form-control" name="cd-notes" id="cd-notes" placeholder="Service Notes"><?php echo $service['notes']; ?></textarea></p>
                            </div>
                            <div class="col-md-6">
                                <p><textarea class="form-control" class="customer_notes" name="cd-customer_notes" id="cd-customer_notes" placeholder="All service was covered under warranty. 

                                             Again, thank you for the faith you've placed in us. If there's anything else we can do, just let us know."><?php echo $service['customer_notes']; ?></textarea></p>
                            </div>
                        </div>




                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <span>Final Test Ride: <input type="checkbox" name="final_test_ride" <?php if ($service['final_test_ride_complete'] == 1) {
                                    echo "checked=\"true\"";
                                } ?>f> <?php if ($service['final_test_ride_complete'] == 1) {
                                    echo 'by ' . $service['final_test_ride_admin']['first_name'] . ' ' . $service['final_test_ride_admin']['last_name'] . ' on ' . date('M j, Y g:i a', $service['final_test_ride_date']);
                                } ?></span>
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

                        <div class="col-md-12">
                              <div class="panel panel-info">
                            <div class="panel-heading">
                                Quality Control Checklist</div>
                            <div class="panel-body">
                                <span>- ALL Capacitors have Silicone Stakes</span><br />
                                <span>- Both BT chips have Silicone Stakes</span><br />
                                <span>- Wires will not rub on the I-beam or any other hard edges</span><br />
                                <span>- Braided housing extended ALL the way.</span><br />
                                <span>- Wires from the deck to drive systems are extended the proper length</span>
                          
                                <span>- Main power connector insulated from vibration with siliconed</span><br />
                                <span>- Fan Cap Secured! Fan Cap Secured! Fan Cap Secured!</span><br />
                                <span>- Motor Mount properly torqued down (no rub on drive wheel)</span><br />
                                <span>- All wires properly siliconed down</span><br />
                                <span>&nbsp;&nbsp;(Hall Sensor, 12 pin, Phase Wires, Power)</span>
                            </div>
                            </div>
                        </div>

                 

                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <span>Quality Control Check: <input type="checkbox" name="qa_complete" <?php if ($service['qa_complete'] == 1) {
                                    echo "checked=\"true\"";
                                } ?>f> <?php if ($service['qa_complete'] == 1) {
                                    echo 'by ' . $service['qa_admin']['first_name'] . ' ' . $service['qa_admin']['last_name'] . ' on ' . date('M j, Y g:i a', $service['qa_date']);
                                } ?></span>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="col-md-3 form-group">
<!--                                <input type="submit" name="cd-delete" class="btn btn-primary btn-lg outline text-center" value="Delete Record">-->
                                <a class="btn btn-custom btn-lg"  onclick="return confirm('Are you sure to delete the service!')" href="<?php echo base_url('index.php/delete_services/'.$service['id'].'/'.$param);?>">Delete Record</a>
                            </div>
                            <div class="col-md-offset-6 col-md-3">
                                <input type="submit" name="cd-submit" class="btn btn-custom btn-lg" value="Save Changes">
                            </div>
                        </div>

                </form>
            </div>
<?php } ?>
        <div class="col-md-12" style="background-color: #fafafa; color: #666;margin-bottom: 10%;">
				<h1 style="padding: 0 0 15px; border-bottom: 1px solid #aaa;"><small><span>Service Update Log</span></small></h1>
				<?php foreach ($recentServiceLog as $i => $log): ?>
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
				<?php endforeach; ?>
			</div>
    </div>
  <div id="service_input" class="hidden">
  <div class="service_item">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="col-md-12 form-group">
            <select name="service_name_%length%" class="form-control">
              <option value="">Please select a service option</option>
              <option value="replace_drive_system">Replaced Drive System</option>
              <option value="deck_replaced">Deck Replaced $350.00</option>
              <option value="nose_replaced">Nose Replaced $99</option>
              <option value="rear_bumper_replaced">Rear Bumper Replaced $15</option>
              <option value="griptape_replaced">Griptape Replaced $29.99</option>
              <option value="electronic_circut_replaced">Marbel Electronic Circuit Replaced $340.00</option>
              <option value="battery_system_replaced">Battery System Replaced $320.00</option>
              <option value="phase_wire_repair">Phase Wire Check/Repair $29.99</option>
              <option value="drive_system_tuned">Drive System Tuned $29.99</option>
              <option value="full_drive_system_replaced">Full Drive System Replaced $195</option>
              <option value="drive_belt_replaced">Drive Belt Replaced $15</option>
              <option value="motor_replaced">Motor Replaced $85.00</option>
              <option value="motor_position_sensor_replaced">Motor Position Sensor Replaced $45.00</option>
              <option value="belt_cover_replaced">Belt Cover Replaced $29.99</option>
              <option value="fan_cap_check_repaired">Fan Cap Check/Repaired $0</option>
              <option value="76mm_wheel_replaced">76mm Wheel Replaced (single) $12.50</option>
              <option value="100mm_wheel_replaced">100mm Wheel Replaced (single) $18.75</option>
              <option value="bearings_replaced">Bearings Replaced $24.95</option>
              <option value="spacers_replaced">Spacers Replaced $2</option>
              <option value="remote_repaired">Remote Repaired $49.99</option>
              <option value="remote_replaced">Remote Replaced $99.99</option>
              <option value="remote_firmware_update">Remote Firmware Update $0</option>
              <option value="labor">Labor $75</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-3 form-group">Qty:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_qty_%length%" /></div>
            <div class="col-md-3 form-group">Rate:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_rate_%length%" /></div>
            <div class="col-md-3 form-group">Amount:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_amt_%length%" /></div>
        </div>
      </div>
      <div class="col-md-12" style="margin: 10px 0 20px 0;">
        <div class="col-md-6 form-group">
          <div class="col-md-12">
              <input type="text" class="form-control" placeholder="service description" name="service_description_%length%" />
          </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-3 form-group">Discount:</div><div class="col-md-9 form-group"><input class="form-control" type="text" name="service_discount_%length%" /></div>
            <div class="col-md-3 form-group">Finish</div><div class="col-md-9 form-group"><input type="checkbox" name="service_finish_%length%" /></div>
        </div>
      </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#add_service_item').click(function() {
      console.log("clicked the add service item")
      var text = $('body').find("#service_input").html().replace(/\%length%/g, $('#service_items').children().size()); 
      $('#service_items').append(text);
      $('#service_item_count').val($('#service_items').children().size());
    });
  });
</script>