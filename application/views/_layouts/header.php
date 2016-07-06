<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<base href="//<?php echo base_url(); ?>">-->
    <title><?php echo ucwords(str_replace('-', ' ', $page)); ?> | My Marbel</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>/assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url(); ?>/assets/dist/css/timeline.css" rel="stylesheet">

        <!-- DataTables CSS -->
    <link href="<?php echo base_url(); ?>/assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo base_url(); ?>/assets/bower_components/datatables-responsive/css/responsive.dataTables.scss" rel="stylesheet">
    
    
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>/assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>/assets/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>/assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
    <!-- Summer note CSS -->
    <link href="<?php echo base_url(); ?>/assets/js/summernote-master/summernote.css" rel="stylesheet">
  
    <!-- datepicker CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
     <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
    
    
    <!--calendar css --> 
    <link href="<?php echo base_url(); ?>/assets/full-calendar/fullcalendar.min.css" rel="stylesheet">
    <link href='<?php echo base_url(); ?>/assets/full-calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    
    
      <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/assets/bower_components/jquery/dist/jquery.min.js"></script>
     <!-- fullcalendar JavaScript -->
    <script src='<?php echo base_url(); ?>/assets/full-calendar/jquery-ui.min.js'></script>
     <script src="<?php echo base_url(); ?>/assets/full-calendar/moment.min.js"></script>
    <script src='<?php echo base_url(); ?>/assets/full-calendar/fullcalendar.min.js'></script>
    <!-- form JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/js/jquery.form.min.js"></script>
    
    
    <!-- form JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/js/summernote-master/summernote.min.js"></script>
    
    <!-- datepicker JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.js"></script>
    
   
   

    <div id="wrapper">
    <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php 
                $user_type=$this->session->userdata['marbel_user']['type'];
                if($user_type==='customer'){?>
                 <a class="navbar-brand" href="<?php echo base_url('customer_profile');?>"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></a>
                <?php } else{?>
                <a class="navbar-brand" href="<?php echo base_url('profile');?>"><img src="<?php echo base_url(); ?>/assets/img/logo.png"></a>
                <?php } ?>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
              
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img data-holder-rendered="true" src="<?php echo !empty(getUserImages($this->session->userdata['marbel_user']['user_id']))?base_url('assets/profile-imgs/'.getUserImages($this->session->userdata['marbel_user']['user_id'])):base_url('assets/images/m_list02..gif');?>" style="width: 30px; height: 30px;" data-src="holder.js/140x140" class="img-circle" alt="140x140">  <?php echo ucwords($this->session->userdata['marbel_user']['first_name'].' '.$this->session->userdata['marbel_user']['last_name']);?>  <i class="fa fa-caret-down"></i></a>
                      
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                         <?php   if($user_type==='customer'){?>
                            <a href="<?php echo base_url('customer_profile'); ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                         <?php } else{?>
                            <a href="<?php echo base_url('profile'); ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                         <?php } ?>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('login/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">  
      