<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="col-lg-6">

                    <div class="pull-left alert alert-success message"><?php echo $this->session->flashdata('success'); ?></div>
                </div> 
            <?php } ?>
            <div class="col-lg-6">

                <div id="userSuccess" class="pull-left alert alert-success hidden message"></div>
            </div>   

            <div  class="col-lg-6 page-header text-right"><button class="btn btn-custom" data-toggle="modal" data-target="#usersModal">Add New User</button></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="customer-data" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>View Profile</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Last Activity</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->

</div>



<!--Customer modal ..-->

<form id="add-row-form" action="<?php echo base_url('add_customer') ?>" method="POST">
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New User</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <input type="text" name="cd-first" class="form-control" placeholder="First Name">
                        <span id="cd-first" class="text-danger hidden"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <input type="text" name="cd-last" class="form-control" placeholder="Last Name">
                        <span id="cd-last" class="text-danger hidden"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="text" name="cd-email" class="form-control" placeholder="Email">
                        <span id="cd-email" class="text-danger hidden"></span>
                    </div>
                    <!--                <div class="col-md-6 form-group">
                                      <input type="password" name="cd-password" class="form-control" placeholder="Password">
                                      <span id="cd-password" class="text-danger hidden"></span>
                                    </div>-->
                    <div class="col-md-6 form-group">
                        <label>Parent Type</label>
                        <select id="cd-type" name="cd-type" class="form-control">
                            <?php
                            if (!empty($user_type)) {
                                foreach ($user_type as $userTypeName) {
                                    if ($userTypeName['parent'] == 0) {
                                        ?>

                                        <option value="<?php echo $userTypeName['id']; ?>"><?php echo $userTypeName['user_role_type']; ?></option>



                                    <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Phone</label>
                        <input class="form-control" type="text" placeholder="Phone Number" name="cd-phone" id="cd-phone" <?php if (isset($error) && $error > 0) {
                                echo 'value="' . $phone . '"';
                            } ?>>
                        <span id="cd-phone" class="text-danger hidden"></span>
                    </div>


                    <div class="col-md-6 form-group" id="typeparent">
                        <label>Type</label>
                        <select id="cd-type-parent" name="cd-type-parent" class="form-control">

                        </select>
                    </div>
                    <!--add some more addition field-->
                    <div class="col-md-6 form-group">
                        <label>Email Secondary</label>
                        <input type="text" name="cd-email-second" class="form-control" placeholder="Email Secondary" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Bio</label>
                        <input type="text" name="cd-bio" class="form-control" placeholder="Bio" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Weight</label>
                        <input type="text" name="cd-weight" class="form-control" placeholder="Weight" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Height</label>
                        <input type="text" name="cd-height" class="form-control" placeholder="Height">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Company</label>
                        <input type="text" name="cd-company" class="form-control" placeholder="Company" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address One</label>
                        <input type="text" name="cd-address-one" class="form-control" placeholder="Address one" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Two</label>
                        <input type="text" name="cd-address-two" class="form-control" placeholder="Address Two" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input type="text" name="cd-city" class="form-control" placeholder="City" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State/Region</label>
                        <input type="text" name="cd-state-region" class="form-control" placeholder="State/Region" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Postal Code</label>
                        <input type="text" name="cd-postal-code" class="form-control" placeholder="Postal Code" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <input type="text" name="cd-country" class="form-control" placeholder="Country" >
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Alias</label>
                        <input type="text" name="cd-alias" class="form-control" placeholder="Alias" >
                    </div>


                    <div class="col-md-6 form-group">
                        <label>Twitter Handle</label>
                        <input type="text" name="cd-twitter-handle" class="form-control" placeholder="Twitter Handle">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Linkedin Handle</label>
                        <input type="text" name="cd-linkedin-handle" class="form-control" placeholder="Linkedin Handle">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Instagram Handle</label>
                        <input type="text" name="cd-instagram-handle" class="form-control" placeholder="Instagram Handle">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Reddit Handle</label>
                        <input type="text" name="cd-reddit-handle" class="form-control" placeholder="Reddit Handle">
                    </div>
                    <!--end here new changes-->

                    <!--                <div class="col-md-12 form-group"> 
                                        <label>Note of order</label>
                                      <textarea name="cd-notes-order" class="form-control" placeholder="Write here note of order....." style="max-height: 90px; height: 90px;"></textarea>
                                    </div>
                                   <div class="col-md-12 form-group"> 
                                       <label>Note of services</label>
                                      <textarea name="cd-note-services" class="form-control" placeholder="Write here note of services....." style="max-height: 90px; height: 90px;"></textarea>
                                    </div>
                                   <div class="col-md-12 form-group"> 
                                        <label>Note of tasks regarding</label>
                                      <textarea name="cd-note-task" class="form-control" placeholder="Write here note of tasks regarding....." style="max-height: 90px; height: 90px;"></textarea>
                                    </div>
                                   <div class="col-md-12 form-group"> 
                                        <label>Note of open support tickets</label>
                                      <textarea name="cd-support-ticket" class="form-control" placeholder="Write here note of open support tickets" style="max-height: 90px; height: 90px;"></textarea>
                                    </div>  -->
                    <div class="col-md-12 form-group"> 
                        <label>Comments</label>
                        <textarea name="cd-comments" class="form-control" placeholder="Write here comments" style="max-height: 90px; height: 90px;"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="add-row" class="btn btn-success">Add</button>
                </div>
            </div>
            <div class="checkout_loader hidden" id="form_loader">
                <div class="overlay new_loader"></div>
                <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
            </div>
        </div>



    </div>
</form>

<!-- // Customer modal ..-->

<div class="modal fade" id="usersProfileModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
    <div class="modal-dialog user-profile">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">User Information</h4>
            </div>
            <div class="modal-body profile-html">



            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <div class="checkout_loader hidden" id="form_loader">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
    </div>



</div>


<script>

    $(document).ready(function () {

        var base_url = $('body').find('#base_url').val();

        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#usersModal #form_loader').removeClass('hidden');
            },
            url: base_url + 'add_customer',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#usersModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#usersModal #" + index2).text(msg);
                            $("#usersModal #" + index2).removeClass('hidden');
                        });
                    });
                } else {
                    $('body').find('#usersModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#usersModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#userSuccess").text(err.success);
                        $("#userSuccess").removeClass('hidden');

                        setTimeout(function () {
                            $('body').find('#usersModal').modal('hide');
                        }, 1000)
                    } else {
                        $('body').find('#usersModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        setTimeout(function () {
                            $('body').find('#usersModal').modal('hide');
                        }, 1000)
                    }
                }
            }
        };
        $('body').find('#add-row-form').ajaxForm(options);



        /* get child level */
        $('#typeparent').hide();
        $("#cd-type").change(function () {
            var id = $(this).val();

            var dataString = 'id=' + id;

            $.ajax
                    ({
                        type: "POST",
                        url: base_url + "get_child_user_level",
                        data: dataString,
                        cache: false,
                        success: function (html)
                        {
                            var $select = $('#cd-type-parent');
                            if (html != '') {

                                $('#typeparent').show();
                                $select.find('option').remove();
                                var jo = $.parseJSON(html);

                                $.each(jo, function (i, val) {

                                    $select.append('<option value=' + val.id + '>' + val.user_role_type + '</option>');

                                });

                            } else {

                                $('#typeparent').hide();
                            }
                        }
                    });

        });


        $('body').on('click', '.userRow', function () {

            var user_id = $(this).attr('data-id');

            $('body').find('.profile-html').load("<?php echo base_url('get_customer_info'); ?>/" + user_id + "");
        })
    })

    function deleteCustomer(id) {

        if (confirm('Are you sure you want to delete?'))
        {
            window.location.href = "<?php echo base_url() ?>deleteCustomer/" + id;
        }

    }



</script>
<style>
    .user-profile{
        width:80% !important;
    }
    .profile-html > #page-wrapper{
        margin: 0 !important;
    }
</style>