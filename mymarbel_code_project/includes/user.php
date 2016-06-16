 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="">

    <title><?php echo ucwords(str_replace('-', ' ', $page)); ?> | My Marbel</title>

    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/assets/lineicons/style.css">    
    <link rel="stylesheet" type="text/css" href="/assets/lineicons/style.css">    
    <link rel="stylesheet" type="text/css" href="/assets/js/datatables/css/jquery.datatables.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/js/datatables/css/jquery.datatables_themeroller.css"/> 
    <link rel="stylesheet" type="text/css" href="/assets/js/x-editable/bootstrap3-editable/css/bootstrap-editable.css">
    <link rel="stylesheet" type="text/css" href="/assets/js/summernote-master/summernote.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/style-responsive.css" rel="stylesheet">
</head>
<body>
  <section id="container" >

  <header class="header black-bg">
        <div class="sidebar-toggle-box">
          <div class="fa fa-bars tooltips" STYLE="color: #fff"` data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="index" class="logo"><b><img src="/assets/img/logo.png"></b></a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
          <!--  notification start -->
          <ul class="nav top-menu">
            
           
          </ul>
          <!--  notification end -->
        </div>
        <div class="top-menu">
         <ul class="nav pull-right top-menu">
          <li><a class="logout" href="/logout">Logout</a></li>
        </ul>
      </div>
    </header>

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


<section id="main-content">
<section class="wrapper">

  <div class="col-md-9 col-md-offset-1 user-info" style="padding-top:100px;">
   
   

    <div class="col-md-6 left-info-section">
     <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
      <h2>Harmani Owens</h2>

      <div class="clearfix"></div>
        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>
            <div class="panel-body">
                <input type="text">
                    
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Service</div>
            <div class="panel-body">
                Empty
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
                Empty
            </div>
        </div>

<button class="btn btn-default btn-small" style="border:none"><span class="glyphicon glyphicon-plus-sign"></span> Add note</button>
    </div>
    <div class="col-md-6 right-info-section">

    <div class="panel panel-default">
            <div class="panel-heading">Active</div>
            <div class="panel-body">
                <p>Phon:</p>
                <p>Email:</p>
                <p>Email2:</p>
                <p>Accept marketing:</p>
            </div>
        </div>

        
            <div class="aka">
                A.K.A.
            </div>
       

        <div class="panel panel-default">
            <div class="panel-heading">Deafult Address</div>
            <div class="panel-body">
                Empty
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Last Login</div>
            <div class="panel-body">
                Empty
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Support Requests</div>
            <div class="panel-body">
                Empty
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>
            <div class="panel-body">
                Empty
            </div>
        </div>
        <div class="aka">
            <div class="social">TWITTER:</div>
            <div class="social">LINKED IN:</div>
        </div>

        <div class="text-right">
          <button class="btn btn-info">NEW PASSWORD RESET</button>
        </div>
    </div>
  </div>

</section>
</section>

<style>
  .user-info h2{
    float: left;
    font-family: "ProximaNova-light",sans-serif;
    font-size: 50px;
    font-weight: normal;
    padding: 32px;
    margin:0 0 60px;
    color:#E1E1E1;
  }
  .user-info .left-info-section .panel{
    min-height:170px;
  }
  .user-info .right-info-section .panel{
    min-height:220px;
    margin-bottom:8px;
  }
.user-info .panel-heading{
    background: #cccccc none repeat scroll 0 0;
    color: #777777;
    font-family: helvetica;
    font-size: 20px;
    font-weight: normal;
    padding: 0 10px;
}
.user-info .panel{
   background:#e1e1e1;
  }
.aka {
    background: #e1e1e1 none repeat scroll 0 0;
    margin-bottom: 10px;
    padding: 15px;
}
.user-info .social{
  font-size:16px;
  color:#777;
  padding:7px;
}
.user-info .right-info-section p
{
  font-size:13px;
  margin:0;
}
</style>