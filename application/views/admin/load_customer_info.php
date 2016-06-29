 <!-- Page Content -->
        <div id="page-wrapper">
                <div class="row">
                <div class="col-lg-12">
                <div class="col-lg-6">
                <div id="userSuccess" class="pull-left alert alert-success hidden message"></div>        
                <div class="pull-left alert alert-danger hidden message" id="userError"></div>
                 </div>   
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profile Information</h1>
                        
                        
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
                                            <p>Order Date: <?php echo (!empty($user_order['order_date']))?date('M j, Y', $user_order['order_date']):"";?></p>
                                            <p>Order Number: <?php echo (!empty($user_order['order_number']))?$user_order['order_number']:"";?></p>
                                            <p>Product: <?php echo (!empty($user_order['product']))?$user_order['product']:"";?></p>
                                            <p>Status: <?php echo (!empty($user_order['order_friendly_status']))?$user_order['order_friendly_status']:"";?></p>
                                             <p>Total: <?php echo (!empty($user_order['order_total']))?'$'.$user_order['order_total']:"";?></p>
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
                                                
                                        <p>Date: <?php echo (!empty($service['date']))?date('M j, Y', strtotime($service['date'])):"";?></p>
                                                <p>Status: <?php echo (!empty($service['status']))?ucwords($service['status']):"";?></p>
                                                <p>Type: <?php echo (!empty($service['type']))?ucwords($service['type']):"";?></p>
                                                <p>Issue: <?php echo (!empty($service['issue']))?$service['issue']:"";?></p>
                                                <p>Diagnostic Response: <?php echo (!empty($service['diagnostic_response']))?$service['diagnostic_response']:"";?></p>
                                                <p>Included Parts: <?php echo (!empty($service['included_parts']))?$service['included_parts']:"";?></p>
                                                <p>Notes: <?php echo (!empty($service['notes']))? $service['notes']:"";?></p>
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
                                        <?php echo (!empty($user_info['notes']))?$user_info['notes']:"Empty";?>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 right-info-section">

                            <div class="panel panel-default">
                                    <div class="panel-heading">Active</div>
                                    <div class="panel-body">
                                        <p>Phone: <?php echo (!empty($user_info['notes']))?$user_info['phone']:"Empty";?></p>
                                        <p>Email: <?php echo (!empty($user_info['email']))?$user_info['email']:"Empty";?></p>
                                        <p>Email2: <?php echo (!empty($user_info['email_secondary']))?$user_info['email_secondary']:"Empty";?></p>
                                        <p>Accept marketing: <?php echo (!empty($user_info['accepts']))?ucwords($user_info['accepts']):"Empty";?></p>
                                    </div>
                                </div>


                                    <div class="aka">
                                        A.K.A.
                                    </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading">Deafult Address</div>
                                    <div class="panel-body">
                                       <?php echo (!empty($user_info['address_one']))?$user_info['address_one']:"Empty";?>
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
                                    <div class="social">TWITTER:  <?php echo (!empty($user_info['twitter_handle']))?$user_info['twitter_handle']:"Empty";?></div>
                                    <div class="social">LINKED IN:  <?php echo (!empty($user_info['linkedin_handle']))?$user_info['linkedin_handle']:"Empty";?></div>
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
