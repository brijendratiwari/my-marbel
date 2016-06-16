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
    <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
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
          <li><a class="logout" href="/login/logout">Logout</a></li>
        </ul>
      </div>
    </header>