 <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                <p class="centered">
                  <a href="<?php echo base_url('index.php/customer_profile');?>">
                <img class="img-circle" width="60" src="/assets/img/ui-sam.jpg">
                </a>
                </p>
                <h5 class="centered"><?php if($this->session->userdata('marbel_user')){
                    
                    echo $this->session->userdata['marbel_user']['first_name']." ".$this->session->userdata['marbel_user']['last_name'];
                } ?></h5>
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="customer"><i class="fa fa-desktop"></i> Dashboard</a>
                        </li>
                        
                        
                       
                        <li>
                            <a href="order"><i class="fa fa-tag"></i> Orders</a>
                        </li>
                        <li>
                            <a href="ride_reports"><i class="fa fa-bar-chart-o"></i> Ride Report</a>
                        </li>
                        <li>
                            <a href="support"><i class="fa fa-envelope fa-fw"></i> Support</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

