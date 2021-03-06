<div id="page-wrapper">
    <div class="row">
     
		<?php if ($this->session->flashdata('error')) { ?>
            <div class="col-md-12 alert alert-danger" style="margin-top: 5px;">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="col-md-12 alert alert-success" style="margin-top: 5px;">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php
        }?>
		<div class="col-md-12" style="margin-top: 5px;">
				<?php echo '<form>
				<legend>Your Order Details</legend>	
				<div class="form-group">
					<span class="orderName col-md-offset-3 col-md-3" style="text-align: right">Order Number: </span>
					<div class="col-md-3 form-group"><select name="orders" id="orders" class="form-control" style="padding: 5px; margin: 0px;">';
						$activeOrderNumber = '';
                                                if(!empty($orders)){
						foreach ($orders as $order) {
							if (empty($activeOrderNumber)) { $activeOrderNumber = $order['order_number']; }
							echo '<option '.((strcmp($order['country'], '') !== FALSE) ? 'selected="selected"' : '').' value="order-'.$order['order_number'].'">'.$order['order_number'].'</option> ';
						}
                                        }else{
                                            echo '<option>No order found</option>';
                                        }
						echo '</select></div></div></form>';
						echo '</div>';
						echo '<div class="orders">';
                                                if(!empty($orders)){
						foreach ($orders as $order) {
							echo '<div id="order-'.$order['order_number'].'" '.($order['order_number'] == $activeOrderNumber ? '' : 'style="display: none;"').'>';
							echo '<div class=" order_total col-md-12 form-group">';
							echo '<span class="orderName col-md-offset-3 col-md-3" style="text-align: right"> Order Total: </span>';
							echo '<span class="orderElement col-md-3" style="text-align:left;">$'.number_format($order['order_total'], 2, '.', ',').'</span>';
							echo '</div>';

							echo '<div class=" order_status form-group col-md-12">';
							echo '<span class="orderName col-md-offset-3 col-md-3" style="text-align: right"> Order Status: </span>';
							echo '<span class="orderElement col-md-3" style="text-align:left;">'.$order['order_friendly_status'].'</span>';
							echo '</div>';

							echo '<div class=" order_date form-group col-md-12">';
							echo '<span class="orderName col-md-offset-3 col-md-3" style="text-align: right"> Order Date: </span>';
							echo '<span class="orderElement col-md-3" style="text-align:left;">'.date('F j, Y', $order['order_date']).'</span>';
							echo '</div>';

							echo '<div class="form-group item_ordered col-md-12">';
							echo '<span class="orderName col-md-offset-3 col-md-3" style="text-align: right"> Item Ordered: </span>';
							echo '<span class="orderElement col-md-3" style="text-align:left;">'.$order['product'].'</span>';
							echo '</div>';

							if ($order['order_status'] == 'balance' || $order['order_status'] == 'building' || $order['order_status'] == 'qa' || $order['order_status'] == 'shipping') {
								echo '<div class="form-group shipping_estimate col-md-12">';
								echo '<span class="orderName col-md-offset-3 col-md-3" style="text-align: right"> Shipping Estimate: </span>';
								echo '<span class="orderElement col-md-3" style="text-align:left;">'.$order['friendly_est_ship_date'].'</span>';
								echo '</div>';
							}

							if ($order['order_status'] == 'shipping') {
								echo '<div class="form-group tracking_number col-md-12">';
								echo '<span class="orderName col-md-offset-3 col-md-3" style="text-align: right"> Tracking Number: </span>';
								echo '<span class="orderElement col-md-3" style="text-align:left;"><a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum='.$order['tracking_number'].'" target="_blank">'.$order['tracking_number'].'</a></span>';
								echo '</div>';
							}

							echo '</div>';
						}}
						echo '</div>';
						?>
					<div id="shipping-orders">
						<?php
                                                if(!empty($orders)){
						foreach ($orders as $order) {
							?>
							<form id="shipping-order-<?php echo $order['order_number']; ?>" class="cd-form floating-labels" style="text-align: center; color: #777;<?php echo ($order['order_number'] == $activeOrderNumber ? '' : 'display: none;'); ?>" method="POST" action="">
								<legend>Edit Your Shipping Details</legend>
								<input type="hidden" name="cd-order-number" value="<?php echo $order['order_number']; ?>" />
								<input type="hidden" name="cd-order-id" value="<?php echo $order['id']; ?>" />
									<div class="col-md-12">
										<div class="col-md-6">
											<p class="cd-select">
												<select class="cd-wheel_size form-control" name="cd-wheel-size" id="cd-wheel-size">
													<option <?php if (strcmp($order['wheel_size'], '76') == 0) { echo 'selected="selected"'; } ?> value="76" <?php echo ($order['wheel_size'] == 76 ? 'selected' : ''); ?>>76mm</option>
													<option <?php if (strcmp($order['wheel_size'], '100') == 0) { echo 'selected="selected"'; } ?> value="100" <?php echo ($order['wheel_size'] == 100 ? 'selected' : ''); ?>>100mm</option>
												</select>
											</p>
										</div>
										<div class="col-md-6">
											<p class="cd-select">
												<select class="cd-wheel_color form-control" name="cd-wheel-color" id="cd-wheel-color" required>
													<option <?php if (strcmp($order['wheel_color'], 'blue') == 0) { echo 'selected="selected"'; } ?> value="blue" <?php echo ($order['wheel_color'] == 'blue' ? 'selected' : ''); ?>>Electric Blue</option>
													<option <?php if (strcmp($order['wheel_color'], 'black') == 0) { echo 'selected="selected"'; } ?> value="black" <?php echo ($order['wheel_color'] == 'black' ? 'selected' : ''); ?>>Jet Black</option>
												</select>
											</p>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-md-9">
											<p><input class="address form-control" type="text" name="cd-address" id="cd-address" value="<?php echo $order['delivery_address']; ?>" placeholder="Address"></p>
										</div>
										<div class="col-md-3">
											<p><input class="address form-control" type="text" name="cd-address2" id="cd-address2" value="<?php echo $order['delivery_address_2']; ?>" placeholder="Apt,Suite,etc"></p>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-md-5">
											<p><input class="city form-control" type="text" name="cd-city" id="cd-city" value="<?php echo $order['city']; ?>" placeholder="City"></p>
										</div>
										<div class="col-md-5">
											<p><input class="state form-control" type="text" name="cd-state" id="cd-state" value="<?php echo $order['state']; ?>" placeholder="State"></p>
										</div>
										<div class="col-md-2">
											<p><input class="zip form-control" type="text" name="cd-zip" id="cd-zip" value="<?php echo $order['zip']; ?>" placeholder="Zip/Postal Code"></p>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-md-12">
											<p class="cd-select">
												<select class="cd-country form-control" name="cd-country" id="cd-country">
													<option value="">Please select a country...</option> 
													<?php
                                                                                                       
													foreach ($countries as $c) {
														echo '<option value="'.$c['code'].'" '.((strcmp($order['country'], $c['code']) == 0) ? 'selected="selected"' : '').'>'.$c['name'].'</option>';
													}
													?>
												</select>
											</p>
										</div>
									</div>

									<div class="col-md-12 text-right">
                                                                                    <a href='<?php echo base_url('order'); ?>' class='btn btn-custom btn-lg'>Back</a>
											<input type="submit" name="cd-submit" class="btn btn-custom btn-lg" value="Save Changes">
									</div>
						</form>
						<?php } } ?>
					</div>

</div>
            </div>
            </div>