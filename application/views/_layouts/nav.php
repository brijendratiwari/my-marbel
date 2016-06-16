 <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                <p class="centered">
                  <a href="profile">
                <img class="img-circle" width="60" src="/assets/img/ui-sam.jpg">
                </a>
                </p>
                <h5 class="centered">Nidhi Barve</h5>
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="javascript:;"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                        <li>
                            <a href="javascript:;"><i class="fa fa-tasks fa-fw"></i> Tasks</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/customers'); ?>"><i class="fa fa-users fa-fw"></i> Customers</a>
                        </li>
                        <li>
                            <a href="orders"><i class="fa fa-bar-chart-o fa-fw"></i> Orders</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="fa fa-shopping-cart fa-fw"></i> Shipping</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="fa fa-bar-chart fa-fw"></i> Service</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="fa fa-envelope fa-fw"></i> Email</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

<!--<aside>
  <div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="javascript:;"><img src="/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
      <h5 class="centered"><?php //echo $_SESSION['marbel_user']['first_name'].' '.$_SESSION['marbel_user']['last_name']; ?></h5>


      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'dashboard') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-desktop"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'tasks') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-desktop"></i>
          <span>Tasks</span>
        </a>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'calendar') == 0) { echo ' class="active"'; } ?>>
          <i class="fa li_tag"></i>
          <span>Calendar</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="customers" <?php if (strcmp($page, 'customers') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-book"></i>
          <span>Customers</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'orders') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Orders</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'shipping') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Shipping</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'services') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Service</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;" <?php if (strcmp($page, 'email') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-envelope"></i>
          <span>Email</span>
        </a>
      </li>
    </ul>
  </div>
</aside>-->