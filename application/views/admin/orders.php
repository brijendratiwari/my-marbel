<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <div class="col-lg-6">
                    
                    <?php if($this->session->flashdata('success')){ ?>
                    
                    <div class="pull-left alert alert-success message">
                        <?php echo $this->session->flashdata('success');?>
                    </div>
                    <?php } ?>
                    
                    <?php if($this->session->flashdata('error')){ ?>
                    
                    <div class="pull-left alert alert-danger message">
                        <?php echo $this->session->flashdata('error');?>
                    </div>
                    <?php } ?>
    
           <div id="orderSuccess" class="pull-left alert alert-success hidden message"></div>
           <div id="orderError" class="pull-left alert alert-danger hidden message"></div>
                 </div>   
                    <div  class="col-lg-6 page-header text-right"><button class="btn btn-success" data-toggle="modal" data-target="#ordersModal">Add New Order</button></div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Orders List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="order-data" style="width:100% !important;">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Order Date</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Order Status</th>
                                            <th>Tracking Number</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    </tbody>
                                </table>
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



<!--Order modal ..-->

<form id="add-row-form" action="<?php echo base_url('index.php/add_order') ?>" method="POST">
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
									<input type="text" name="cd-email" class="form-control" placeholder="Email" >
                                                                         <span id="cd-email" class="text-danger hidden"></span>
								</div>
							</div>
						</div>
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-9">
									<input type="text" name="cd-address" class="form-control" placeholder="Delivery Address" >
                                                                        <span id="cd-address" class="text-danger hidden"></span>
								</div>
								<div class="col-md-3">
									<input type="text" name="cd-address2" class="form-control" placeholder="Apt,Suite,etc" />
								</div>
							</div>
						</div>  
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-4">
									<input type="text" name="cd-city" class="form-control" placeholder="City" >
                                                                         <span id="cd-city" class="text-danger hidden"></span>
								</div>
								<div class="col-md-4">
									<input type="text" name="cd-state" class="form-control" placeholder="State" >
                                                                        <span id="cd-state" class="text-danger hidden"></span>
								</div>
								<div class="col-md-4">
									<input type="text" name="cd-zip" class="form-control" placeholder="Zip Code" >                                                  <span id="cd-zip" class="text-danger hidden"></span>
								</div>
							</div>
						</div> 
						<div class="form-group" style="height:30px">
							<div class="row-fluid">
								<div class="col-md-12">
									<select name="cd-country" type="text" class="form-control" placeholder="Country" > 
										<option value="">Please select a country...</option> 
										<?php
										foreach ($countries as $c) {
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
                               <div class="checkout_loader hidden" id="form_loader">
                                    <div class="overlay new_loader"></div>
                                    <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/assets/images/chekout-loading.gif'); ?>" /></div>
                                   </div>
                            
			</div>
		</div>
	</form>

<!-- // Order modal ..-->




<script>

$(document).ready(function(){
    
      var base_url = $('body').find('#base_url').val();
    
        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#ordersModal #form_loader').removeClass('hidden');
            },
            url: base_url+'add_order',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#ordersModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#ordersModal #" + index2).text(msg);
                            $("#ordersModal #" + index2).removeClass('hidden');
                        });
                    });
                }
                else {
                    $('body').find('#ordersModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#ordersModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#orderSuccess").text(err.success);
                        $("#orderSuccess").removeClass('hidden');
                        
                         setTimeout(function () {
                            $('body').find('#ordersModal').modal('hide');
                        }, 1000)
                  }
                    else {
                        $('body').find('#ordersModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                         $("#orderError").text(err.success);
                        $("#orderError").removeClass('hidden');
                        setTimeout(function () {
                            $('body').find('#ordersModal').modal('hide');
                        }, 1000)
                    }
                }
            }
        };
        $('body').find('#add-row-form').ajaxForm(options);
    
})


/* js function for delete order */

  function deleteOrder(order_number){
      
      
       if (confirm('Are you sure you want to delete?'))
        {
            window.location.href = "<?php echo base_url() ?>delete_order/" + order_number;
        }
      
  }
</script>
    

