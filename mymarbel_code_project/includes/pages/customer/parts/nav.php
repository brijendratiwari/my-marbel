
<aside>
  <div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="profile"><img src="/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
      <h5 class="centered"><?php echo $_SESSION['marbel_user']['first_name'].' '.$_SESSION['marbel_user']['last_name']; ?></h5>


      <li class="sub-menu">
        <a href="dashboard" <?php if (strcmp($page, 'dashboard') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-desktop"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="orders" <?php if (strcmp($page, 'orders') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-tag"></i>
          <span>Orders</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="ride-reports" <?php if (strcmp($page, 'ride-reports') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Ride Reports</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="support" <?php if (strcmp($page, 'support') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-envelope"></i>
          <span>Support</span>
        </a>
      </li>
    </ul>
  </div>
</aside>