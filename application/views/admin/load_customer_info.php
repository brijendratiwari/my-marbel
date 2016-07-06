 <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row" >
                <div class="col-lg-12">
                <div class="col-lg-6" style="margin-top: 2%;">
                    <a href="<?php echo base_url('customers');?>" class="btn btn-sm btn-default">Go Back</a>
                 </div>   
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Users Information</h1>
                        
                        
                        <!--user info page-->
                          <div class="col-md-offset-1 user-info">
                            <div class="col-md-6">
                            <div class="col-md-12">
                                <?php if(empty($user_info['user_profile_pic'])){ ?>
                             <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                <?php }else{ ?>
                             <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="<?php echo base_url('assets/profile-imgs/'.$user_info['user_profile_pic'].''); ?>" data-holder-rendered="true">
                                <?php } ?>
                             </div>
                                <div class='clearfix'></div>
                            <div class="col-md-12 text-left">
                                <h3><?php echo (!empty($user_info['first_name']))?$user_info['first_name']." ".$user_info['last_name']:"Empty";?></h3></div>

                              <div class="clearfix"></div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Orders</div>
                                    <div class="panel-body">
                                        
                                          <?php if($user_orders){ foreach ($user_orders as $user_order){?>
                                            <p><label>Order Date : </label> <?php echo (!empty($user_order['order_date']))?date('M j, Y', $user_order['order_date']):"";?></p>
                                            <p><label>Order Number : </label> <?php echo (!empty($user_order['order_number']))?$user_order['order_number']:"";?></p>
                                            <p><label>Product : </label><?php echo (!empty($user_order['product']))?$user_order['product']:"";?></p>
                                            <p><label>Status : </label><?php echo (!empty($user_order['order_friendly_status']))?$user_order['order_friendly_status']:"";?></p>
                                             <p><label>Total : </label><?php echo (!empty($user_order['order_total']))?'$'.$user_order['order_total']:"";?></p>
                                             <hr>
                                        <?php }}else{echo '<p>No Order Found!</p>';} ?>
                                            
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">Service</div>
                                    <div class="panel-body">
                                        <?php if($user_orders){ foreach ($user_orders as $user_order){
                                            $services=getServices($user_order['id']);
                                            if(!empty($services)){
                                            foreach($services as $service){?>
                                                
                                                <p><label>     Date:</label> <?php echo (!empty($service['date']))?date('M j, Y', strtotime($service['date'])):"";?></p>
                                                <p><label>Status : </label> <?php echo (!empty($service['status']))?ucwords($service['status']):"";?></p>
                                                <p><label>Type : </label> <?php echo (!empty($service['type']))?ucwords($service['type']):"";?></p>
                                                <p><label>Issue : </label> <?php echo (!empty($service['issue']))?$service['issue']:"";?></p>
                                                <p><label>Diagnostic Response : </label> <?php echo (!empty($service['diagnostic_response']))?$service['diagnostic_response']:"";?></p>
                                                <p><label>Included Parts : </label> <?php echo (!empty($service['included_parts']))?$service['included_parts']:"";?></p>
                                                <p><label>Notes : </label><?php echo (!empty($service['notes']))? $service['notes']:"";?></p>
                                                <hr>
                                           <?php }
                                            }else{
                                                echo "<p>No Services Found!</p>";
                                            }
                                            ?>
                                            
                                        <?php }}else{
                                                echo "<p>No Services Found!</p>";
                                            } ?>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">Tasks</div>
                                    <div class="panel-body">
                                        Empty
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">Note</div>
                                    <div class="panel-body">
                                        <p><label>Orders : </label> <?php echo (!empty($user_info['note_orders']))?$user_info['note_orders']:"Empty";?></p>
                                        <p><label>Services : </label> <?php echo (!empty($user_info['note_services']))?$user_info['note_services']:"Empty";?></p>
                                        <p><label>Tasks : </label> <?php echo (!empty($user_info['note_tasks']))?$user_info['note_tasks']:"Empty";?></p>
                                        <p><label>Support Tickets : </label> <?php echo (!empty($user_info['note_support_ticket']))?ucwords($user_info['note_support_ticket']):"Empty";?></p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 right-info-section">

                            <div class="panel panel-default">
                                    <div class="panel-heading">Active</div>
                                    <div class="panel-body">
                                        <p><label>Phone : </label> <?php echo (!empty($user_info['notes']))?$user_info['phone']:"Empty";?></p>
                                        <p><label>Email : </label> <?php echo (!empty($user_info['email']))?$user_info['email']:"Empty";?></p>
                                        <p><label>Email Secondary : </label> <?php echo (!empty($user_info['email_secondary']))?$user_info['email_secondary']:"Empty";?></p>
                                        <p><label>Accept marketing : </label> <?php echo (!empty($user_info['accepts']))?ucwords($user_info['accepts']):"Empty";?></p>
                                    </div>
                                </div>


                                    <div class="aka">
                                        A.K.A.
                                    </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading">Default Address</div>
                                    <div class="panel-body">
                                        
                                        <?php 
                                        if(empty($user_info['country']) && empty($user_info['city'])&& empty($user_info['state_or_region'])){
                                        if(!empty($user_orders)){?>
                                        <p><label>City : </label> <?php echo (!empty($user_orders[0]['city']))?$user_orders[0]['city']:"Empty";?></p>
                                        <p><label>State : </label> <?php echo (!empty($user_orders[0]['state']))?$user_orders[0]['state']:"Empty";?></p>
                                        <p><label>Zip : </label> <?php echo (!empty($user_orders[0]['zip']))?$user_orders[0]['zip']:"Empty";?></p>
                                        <p><label>Address : </label> <?php echo (!empty($user_orders[0]['delivery_address']))?ucwords($user_orders[0]['delivery_address']):"Empty";?></p>
                                        <p><label>Address Secondary : </label> <?php echo (!empty($user_orders[0]['delivery_address_2']))?ucwords($user_orders[0]['delivery_address_2']):"Empty";?></p>
                                        <p><label>Country : </label> <?php echo (!empty($user_orders[0]['country']))?ucwords($user_orders[0]['country']):"Empty";?></p>
                                        <?php } else{ echo "Empty";} }else{?>
                                            
                                         <p><label>City : </label> <?php echo (!empty($user_info['city']))?$user_info['city']:"Empty";?></p>
                                        <p><label>State : </label> <?php echo (!empty($user_info['state_or_region']))?$user_info['state_or_region']:"Empty";?></p>
                                        <p><label>Zip : </label> <?php echo (!empty($user_info['postal_code']))?$user_info['postal_code']:"Empty";?></p>
                                        <p><label>Address : </label> <?php echo (!empty($user_info['address_one']))?ucwords($user_info['address_one']):"Empty";?></p>
                                        <p><label>Address Secondary : </label> <?php echo (!empty($user_info['address_two']))?ucwords($user_info['address_two']):"Empty";?></p>
                                        <p><label>Country : </label> <?php echo (!empty($user_info['country']))?ucwords($user_info['country']):"Empty";?></p>
                                       <?php  }?>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">Last Login</div>
                                    <div class="panel-body">
                                        <?php echo (!empty($user_info['last_activity']))?date('M j, Y',$user_info['last_activity']):"Empty";?>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">Support Requests</div>
                                    <div class="panel-body">
                                        Empty
                                    </div>
                                </div>

                                <div class="aka">
                                    <div class="social"><label>TWITTER : </label>  <?php echo (!empty($user_info['twitter_handle']))?$user_info['twitter_handle']:"Empty";?></div>
                                    <div class="social"><label>LINKED IN: </label> <?php echo (!empty($user_info['linkedin_handle']))?$user_info['linkedin_handle']:"Empty";?></div>
                                </div>

                                
                            </div>
                          </div>
                        <!--/.user info page-->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
          
        </div>
        <!-- /#page-wrapper -->
        
        
        <!--user modal ..-->

    
<!-- // user modal ..-->
