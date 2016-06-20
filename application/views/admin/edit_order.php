
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
       <?php } ?>

        <div class="col-md-9" style="background-color: #fafafa; color: #666;padding-bottom: 20px;">
            <form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
                <fieldset>
                    <input type="hidden" name="cd-order_number" value="<?php echo $order[0]['order_number']; ?>" />
                    <input type="hidden" name="cd-userid" value="<?php echo $order[0]['user_id']; ?>" />
                   
                    <div class="col-md-12">
                    <div class="col-md-12">
                        
                         <h3>
                        <span>Order Details: #<?php echo $order[0]['order_number']; ?> <small><?php echo date('m/d/Y', $order[0]['order_date']); ?></small></span>
                    </h3>
                        
                        <p style="margin-left: 20px;"><?php echo '<a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=' . $order[0]['tracking_number'] . '" target="_blank">' . $order[0]['tracking_number'] . '</a>'; ?></p>
                    </div>
                    </div>
                        <div class="col-md-12">
                        <div class="col-md-4">
                            <p class="cd-select">
                                <select name="cd-order_status" class="form-control">
                                    <option value="deposit" <?php
                                    if (strcmp($order[0]['order_status'], 'deposit') == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Deposit Paid</option>
                                    <option value="balance" <?php
                                    if (strcmp($order[0]['order_status'], 'balance') == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Balance Paid</option>
                                    <option value="refunded" <?php
                                            if (strcmp($order[0]['order_status'], 'refunded') == 0) {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Refunded</option>
                                    <option value="building" <?php
                                    if (strcmp($order[0]['order_status'], 'building') == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Building</option>
                                    <option value="qa" <?php
                                    if (strcmp($order[0]['order_status'], 'qa') == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Quality Assurance</option>
                                    <option value="shipping" <?php
                                            if (strcmp($order[0]['order_status'], 'shipping') == 0) {
                                                echo 'selected="selected"';
                                            }
                                    ?>>Shipping</option>
                                    <option value="shipped" <?php
                                    if (strcmp($order[0]['order_status'], 'shipped') == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Shipped</option>
                                    <option value="hold" <?php
                                    if (strcmp($order[0]['order_status'], 'hold') == 0) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>On Hold</option>
                                </select>
                            </p>
                        </div>
                    <div class="col-md-4">
                            <p class="cd-select">
                                <select name="cd-priority" class="form-control">
                                    <option value="1" <?php
                                            if ($order[0]['priority'] == 1) {
                                                echo 'selected="selected"';
                                            }
                                    ?>>1 - Highest</option>
                                    <option value="2" <?php
                                            if ($order[0]['priority'] == 2) {
                                                echo 'selected="selected"';
                                            }
                                    ?>>2</option>
                                    <option value="3" <?php
                                            if ($order[0]['priority'] == 3) {
                                                echo 'selected="selected"';
                                            }
                                    ?>>3</option>
                                    <option value="4" <?php
                                        if ($order[0]['priority'] == 4) {
                                            echo 'selected="selected"';
                                        }
                                    ?>>4</option>
                                    <option value="5" <?php
                                        if ($order[0]['priority'] == 5) {
                                            echo 'selected="selected"';
                                        }
                                    ?>>5 - Lowest</option>

                                </select>
                            </p>
                        </div>
                      </div>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <p class="cd-select">
                                    <select name="cd-product" class="form-control">
                                        <option value="Marbel Board" <?php
                                            if (strcmp($order[0]['product'], 'Marbel Board') == 0) {
                                                echo 'selected="selected"';
                                            }
                                    ?>>Marbel Board</option>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="cd-select">
                                    <select class="cd-wheel_size form-control" name="cd-wheel_size" id="cd-wheel_size">
                                        <option <?php
                                            if (strcmp($order[0]['wheel_size'], '76') == 0) {
                                                echo 'selected="selected"';
                                            }
                                    ?> value="76" <?php echo ($order[0]['wheel_size'] == 76 ? 'selected' : ''); ?>>76mm</option>
                                        <option <?php
                                            if (strcmp($order[0]['wheel_size'], '100') == 0) {
                                                echo 'selected="selected"';
                                            }
                                    ?> value="100" <?php echo ($order[0]['wheel_size'] == 100 ? 'selected' : ''); ?>>100mm</option>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="cd-select">
                                    <select class="cd-wheel_color form-control" name="cd-wheel_color" id="cd-wheel_color">
                                        <option <?php
                                            if (strcmp($order[0]['wheel_color'], 'blue') == 0) {
                                                echo 'selected="selected"';
                                            }
                                    ?> value="blue" <?php echo ($order[0]['wheel_color'] == 'blue' ? 'selected' : ''); ?>>Electric Blue</option>
                                        <option <?php
                                            if (strcmp($order[0]['wheel_color'], 'black') == 0) {
                                                echo 'selected="selected"';
                                            }
                                    ?> value="black" <?php echo ($order[0]['wheel_color'] == 'black' ? 'selected' : ''); ?>>Jet Black</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('cd-wheel_color'); ?></span>
                                </p>
                            </div>
                        </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-9">
                                <p><input class="address form-control"  type="text" name="cd-address" id="cd-address" value="<?php echo $order[0]['delivery_address']; ?>" placeholder="Address"></p>
                            </div>
                            <div class="col-md-3">
                                <p><input class="address form-control" type="text" name="cd-address2" id="cd-address2" value="<?php echo $order[0]['delivery_address_2']; ?>" placeholder="Apt,Suite,etc"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <p><input class="city form-control"   type="text" name="cd-city" id="cd-city" value="<?php echo $order[0]['city']; ?>" placeholder="City"></p>
                            </div>
                            <div class="col-md-5">
                                <p><input class="state form-control"  type="text" name="cd-state" id="cd-state" value="<?php echo $order[0]['state']; ?>" placeholder="State"></p>
                            </div>
                            <div class="col-md-2">
                                <p><input class="zip form-control" type="text" name="cd-zip" id="cd-zip" value="<?php echo $order[0]['zip']; ?>" placeholder="Zip/Postal Code"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <p class="cd-select">
                                    <select class="cd-country form-control" name="cd-country" id="cd-country">
                                        <option value="">Please select a country...</option> 
                                    <?php
                                    foreach ($countries as $c) {
                                        echo '<option value="' . $c['code'] . '" ' . ((strcmp($order[0]['country'], $c['code']) == 0) ? 'selected="selected"' : '') . '>' . $c['name'] . '</option>';
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
                                <p><input class="main_serial_number form-control" type="text" name="cd-main_serial_number" id="cd-main_serial_number" value="<?php echo $order[0]['main_serial_number']; ?>" placeholder="Main Serial Number"></p>
                            </div>
                            <div class="col-md-4">
                                <p><input class="deck_serial_number form-control" type="text" name="cd-deck_serial_number" id="cd-deck_serial_number" value="<?php echo $order[0]['deck_serial_number']; ?>" placeholder="Deck Serial Number"></p>
                            </div>
                            <div class="col-md-4">
                                <p><input class="firmware_version form-control" type="text" name="cd-firmware_version" id="cd-firmware_version" value="<?php echo $order[0]['firmware_version']; ?>" placeholder="Firmware Version"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <p><input class="tracking_number form-control" type="text" name="cd-tracking_number" id="cd-tracking_number" value="<?php echo $order[0]['tracking_number']; ?>" placeholder="Tracking Number"></p>
                            </div>
                            <div class="col-md-6">
                                <p><input class="shipping_cost form-control" type="text" name="cd-shipping_cost" id="cd-shipping_cost" value="<?php echo $order[0]['shipping_cost']; ?>" placeholder="Shipping Costs"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <p><input class="form-control" type="date" name="cd-est_ship_date" id="cd-est_ship_date" style="padding: 9px;" value="<?php
                                    if ($order[0]['est_ship_date'] > 0) {
                                        echo date("Y-m-d", $order[0]['est_ship_date']);
                                    }
                                    ?>" placeholder="Estimate Shipping Date"></p>
                            </div>
                            <div class="col-md-6">
                                <p><input class="est_ship_location form-control" type="text" name="cd-est_ship_location" id="cd-est_ship_location" value="<?php echo $order[0]['est_ship_location']; ?>" placeholder="Estimate Shipping Location"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <p><input class="order_total form-control" type="text" name="cd-order_total" id="cd-order_total" value="<?php echo $order[0]['order_total']; ?>" placeholder="Total"></p>
                            </div>
                            <div class="col-md-10">
                                <p><input class="invoice_url form-control" type="text" name="cd-invoice_url" id="cd-invoice_url" value="<?php echo $order[0]['invoice_url']; ?>" placeholder="Invoice URL"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <p><textarea class="notes form-control" name="cd-notes" id="cd-notes" placeholder="Add notes to this order"><?php echo $order[0]['notes']; ?></textarea></p>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <div class="col-md-offset-9 col-md-3">
                                <input type="submit" name="cd-submit" class="btn btn-custom btn-lg" value="Save Changes">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        
        <div class="col-md-3">
	  <div class="col-md-12" style="background-color: #fafafa; color: #666;">
							<h4 style="border-bottom:1px solid black;"><span>Customer Details</span> <span><a href="<?php echo base_url('index.php/edit_customer/'.$order[0]['user_id'].''); ?>">edit</a></span></h4>
							<p><?php echo $customer[0]['first_name'].' '.$customer[0]['last_name']; ?></p>
							<p><?php 
								if (sizeof($customer[0]['phone']) > 10) {
									echo '+'.substr($customer[0]['phone'], 0, sizeof($customer[0]['phone']) - 10).' ';
									$customer[0]['phone'] = substr($customer[0]['phone'], sizeof($customer[0]['phone']) - 10);
								}
								echo preg_replace('/(\d{3})(\d{3})(\d{4})/', "$1-$2-$3", $customer[0]['phone']);
								?></p>
								<p><?php echo $customer[0]['email']; ?></p>
                              
                                <h3 style="border-bottom:1px solid black;"><small><span >Last Login</span></small></h3>
                                <p><?php echo date("M j, Y", $customer[0]['last_activity']); ?></p>
							</div>
                                            
							<div class="col-md-12" style="background-color: #fafafa; color: #666;margin-bottom: 20px;">
								<h6 style="border-bottom:1px solid black;"><span >Tasks regarding this customer</span> <span><a href="#">new</a></span></h6>
			</div>			
							<div class="col-md-12" style="background-color: #fafafa; color: #666">
								<h6 style="border-bottom:1px solid black;"><span>Repairs related to this order</span> <span ><a href="/new-service?id=<?php echo $order[0]['user_id'].'&order_id='.$order_id; ?>">new</a></span></h6>
							</div>
					
    </div>
        
        
        <div class="col-md-12" style="background-color: #fafafa;margin-bottom:5%">
				<h3 style="border-bottom: 1px solid #aaa;"><small><span>Order Update Log</span></small></h3>
				<?php 
                                if(!empty($recentOrderLog)){
                                foreach ($recentOrderLog as $i => $log): ?>
						<div class="col-md-12">
							<div class="col-md-1"><?php echo (sizeof($recentOrderLog) - ($i + 1) + 1); ?></div>
							<div class="col-md-2">
								<span><?php echo $log['first_name'].' '.$log['last_name']; ?></span>
							</div>
							<div class="col-md-6">
								<span><?php echo $log['notes']; ?></span>
							</div>
							<div class="col-md-3">
								<span><?php echo date("F j, Y, g:i a", strtotime($log['date'])); ?></span>
							</div>
						</div>
				<?php endforeach; 
                                }else{
                                ?>
                                <div class="col-md-12 text-center">No log found!!</div>
                                <?php } ?>
			</div>
        
</div>
    
    <script>

$(document).ready(function(){
   
        /* date picker */
            $('#cd-est_ship_date').datepicker({
                
                'format' : 'yyyy-mm-dd' 
            });
})
</script>