 <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                <p class="centered">
                  <a href="<?php echo base_url('profile');?>">
                <img class="img-circle" width="60" src="/assets/img/ui-sam.jpg">
                </a>
                </p>
                <h5 class="centered"><?php if($this->session->userdata('marbel_user')){
                    
                    echo $this->session->userdata['marbel_user']['first_name']." ".$this->session->userdata['marbel_user']['last_name'];
                } ?></h5>
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="javascript:;"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url('tasks');?>"><i class="fa fa-tasks fa-fw"></i> Tasks</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('calendar');?>"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('customers'); ?>"><i class="fa fa-users fa-fw"></i> Users</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('orders');?>"><i class="fa fa-bar-chart-o fa-fw"></i> Orders</a>
                        </li>
<!--                         <li>
                            <a href="<?php echo base_url('update_orders');?>"><i class="fa fa-bar-chart-o fa-fw"></i>Update Orders</a>
                        </li>-->
                        <li>
                            <a href="<?php echo base_url('shipping');?>"><i class="fa fa-shopping-cart fa-fw"></i> Shipping</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('services?status=pending')?>"><i class="fa fa-bank fa-fw"></i> Service</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('inventory')?>"><i class="fa fa-newspaper-o fa-fw"></i> Inventory</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('email');?>"><i class="fa fa-envelope fa-fw"></i> Email</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

