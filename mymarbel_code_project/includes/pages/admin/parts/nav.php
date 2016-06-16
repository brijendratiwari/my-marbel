
<aside>
  <div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="user-details"><img src="/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
      <h5 class="centered"><?php echo $_SESSION['marbel_user']['first_name'].' '.$_SESSION['marbel_user']['last_name']; ?></h5>


      <li class="sub-menu">
        <a href="dashboard" <?php if (strcmp($page, 'dashboard') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-desktop"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="sub-menu">
        <a href="tasks" <?php if (strcmp($page, 'tasks') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-desktop"></i>
          <span>Tasks</span>
        </a>
      </li>

      <li class="sub-menu">
        <a href="calendar" <?php if (strcmp($page, 'calendar') == 0) { echo ' class="active"'; } ?>>
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
        <a href="orders" <?php if (strcmp($page, 'orders') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Orders</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="shipping" <?php if (strcmp($page, 'shipping') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Shipping</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="services?status=pending" <?php if (strcmp($page, 'services') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-bar-chart-o"></i>
          <span>Service</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="email" <?php if (strcmp($page, 'email') == 0) { echo ' class="active"'; } ?>>
          <i class="fa fa-envelope"></i>
          <span>Email</span>
        </a>
      </li>
    </ul>
  </div>
</aside>