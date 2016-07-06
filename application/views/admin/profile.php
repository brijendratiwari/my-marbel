<!-- Page Content -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <div id="userSuccess" class="pull-left alert alert-success hidden message"></div>        
                <div class="pull-left alert alert-danger hidden message" id="userError"></div>
            </div>   
            <div class="col-lg-6 page-header text-right"><button data-target="#usersModal" data-toggle="modal" class="btn btn-custom">Edit Profile</button></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Profile Information</h1>


            <!--user info page-->
            <div class="col-md-offset-1 user-info">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <?php if (empty($user_info['user_profile_pic'])) { ?>
                            <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                        <?php } else { ?>
                            <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="<?php echo base_url('assets/profile-imgs/' . $user_info['user_profile_pic'] . ''); ?>" data-holder-rendered="true">
                        <?php } ?>
                    </div>
                    <div class='clearfix'></div>
                    <div class="col-md-12 text-left">
                        <h3><?php echo (!empty($user_info['first_name'])) ? $user_info['first_name'] . " " . $user_info['last_name'] : "Empty"; ?></h3></div>

                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Orders</div>
                        <div class="panel-body">

                            <?php if ($user_orders) {
                                foreach ($user_orders as $user_order) { ?>
                                    <p>Order Date: <?php echo (!empty($user_order['order_date'])) ? date('M j, Y', $user_order['order_date']) : ""; ?></p>
                                    <p>Order Number: <?php echo (!empty($user_order['order_number'])) ? $user_order['order_number'] : ""; ?></p>
                                    <p>Product: <?php echo (!empty($user_order['product'])) ? $user_order['product'] : ""; ?></p>
                                    <p>Status: <?php echo (!empty($user_order['order_friendly_status'])) ? $user_order['order_friendly_status'] : ""; ?></p>
                                    <p>Total: <?php echo (!empty($user_order['order_total'])) ? '$' . $user_order['order_total'] : ""; ?></p>
                                    <hr>
    <?php }
} else {
    echo '<p>No Order Found!</p>';
} ?>

                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Service</div>
                        <div class="panel-body">
<?php
if ($user_orders) {
    foreach ($user_orders as $user_order) {
        $services = getServices($user_order['id']);
        if (!empty($services)) {
            foreach ($services as $service) {
                ?>

                                            <p>Date: <?php echo (!empty($service['date'])) ? date('M j, Y', strtotime($service['date'])) : ""; ?></p>
                                            <p>Status: <?php echo (!empty($service['status'])) ? ucwords($service['status']) : ""; ?></p>
                                            <p>Type: <?php echo (!empty($service['type'])) ? ucwords($service['type']) : ""; ?></p>
                                            <p>Issue: <?php echo (!empty($service['issue'])) ? $service['issue'] : ""; ?></p>
                                            <p>Diagnostic Response: <?php echo (!empty($service['diagnostic_response'])) ? $service['diagnostic_response'] : ""; ?></p>
                                            <p>Included Parts: <?php echo (!empty($service['included_parts'])) ? $service['included_parts'] : ""; ?></p>
                                            <p>Notes: <?php echo (!empty($service['notes'])) ? $service['notes'] : ""; ?></p>
                                            <hr>
                                        <?php
                                        }
                                    } else {
                                        echo "<p>No Services Found!</p>";
                                    }
                                    ?>

    <?php
    }
} else {
    echo "<p>No Services Found!</p>";
}
?>
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
<?php echo (!empty($user_info['notes'])) ? $user_info['notes'] : "Empty"; ?>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 right-info-section">

                    <div class="panel panel-default">
                        <div class="panel-heading">Active</div>
                        <div class="panel-body">
                            <p>Phone: <?php echo (!empty($user_info['notes'])) ? $user_info['phone'] : "Empty"; ?></p>
                            <p>Email: <?php echo (!empty($user_info['email'])) ? $user_info['email'] : "Empty"; ?></p>
                            <p>Email2: <?php echo (!empty($user_info['email_secondary'])) ? $user_info['email_secondary'] : "Empty"; ?></p>
                            <p>Accept marketing: <?php echo (!empty($user_info['accepts'])) ? ucwords($user_info['accepts']) : "Empty"; ?></p>
                        </div>
                    </div>


                    <div class="aka">
                        A.K.A.
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">Deafult Address</div>
                        <div class="panel-body">
<?php echo (!empty($user_info['address_one'])) ? $user_info['address_one'] : "Empty"; ?>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Last Login</div>
                        <div class="panel-body">
<?php echo (!empty($user_info['last_activity'])) ? date('M j, Y', $user_info['last_activity']) : "Empty"; ?>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Support Requests</div>
                        <div class="panel-body">
                            Empty
                        </div>
                    </div>

                    <div class="aka">
                        <div class="social">TWITTER:  <?php echo (!empty($user_info['twitter_handle'])) ? $user_info['twitter_handle'] : "Empty"; ?></div>
                        <div class="social">LINKED IN:  <?php echo (!empty($user_info['linkedin_handle'])) ? $user_info['linkedin_handle'] : "Empty"; ?></div>
                    </div>


                </div>
            </div>
            <!--/.user info page-->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->


<!--user modal ..-->

<form id="add-row-form" action="" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input type="text" name="cd-first" class="form-control" placeholder="First Name" value="<?php echo (!empty($user_info['first_name'])) ? $user_info['first_name'] : ""; ?>">
                                <span id="cd-first" class="text-danger hidden"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input type="text" name="cd-last" class="form-control" placeholder="Last Name" value="<?php echo (!empty($user_info['last_name'])) ? $user_info['last_name'] : ""; ?>">
                                <span id="cd-last" class="text-danger hidden"></span>
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input type="text" name="cd-email" class="form-control" placeholder="Email" value="<?php echo (!empty($user_info['email'])) ? $user_info['email'] : ""; ?>">
                                <span id="cd-email" class="text-danger hidden"></span>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input class="form-control" type="text" placeholder="Phone Number" name="cd-phone" id="cd-phone" value="<?php echo (!empty($user_info['phone'])) ? $user_info['phone'] : ""; ?>">
                                <span id="cd-phone" class="text-danger hidden"></span>
                            </div>
                    </div>


                    <!--add some more addition field-->

                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Weight</label>
                                <input type="text" name="cd-weight" class="form-control" placeholder="Weight" value="<?php echo (!empty($user_info['weight'])) ? $user_info['weight'] : ""; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Height</label>
                                <input type="text" name="cd-height" class="form-control" placeholder="Height" value="<?php echo (!empty($user_info['height'])) ? $user_info['height'] : ""; ?>">
                            </div>

                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Company</label>
                                <input type="text" name="cd-company" class="form-control" placeholder="Company" value="<?php echo (!empty($user_info['company'])) ? $user_info['company'] : ""; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address One</label>
                                <input type="text" name="cd-address-one" class="form-control" placeholder="Address one" value="<?php echo (!empty($user_info['address_one'])) ? $user_info['address_one'] : ""; ?>">
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Address Two</label>
                                <input type="text" name="cd-address-two" class="form-control" placeholder="Address Two" value="<?php echo (!empty($user_info['address_two'])) ? $user_info['address_two'] : ""; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input type="text" name="cd-city" class="form-control" placeholder="City" value="<?php echo (!empty($user_info['city'])) ? $user_info['city'] : ""; ?>">
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>State/Region</label>
                                <input type="text" name="cd-state-region" class="form-control" placeholder="State/Region" value="<?php echo (!empty($user_info['state_or_region'])) ? $user_info['state_or_region'] : ""; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Postal Code</label>
                                <input type="text" name="cd-postal-code" class="form-control" placeholder="Postal Code" value="<?php echo (!empty($user_info['postal_code'])) ? $user_info['postal_code'] : ""; ?>">
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <input type="text" name="cd-country" class="form-control" placeholder="Country" value="<?php echo (!empty($user_info['country'])) ? $user_info['country'] : ""; ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Accepts Marketing</label>
                                <select id="cd-accepts-marketing" name="cd-accepts-marketing" class="form-control" value="<?php echo (!empty($user_info['address_one'])) ? $user_info['address_one'] : ""; ?>">
                                    <option value="">Accepts Marketing</option>
                                    <option value="Yes" <?php if (strcmp($user_info['accepts'], 'Yes') == 0) {
    echo "selected='selected'";
} ?>>Yes</option>
                                    <option value="No" <?php if (strcmp($user_info['accepts'], 'No') == 0) {
    echo "selected='selected'";
} ?>>No</option>
                                </select>
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Bio</label>
                                <input type="text" name="cd-bio" class="form-control" placeholder="Bio" value="<?php echo (!empty($user_info['bio'])) ? $user_info['bio'] : ""; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Privacy Setting</label>
                                <select id="cd-privacy-setting" name="cd-privacy-setting" class="form-control">
                                    <option value="">Privacy Setting</option>
                                    <option value="ON" <?php if (strcmp($user_info['privacy_setting'], 'ON') == 0) {
    echo "selected='selected'";
} ?>>ON</option>
                                    <option value="OFF" <?php if (strcmp($user_info['privacy_setting'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Units</label>
                                <select id="cd-units" name="cd-units" class="form-control">
                                    <option value="">Units</option>
                                    <option value="metric" <?php if (strcmp($user_info['units'], 'metric') == 0) {
    echo "selected='selected'";
} ?>>Metric</option>
                                    <option value="english" <?php if (strcmp($user_info['units'], 'english') == 0) {
    echo "selected='selected'";
} ?>>English</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Range Alarm</label>
                                <select id="cd-rangealarm" name="cd-rangealarm" class="form-control">
                                    <option value="">Range Alarm</option>
                                    <option value="10" <?php if (strcmp($user_info['range_alarm'], '10') == 0) {
    echo "selected='selected'";
} ?>>10%</option>
                                    <option value="25" <?php if (strcmp($user_info['range_alarm'], '25') == 0) {
    echo "selected='selected'";
} ?>>25%</option>
                                    <option value="25" <?php if (strcmp($user_info['range_alarm'], '50') == 0) {
    echo "selected='selected'";
} ?>>50%</option>
                                    <option value="OFF" <?php if (strcmp($user_info['range_alarm'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Notifications Rides</label>
                                <select id="cd-notifications-rides" name="cd-notifications-rides" class="form-control">
                                    <option value="">Notifications Rides</option>
                                    <option value="ON" <?php if (strcmp($user_info['notifications'], 'ON') == 0) {
    echo "selected='selected'";
} ?>>ON</option>
                                    <option value="OFF" <?php if (strcmp($user_info['notifications'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Primary Riding Style</label>
                                <select id="cd-primary-riding-style" name="cd-primary-riding-style" class="form-control">
                                    <option value=""> Select Primary Riding Style</option>
                                    <option value="Commute To Work" <?php if (strcmp($user_info['primary_riding_style'], 'Commute To Work') == 0) {
    echo "selected='selected'";
} ?>>Commute To Work</option>
                                    <option value="Get Places In The City" <?php if (strcmp($user_info['primary_riding_style'], 'Get Places In The City') == 0) {
    echo "selected='selected'";
} ?>>Get Places In The City</option>
                                    <option value="Just For Fun" <?php if (strcmp($user_info['primary_riding_style'], 'Just For Fun') == 0) {
    echo "selected='selected'";
} ?>>Just For Fun</option>
                                    <option value="Get Around Campus" <?php if (strcmp($user_info['primary_riding_style'], 'Get Around Campus') == 0) {
    echo "selected='selected'";
} ?>>Get Around Campus</option>
                                </select>
                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Safety Brake</label>
                                <select id="cd-safety-brake" name="cd-safety-brake" class="form-control">
                                    <option value="">Safety Brake</option>
                                    <option value="ON" <?php if (strcmp($user_info['safety_brake'], 'ON') == 0) {
    echo "selected='selected'";
} ?>>ON</option>
                                    <option value="OFF" <?php if (strcmp($user_info['safety_brake'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Preferred Braking Force</label>
                                <select id="cd-preferred-braking-force" name="cd-preferred-braking-force" class="form-control">
                                    <option value="">Select Preferred Braking Force</option>
                                    <option value="25" <?php if (strcmp($user_info['preferred_braking_force'], '25') == 0) {
    echo "selected='selected'";
} ?>>25%</option>
                                    <option value="50" <?php if (strcmp($user_info['preferred_braking_force'], '50') == 0) {
    echo "selected='selected'";
} ?>>50%</option>
                                    <option value="75" <?php if (strcmp($user_info['preferred_braking_force'], '75') == 0) {
    echo "selected='selected'";
} ?>>75%</option>
                                    <option value="100" <?php if (strcmp($user_info['preferred_braking_force'], '100') == 0) {
    echo "selected='selected'";
} ?>>100%</option>
                                </select>

                            </div>
                    </div>
                    <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label>Reverse Turned</label>
                                <select id="cd-reverse-turned" name="cd-reverse-turned" class="form-control">
                                    <option value="">Reverse Turned</option>
                                    <option value="ON" <?php if (strcmp($user_info['reverse_turned'], 'ON') == 0) {
    echo "selected='selected'";
} ?>>ON</option>
                                    <option value="OFF" <?php if (strcmp($user_info['reverse_turned'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Lock</label>
                                <select id="cd-locked-settings" name="cd-locked-settings" class="form-control">
                                    <option value="">Select Locked Settings</option>
                                    <option value="ON" <?php if (strcmp($user_info['locked_settings'], 'ON') == 0) {
    echo "selected='selected'";
} ?>>ON</option>
                                    <option value="OFF" <?php if (strcmp($user_info['locked_settings'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>

                            </div>
                    </div>

                    <div class="col-md-12">
                          <div class="col-md-6 form-group">
                                <label>Parental Lock</label>
                                <select id="cd-parental-lock" name="cd-parental-lock" class="form-control">
                                    <option value="">Select Parental Lock</option>
                                    <option value="ON" <?php if (strcmp($user_info['parental_lock'], 'ON') == 0) {
    echo "selected='selected'";
} ?>>ON</option>
                                    <option value="OFF" <?php if (strcmp($user_info['parental_lock'], 'OFF') == 0) {
    echo "selected='selected'";
} ?>>OFF</option>
                                </select>

                            </div>
                            <div class="col-md-6 form-group">
                                <label>Terrain</label>
                                 <select id="cd-terrain" name="cd-terrain" class="form-control">
                                    <option value="">Select Terrain</option>
                                    <option value="Hills" <?php if (strcmp($user_info['terrain'], 'Hills') == 0) {
    echo "selected='selected'";
} ?>>Hills</option>
                                    <option value="Flat" <?php if (strcmp($user_info['terrain'], 'Flat') == 0) {
    echo "selected='selected'";
} ?>>Flat</option>
                                </select>
                              
                            </div>


                           
                    </div>
                    <div class="col-md-12">
                          <div class="col-md-6 form-group">
                                <label>Note of order</label>
                                <textarea name="cd-notes-order" class="form-control" placeholder="Write here note of order....." style="max-height: 90px; height: 90px;"><?php echo (!empty($user_info['note_orders'])) ? $user_info['note_orders'] : ""; ?></textarea>

                            </div>
                            <div class="col-md-6 form-group">
                                <label>Note of services</label>
                                <textarea name="cd-note-services" class="form-control" placeholder="Write here note of services....." style="max-height: 90px; height: 90px;"><?php echo (!empty($user_info['note_services'])) ? $user_info['note_services'] : ""; ?></textarea>
                              
                            </div>


                           
                    </div>
                    <div class="col-md-12">
                          <div class="col-md-6 form-group">
                                <label>Note of tasks regarding</label>
                                <textarea name="cd-note-task" class="form-control" placeholder="Write here note of tasks regarding....." style="max-height: 90px; height: 90px;"><?php echo (!empty($user_info['note_tasks'])) ? $user_info['note_tasks'] : ""; ?></textarea>

                            </div>
                            <div class="col-md-6 form-group">
                                <label>Note of open support tickets</label>
                                <textarea name="cd-support-ticket" class="form-control" placeholder="Write here note of open support tickets" style="max-height: 90px; height: 90px;"><?php echo (!empty($user_info['note_support_ticket'])) ? $user_info['note_support_ticket'] : ""; ?></textarea>
                              
                            </div>


                           
                    </div>
                    <div class="col-md-12">
                           

                         <div class="col-md-6 form-group">
                                <label>Profile Image</label>
                                <input type="file" name="cd-profile" >
                            </div>


                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="add-row" class="btn btn-success">Update</button>
                </div>
            </div>
            <div class="checkout_loader hidden" id="form_loader">
                <div class="overlay new_loader"></div>
                <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
            </div>
        </div>



    </div>
</form>

<!-- // user modal ..-->

<script>
    $(document).ready(function () {

        var base_url = $('body').find('#base_url').val();

        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#usersModal #form_loader').removeClass('hidden');
            },
            url: base_url + 'edit_profile',
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
                            window.location.href = '';
                        }, 1000)
                    } else {
                        $('body').find('#usersModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#userError").text(err.error);
                        $("#userError").removeClass('hidden');
                        setTimeout(function () {
                            $('body').find('#usersModal').modal('hide');
                        }, 1000)
                    }
                }
            }
        };
        $('body').find('#add-row-form').ajaxForm(options);
    });
</script>