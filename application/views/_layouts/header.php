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

          <!--Add CSS From Controller-->  
        <?php
        if (isset($style_to_load)) :
            foreach ($style_to_load as $css):
                ?>
                <link href="<?php echo base_url($css); ?>" rel="stylesheet"/>
                <?php
            endforeach;
        endif;
        ?>    

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

        <?php
        if (isset($scripts_to_load)) :
            foreach ($scripts_to_load as $script):
                ?>

                <script type='text/javascript' src = '<?= base_url($script) ?>'></script>

                <?php
            endforeach;
        endif;
        ?>



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
                    $user_type = $this->session->userdata['marbel_user']['type'];
                    if ($user_type === 'customer') {
                        ?>
                        <a class="navbar-brand" href="javascript:;"><img src="<?php echo base_url(); ?>/assets/img/logo.jpg"></a>
                    <?php } else { ?>
                        <a class="navbar-brand" href="javascript:;"><img src="<?php echo base_url(); ?>/assets/img/logo.jpg"></a>
<?php } ?> <button type="button" class="bugger-icon bar" style="display:block"> 
                        <span class="fa fa-bars fa-lg"></span>
                    </button>
                        <button type="button" class="bugger-icon bar-call-back" style="display:none"> 
                        <span class="fa fa-bars fa-lg"></span>
                    </button>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">



                    <!-- /.dropdown -->
                    <li class="dropdown">

                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <img data-holder-rendered="true" src="<?php echo!empty(getUserImages($this->session->userdata['marbel_user']['user_id'])) ? base_url('assets/profile-imgs/' . getUserImages($this->session->userdata['marbel_user']['user_id'])) : base_url('assets/img/ui-sam.jpg'); ?>" style="width: 30px; height: 30px;" data-src="holder.js/140x140" class="img-circle" alt="140x140">  <?php echo ucwords($this->session->userdata['marbel_user']['first_name'] . ' ' . $this->session->userdata['marbel_user']['last_name']); ?>  <i class="fa fa-caret-down"></i></a>

                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <?php if ($user_type === 'customer') { ?>
<!--                                    <a href="<?php echo base_url('customer_profile'); ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>-->
                                <?php } if ($user_type === 'admin') { ?>
                                    <a href="<?php echo base_url('profile'); ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
<?ph                                <?php } ?>
                            </li>
                            <li><a data-target="#resetPasswordUserModal" href="#" data-toggle="modal"><i class="fa fa-key fa-fw"></i> Reset Password</a></li>
                            <li><a href="<?php echo base_url('login/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">  
                <!--Reset password model-->
                <form id="resetPasswordUser-row-form" action="" method="POST" enctype="multipart/form-data">
                    <div class="modal fade" id="resetPasswordUserModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Reset Password <span class="label label-info"></span></h4>
                                </div>

                                <div class="modal-body">

                                    <div class="col-md-12">
                                        <div class="co-md-12 form-group" > 
                                            <div id="resetPasswordSuccess" class="pull-left alert  alert-success hidden  message"></div>        
                                            <div class="pull-left alert  alert-danger hidden message" id="resetPasswordError"></div></div>
                                        <div class="col-md-12 form-group">
                                            <label>New Password</label>
                                            <input type="password" name="cd-password" class="form-control" placeholder="New Password" >
                                            <span id="cd-password" class="text-danger hidden"></span>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="cd-confirm-password" class="form-control" placeholder="Confirm Password" >
                                            <span id="cd-confirm-password" class="text-danger hidden"></span>
                                        </div>
                                    </div>


                                </div>
                                <div class="clearfix"></div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="<?php echo $this->session->userdata['marbel_user']['user_id']; ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="add-row" class="btn btn-success">Submit New Password</button>
                                </div>
                            </div>
                            <div class="checkout_loader hidden" id="form_loader">
                                <div class="overlay new_loader"></div>
                                <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
                            </div>
                        </div>



                    </div>
                </form>
                <!---//...end-->
                <script>
                    //resset password
                    $(document).ready(function () {
                        var user_type = '<?php echo $this->session->userdata['marbel_user']['type']; ?>';
                        var urls = '';
                        if (user_type === 'admin') {
                            urls = 'reset_password_users';
                        }
                        if (user_type === 'customer') {
                            urls = 'reset_password_customer';
                        }
                        var base_url = $('body').find('#base_url').val();

                        // Script for validate and submit remind form by AJAX...
                        var options = {
                            beforeSerialize: function () {
                                // return false to cancel submit 
                                $('body').find('#resetPasswordUserModal #form_loader').removeClass('hidden');
                            },
                            url: base_url + urls,
                            success: function (data) {
                                var err = $.parseJSON(data);
                                if (err.result == false) {
                                    $('body').find('#resetPasswordUserModal #form_loader').addClass('hidden');
                                    $(err.error).each(function (index, value) {
                                        $.each(value, function (index2, msg) {
                                            $("#resetPasswordUserModal #" + index2).text(msg);
                                            $("#resetPasswordUserModal #" + index2).removeClass('hidden');
                                        });
                                    });
                                } else {
                                    $('body').find('#resetPasswordUserModal #form_loader').addClass('hidden');
                                    if (err.success) {

                                        $('body').find('#resetPasswordUserModal input select').each(function () {

                                            $(this).siblings('.text-danger').addClass('hidden');
                                        })
                                        $("#resetPasswordSuccess").text(err.success);
                                        $("#resetPasswordSuccess").removeClass('hidden');


                                        setTimeout(function () {
                                            $('body').find('#resetPasswordUserModal').modal('hide');
                                            //                           window.location.href = '';
                                        }, 1000)
                                    } else {
                                        $('body').find('#resetPasswordUserModal input select').each(function () {
                                            $(this).siblings('.text-danger').addClass('hidden');
                                        })
                                        $("#resetPasswordError").text(err.error);
                                        $("#resetPasswordError").removeClass('hidden');
                                        setTimeout(function () {
                                            $('body').find('#resetPasswordUserModal').modal('hide');
                                        }, 1000)
                                    }
                                }
                            }
                        };
                        $('body').find('#resetPasswordUser-row-form').ajaxForm(options);
                    });
                    // JavaScript Document
                </script>