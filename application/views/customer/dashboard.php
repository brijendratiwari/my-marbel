<?php $status = '';
$status_level = 0;
$invoice = '';
$estShipping = '';
$tracking = '';
if (!empty($orders)) {
	foreach ($orders as $order) {
		$status = $order['order_status'];
		$invoice = $order['invoice_url'];
		$estShipping = $order['friendly_est_ship_date'];
		$tracking = $order['tracking_number'];
	}
}
if ($status == 'refunded') {
	$status_level = 1;
} else if ($status == 'deposit') {
	$status_level = 2;
} else if ($status == 'balance') {
	$status_level = 3;
} else if ($status == 'building') {
	$status_level = 4;
} else if ($status == 'qa') {
	$status_level = 5;
} else if ($status == 'shipping') {
	$status_level = 6;
} else if ($status == 'shipped') {
	$status_level = 7;
} else if ($status == 'hold') {
	$status_level = 8;
}
?>

<div id="page-wrapper">
<div class="row">
           <?php if ($status_level == 1) { ?>
		<div class="col-md-12" style="margin-top:10%;">
			<p style="text-align: center; color: #00aeef;font-size:30px;"> The order for your Marbel Board been canceled and your refund has been processed. <br></p>
		</div>
		<?php } else if ($status_level == 2) { ?>
		<div class="col-md-12">
			<img src="/assets/img/deposit.svg" style="display: block; margin-left: auto; margin-right: auto">  
		</div>
    <div class="col-md-12">
		<table class="video" width="100%">
			<tr>
				<td align="center" valign="top" width="100%">
					<p> Thank you for your deposit, you have secured your spot in line!</p>
					<br/>
					<p> Hold on there! Before you pay your balance <strong>PLEASE</strong> check your order details thoroughly!</p>
					<div class="col-md-12">
						<a href="orders"><button type="button" class="btn">Edit Order Details</button></a> &nbsp &nbsp <a href="<?php echo $invoice ?>" target=“_blank”><button type="button" class="btn2">Pay My Balance</button></a>
					</div>
					<h3 class="small" style="color: #777; margin-top: 30px; font-size: 13px"> <i>*The Marbel Board is now in full production and shipping from our production facility in Tampa, Florida. </br> Due to overwhelming demand, estimated ship date is usually 2-4 weeks after your order balance is paid.</i></h3>
				</td>
			</tr>
		</table>
    </div>
		<hr>
                <div class="col-md-12">
		<h1 class="videos">See the Marbel Board in action!</h1>
		<div class="col-md-6">
		
						<iframe width="500" height="281" src="https://player.vimeo.com/video/146958461" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen=""></iframe>
					</div>
					<div class="col-md-6">
						<iframe width="500" height="281" src="https://player.vimeo.com/video/126624405" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen=""></iframe>
					</div>
				
                </div>
		<?php } else if ($status_level == 3) { ?>
		<div class= "col-md-12">
			<img src="/assets/img/balance.svg" style="display: block; margin-left: auto; margin-right: auto">  
		</div>
		<div class= "col-md-12">
			<p style="text-align: center; color: #00aeef; font-size: 32px ">  
				<strong>Thank your for your payment!</strong> </p>
				<p style="text-align: center; color: #777; ">Your order details can be changed at any time before shipping. <br/></p>
			</div>  
                <div class="col-md-12 text-center">
				
							<button type="button" class="btn"><a href="orders">Edit Order Details</a></button> &nbsp &nbsp 
			
                    </div>
			<h1 class="text-center"><strong>Shipping Estimate:</strong> <?php echo $estShipping ?></h1>
		
		<hr>
		<div class="col-md-12">
		<h1 style="border: 1px solid; border-color:#777;text-align: center;">Get to know your Marbel Remote </h1>
		<div class="col-md-8">
						<img src="http://cdn.shopify.com/s/files/1/0324/8561/files/blog-remote-14-2_grande.jpg?1862028360901466212">
					</div>
					<div class="col-md-4">
						<h1>Designed for confident control.</h1>
						<p style="">Made from a combination of fiber reinforced Nylon and ABS, the Marbel Remote has been engineered to be strong and incredibly durable. The anatomical design and smooth matte finish fit comfortably in your hand, providing you an intuitive rider experience that is fun and easy to learn. 
						</p>
                    		</div>
                </div>
                <div class="col-md-12">
			<div class="col-md-4">
						<h1>Safety.  In a switch.</h1>
						<p> Our Safety Switch is a unique feature which ensures the remote only sends throttle data when held in your hand. We also took it a bit further by building in a distinctive tactile "click" into the Safety Switch.  You not only can feel the tactile "click" but also hear it as well. </p>
					</div>
                    <div class="col-md-8">
						<img src=" https://ksr-ugc.imgix.net/assets/003/799/423/c79e886f30bd344d0feada7564b98c7b_original.jpg?v=1431714383&w=700&h=&fit=max&auto=format&q=92&s=be4528d50fd923b3e1ee1c49e1661c15">
					
                </div>
              </div>
                <div class="col-md-12">
                <div class="col-md-9">
		
						<img src="https://ksr-ugc.imgix.net/assets/003/793/987/9992db0ac4d66cb31a29ec6408179304_original.jpg?v=1431643612&w=700&h=&fit=max&auto=format&q=92&s=b973c41b4c904efb28decec3cf872083">
					</div>
					<div class="col-md-3">
						<h1>Power in your hands, to go and slow.</h1>
						<p style="padding: 30px;">With our Throttle Slider you simply push forward to go forward. The further you push the slider forward, the faster your Marbel Board goes. If you release the throttle, it springs back to center to coast just like a normal skateboard. To slow yourself down just pull the throttle slider back towards you for variable but strong regenerative braking. </p>
					</div>
			
                </div>
		<hr />
                <div class="col-md-12">
			<h1 class="videos">Take a look at the Marbel Remote in action.</h1>
		
			      <div class="col-md-6">
						<iframe width="500" height="281" src="https://player.vimeo.com/video/140472251" frameborder="0" allowfullscreen="" style="left-margin: 200px;" mozallowfullscreen="" webkitallowfullscreen=""></iframe>
					</div>
                        <div class="col-md-6">
						<iframe width="500" height="281" src="https://player.vimeo.com/video/136043144" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen=""></iframe>
				</div>
                </div>
		<?php } else if ($status_level == 4) { ?>
		<div class= "col-md-12">
			<img src="/assets/img/building.svg" style="display: block; margin-left: auto; margin-right: auto">  
		</div>
		<div class= "col-md-12">
			<p style="text-align: center; color: #00aeef; font-size: 32px ">  
				<strong>Your Marbel Board is being built!</strong> 
			</p>
			<p style="text-align: center; color: #777; ">  
				Your new Marbel Board is currently being built. It won't be long before it's under your feet!  <br/>
				In the mean time, take a few minutes to learn a little more about the features of your Marbel Board.     <br/> 
			</p>
			<h1 class="text-center"> <strong>Shipping Estimate:</strong> <?php echo $estShipping ?></h1>
		</div>
		<hr>
                <div class="col-md-12">
		<h1 style="border: 1px solid; border-color:#777;text-align:center">The Marbel Nose. Knows. </h1>
		<div class="col-md-8">
						<img src="https://ksr-ugc.imgix.net/assets/003/680/229/0ae140f0957876a3668522d0c3cbc1f5_original.gif?v=1430067950&w=639&fit=max&q=92&s=e1c716116fd6584ce050459c29a7bc76">
					</div>
					<div class="col-md-4">
						<h1>Power on. Power off.</h1>
						<p style="">It's very easy to get started. To turn on your Marbel Board, simply hold down the power button for two seconds and the LED indicators will illuminate from left to right and then proceed to show you your battery level. To turn the board off, just repeat the process and the LED indicators will step back down from right to left.  <br/><br/>
							When the power is on and no other actions are being performed, the LED indicators show the battery level of your Marbel Board.  There are a total of eight LEDs and each one indicates roughly 1.5 to 1.75 miles of range left in the battery. Over time the battery indicator will continue to self calibrate and become more accurate to your riding style the more you ride your Marbel Board. 
						</p>
					</div>
				
                </div>
                <div class="col-md-12">
                <div class="col-md-4">
		
						<h1>As simple as clicking a button. Twice</h1>
						<p> The power button also can function to quick change the riding modes of your Marbel Board.  While your Marbel Board is turned on, simply tap the button twice. This will cycle through four possible options. <br/><br/>
							<b>Starter Mode:</b> (One LED blinking) The best mode to get started.  <br/>
							<b>ECO Mode:</b> (Two LEDs blinking) Get the maximum range out of your ride. <br/>
							<b>Sport Mode:</b> (Three LEDs blinking) 25 MPH top speed and max power.<br/>
							<b>Custom Mode:</b> (Four LEDs blinking) Your last custom mode you setup with the Marbel Smartphone App. <br/>
						</p>
					</div>
					<div class="col-md-8">
						<img src=" https://ksr-ugc.imgix.net/assets/003/680/440/a73106e8b3ebd312a3dc7744d2d61141_original.gif?v=1430070783&w=639&fit=max&q=92&s=f2e0e4d571572b5b195341de85b9bfc3">
					</div>
				
                    </div>
                <div class="col-md-12">
                    <div class="col-md-8">
						<img src=" https://ksr-ugc.imgix.net/assets/003/735/595/b2078df96b8fd836892c94d8c85b395a_original.jpg?v=1430843966&w=700&h=&fit=max&auto=format&q=92&s=289f987196e7c11e9fc93e80fa8ee83a">
					</div>
					<div class="col-md-4">
						<h1>More to see.</h1>
						<p> The front bumper of the Marbel Board actually does more than just turning your board on, changing modes, and protecting the board from impacts. Hidden inside the water resistant door, it also houses the charging and USB port. 
						</p>
					</div>
                </div>
                <div class="col-md-12">
                <div class="col-md-4">
		
						<h1>Plug in. Charge up.</h1>
						<p style="padding: 30px;">The nose of the Marbel Board also contains two charging ports. One specifically to charge your Marbel Board (a round barrel port) and the other is a USB port to charge your Marbel remote... or almost any other gadget you would like. 
							When charging your board, the LED indicator will light up just like it does when riding the board, but in reverse. The LED indicator will climb to the right as the board becomes fully charged. <br/><br/>
							With the Marble Smartphone App you can even check on your Marbel Board's charging process and see an estimate of how much longer until your board is fully charged and ready to roll.  
						</p>
					</div>
					 <div class="col-md-8">
						<img src="https://ksr-ugc.imgix.net/assets/003/682/001/549cbf93f22a2f64f86f1c29e7decc7a_original.gif?v=1430089918&w=639&fit=max&q=92&s=addf8406a7122eb677dbb72685e070c5">
					</div>
                    </div>
		<hr>
                <div class="col-md-12">
		<h1 style="border: 1px solid; border-color:#777;text-align:center"> Don't forget the tail... </h1>
		<div class="col-md-8">
						<img src="https://ksr-ugc.imgix.net/assets/003/735/573/a2dc5e1d8a7e46c9d5b24ef8c94ac491_original.jpg?v=1430843660&w=700&h=&fit=max&auto=format&q=92&s=3f16f1002b583d6c0aa014010d8816ea">
					</div>
					<div class="col-md-4">
						<h1>We've got it covered. And sealed</h1>
						<p style="padding: 30px;">We all carry and move with the Marbel Board in different ways, that is why the tail of your board also has a bumper made of ultra rugged silicone to protect it from any impacts. <br/><br/>
							On top of that our first of it's kind unibody deck (patent pending) design keep the electronics and batteries safely protected within from any weather you might find out on the road.   
						</p>
					</div>
                </div>
		<?php } else if ($status_level == 5) { ?>
		<div class= "col-md-12">
			<img src="/assets/img/quality.svg" style="display: block; margin-left: auto; margin-right: auto">  
		</div>


		<div class= "col-md-12">
			<p style="text-align: center; color: #00aeef; ">  
				Your Marbel Board is in the final stages of it's build process and going through quality assurance.<br/>
				We have extremely intense quality control tests, you will be riding in no time for a long time!  <br/> 
			</p>
			<h1 class="text-center"> <strong>Shipping Estimate:</strong> <?php echo $estShipping ?></h1>
		</div>
		<hr>
		<div class="col-md-12">
			<img style="margin-right: auto; margin-left: auto; display: block;" src="/assets/img/check-1.svg">  
		</div>
		<div class="col-md-12">
			<img style="margin-right: auto; margin-left: auto; display: block;" src="/assets/img/check-2.svg">  
		</div>
		<div class="col-md-12">
			<img style="margin-right: auto; margin-left: auto; display: block;" src="/assets/img/check-3.svg">  
		</div>
		<?php } else if ($status_level == 6) { ?>
		<div class= "col-md-12">
			<img src="/assets/img/shipping.svg" style="display: block; margin-left: auto; margin-right: auto">  
		</div>
		<div class= "col-md-12">
			<h1 style="text-align: center; color: #00aeef; font-size: 40px;">  
				You board is finally shipping!!   <br/> 
			</h1>
			<p style="text-align: center; color: #666666; font-size: 15px;">  
				<br/>
				<strong>Thank you for all of your support and enthusiasm! </strong>
				<br/> Your Marbel Board is being packaged and will be shipped with UPS Ground. 
				<br/>Please allow up to 3 business days for your tracking number to become active. 
			</p>
		</div>
		<h1><strong>Tracking Number:</strong> <a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=<?php echo $tracking ?>" target="_blank"> <?php echo $tracking ?></h1>  
        <?php } else if ($status_level == 7) { ?>
		<div class= "col-md-12">
			<img src="/assets/img/shipping.svg" style="display: block; margin-left: auto; margin-right: auto">  
		</div>
		<div class= "col-md-12">
			<h1 style="text-align: center; color: #00aeef; font-size: 40px;">  
				You board has shipped!!   <br/> 
			</h1>
			<p style="text-align: center; color: #666666; font-size: 15px;">  
				<br/>
				<strong>Thank you for all of your support and enthusiasm! </strong>
				<br/> Your Marbel Board has been picked up by UPS. 
				<br/>Please allow up to 24 for your tracking number to show movement. 
			</p>
		</div>
		<h1><strong>Tracking Number:</strong> <a href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=<?php echo $tracking ?>" target="_blank"> <?php echo $tracking ?></h1>    
		<?php } else if ($status_level == 8) { ?>
		<div class="col-md-12" style="margin-top:10%;">
			<p style="text-align: center; color: #00aeef;font-size:30px;">  The order for your Marbel Board is on hold. Please contact us to verify your order details. <br></p>
		</div>
		<?php } else { ?>
		<h2> We could not find any order history for you</h2>
		<?php } ?>
    </div>
    </div>
