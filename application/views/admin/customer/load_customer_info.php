<!-- Page Content -->
<div id="page-wrapper">
 <div class="row" >
                    <div class="col-lg-12">
<!--                    <div class="col-lg-6" style="margin-top: 2%;">
                        <a href="<?php echo base_url('customers'); ?>" class="btn btn-sm btn-default">Go Back</a>&nbsp;&nbsp;&nbsp; 
                     </div>   -->
    <?php
    if ($this->session->flashdata('success')) {
        echo '<div class="alert alert-success pull-left message" style="margin-top: 1%;">' . $this->session->flashdata('success') . '</div>';
    }
    ?>
    <?php
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger pull-left message" style="margin-top: 1%;">' . $this->session->flashdata('error') . '</div>';
    }
    ?>
                        <div id="resetPasswordSuccess" class="pull-left alert alert-success hidden message"></div>        
                        <div class="pull-left alert alert-danger hidden message" id="resetPasswordError"></div>
                    </div>
                  
                </div>
    <div class="row">
        <div class="col-lg-12">
            <!--user info page-->
            <div class="user-info">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 user-details">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <?php if (empty($user_info['user_profile_pic'])) { ?>
                                    <img alt="140x140" class="img-circle img-responsive" data-src="holder.js/140x140" style="width: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                <?php } else { ?>
                                    <img alt="140x140" class="img-circle img-responsive" data-src="holder.js/140x140" style="width: 140px; height: 115px; float: left;" src="<?php echo base_url('assets/profile-imgs/' . $user_info['user_profile_pic'] . ''); ?>" data-holder-rendered="true">
                                <?php } ?>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 full-width768-980">
                                <h1><?php echo (!empty($user_info['first_name'])) ? $user_info['first_name'] . " " . $user_info['last_name'] : ""; ?></h1>
                                <p><b>Marbel One Pro</b> w/ firmware 1.9.4
                                    Odometer:<?php echo (!empty($user_rides['odometers']))?$user_rides['odometers']:"00.0";?> miles
                                    # of recent rides: 30</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 full-width768-980">
                                   
                                <div class="round-box first">
                                    <?php echo (!empty($user_rides['trip_distance']))?$user_rides['trip_distance']:"00.0";
                                    ?>
                                    <small>miles</small>
                                </div>
                                <div class="round-box">
                                      <?php echo (!empty($user_rides['trip_duration']))?$user_rides['trip_duration']:"00.0";
                                    ?>
                                    <small>hours</small>
                                </div>
                                <div class="round-box last">
                                    <?php echo  (!empty($user_rides['efficiencys']))?$user_rides['efficiencys']:"0";
                                    ?>%
                                    <small>e-score</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='clearfix'></div>

                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Orders <span class="blue pull-right small-btn">+ Order</span></div>
                        <div class="panel-body">
                            <table width="100%" class="profile-tbl">
                                <?php if (!empty($user_orders)) {
                                    foreach ($user_orders as $user_order) {
                                        ?>

                                        <tr>
                                            <td><a href="<?php echo base_url('edit_order/'.$user_order['id']);?>"><span class="blue">#<?php echo (!empty($user_order['order_number'])) ? $user_order['order_number'] : ""; ?></span></a></td>
                                            <td><?php echo (!empty($user_order['order_date'])) ? date('M j, Y', $user_order['order_date']) : ""; ?></td>
                                            <td><?php echo (!empty($user_order['product'])) ? ucwords($user_order['product']) : ""; ?></td>
                                            <td><?php echo (!empty($user_order['wheel_color'])) ? ucwords($user_order['wheel_color']) : ""; ?></td>
                                            <td><?php echo (!empty($user_order['wheel_size'])) ? $user_order['wheel_size'] : ""; ?></td>
                                            <td>Website</td>
                                            <td align="center"><?php echo (!empty($user_order['order_friendly_status'])) ? $user_order['order_friendly_status'] : ""; ?></td>
                                            <td align="right"><?php echo (!empty($user_order['order_total'])) ? '$' . $user_order['order_total'] : ""; ?></td>
                                        </tr>

    <?php }
} else { ?> 

                                     No Order Found!

<?php } ?>  
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Service Records <span class="blue pull-right small-btn">+ Service</span></div>
                        <div class="panel-body">

                            <table width="100%" class="profile-tbl">

                                <?php 
                                $i=0;
                                if ($user_orders) {
                                    
                                    foreach ($user_orders as $user_order) {
                                       
                                        $services = getServices($user_order['id']);
                                        if (!empty($services)) {
                                            foreach ($services as $service) {
                                                $url='#';
                                                if($service['status']=='finished' || $service['status']=='inhouse'){
                                                    $url=base_url('edit_service/' . $service['id'] . '/in');
                                                }
                                                if($service['status']=='pending'){
                                                     $url=base_url('new_services/'.$service['id'].'/'.$user_info['id']);
                                                }
                                                ?>
                                                <tr>
                                                    <td><a href="<?php echo $url;?>"><span class="blue">#<?php echo (!empty($service['id'])) ? $service['id'] : ""; ?></span></a></td>
                                                    <td align="center"><i><?php echo (!empty($service['status'])) ? ucwords($service['status']) : ""; ?>: <?php echo (!empty($service['date'])) ? date('M j, Y', strtotime($service['date'])) : ""; ?></i></td>
                                                    <td>by: <?php echo (!empty($service['qa_admin_id'])) ? ucwords(getUserName($service['qa_admin_id'])) : "blank"; ?></td>
                                                    <td style="word-wrap:break-word; width: 20%;"><?php echo (!empty($service['diagnostic_response'])) ? $service['diagnostic_response'] : "blank"; ?></td>
                                                    <td align="center"><?php echo (!empty($service['type'])) ? ucwords($service['type']) : ""; ?></td>
                                                  
                                                    <td align="center"><a target="_blank" href="http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&amp;Requester=NES&amp;AgreeToTermsAndConditions=yes&amp;loc=en_US&amp;tracknum=<?php echo $service['tracking_in'];?>"><span class="blue"><?php echo (!empty($service['tracking_in'])) ? $service['tracking_in'] : "blank"; ?></span></a></td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            $i=1;
                                        }
                                    }
                                } else {
                                     $i=1;
                                }
                                if($i==1)
                                    echo "No Services Found!"
                                ?>

                            </table>

                        </div>
                    </div>



                    <div class="panel panel-default">
                        <div class="panel-heading">Tasks <span class="blue pull-right small-btn">+Task Regarding <?php echo (!empty($user_info['first_name'])) ? $user_info['first_name'] : ""; ?></span></div>
                        <div class="panel-body">
                            <table width="100%" class="profile-tbl">

                                <?php if ($regarding_task) {
                                    foreach ($regarding_task as $task) { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('tasks');?>"<span class="blue"><?php echo (!empty($task['task_name'])) ? $task['task_name'] : ""; ?> </span></a></td>
                                           <td ><span> <?php echo (!empty($task['cat_name'])) ? $task['cat_name'] : ""; ?></span></td>
                                            <td width="200" align="center"><?php echo (!empty($task['task_details'])) ? textLimit($task['task_details'],20) : ""; ?>.</td>
                                            <td width="200" align="center"><?php echo (!empty($task['task_status'])) ? $task['task_status'] : ""; ?></td>
                                           <td width="150" align="right"> <?php if(!empty($task['task_due_date']) && $task['task_due_date']!='0000-00-00') {?>Due: <?php echo  date('m/d/Y', strtotime($task['task_due_date'])); ?><?php } ?></td>
                                        </tr>
    <?php }
} else {
    echo '<p>No Task Found!</p>';
} ?>
                            </table> 
                        </div>
                    </div>

                    <div class="panel shadow-none">
                        <div class="panel-heading">Timeline</div>
                        <form method="post" action="<?php echo base_url('add_notes');?>" id="addNotes">
                        <div class="notes">
                            <textarea name="notes" id="notes" placeholder="Leave a note..."></textarea>
                            <input type="hidden" name="created_by" value="<?php echo $this->session->userdata['marbel_user']['user_id'];?>">
                            <input type="hidden" name="created_to" value="<?php echo $user_info['id'];?>">
                            <div class="actions">
                                <button class="btn btn-default">POST</button></div>
                        </div>
                        </form>
                        <p class="notes-msg"><span class="pull-right">Only you and other staff members can see notes</span></p>
                    </div>

                    <div class="col-md-12 form-group">
                        <div class="row">
                            <ul class="comment-list">
                                <?php if($user_notes){
                                    foreach($user_notes as $notes){?>
                                          <li>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <p><?php echo $notes['notes']; ?></p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="text-right date-posted"><?php echo date('M j, Y',  strtotime($notes['created_at'])).' at '.date('H:i A',  strtotime($notes['created_at'])); ?></p>
                                    </div>
                                      <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                          <span class="comment" style="cursor: pointer; color: black;"><i class="fa fa-comment-o"> Comment</i></span>
                                     </div>
                                              <div class="clearfix"></div>
                                              <div class="add-comment-box" data-note="<?php echo $notes['note_id'] ;?>"></div>
                                              <div class="reply-comment-box">
                                                  <p class="text-center comment-count"><span style="color:#ddd"><count class="total-comment"><?php echo $notes['comment_count'];?></count> comment</span></p>
                                                  <div class="reply-comment-box-comment">
                                                <?php  if(!empty($notes['comments'])){ foreach($notes['comments'] as $comments){?> 
                                                  <div class="reply-to-reply">
                                            <ul>
                                                <li>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 border-left">
                                                        <p><small><?php echo $comments['created'];?></small></p>
                                                        <p><?php echo $comments['comment'];?></p>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12 pull-right">
                                                        <p class="text-right date-posted"><?php echo date('M j, Y',  strtotime($comments['created_at'])).' at '.date('H:i A',  strtotime($comments['created_at'])); ?></p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                                <?php }} ?>
                                                  </div>
                                              </div>
                                </li>
                                        
                                   <?php }
                                } else {
                                echo "<span id='not_available'>Note not available!</span>";    
                                }?>
                                

                            </ul>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                   
                </div>
                <div class="col-md-4 right-info-section">

                    <div class="panel panel-default">
                        <div class="panel-heading">Details <a href="<?php echo base_url('edit_customer/'.$user_info['id'])?>"><span class="blue pull-right small-btn">edit</span></a></div>
                        <div class="panel-body">
                            <p>
<a href="mailto:" target="_top"></a>

                                <?php echo (!empty($user_info['email'])) ? '<span class="blue"><a href="mailto:'.$user_info['email'].'" target="_top">'.$user_info['email'].'</a>
</span><br>' : ""; ?>
                               <?php echo (!empty($user_info['email_secondary'])) ? ' <span class="blue"><span class="blue"><a href="mailto:'.$user_info['email_secondary'].'" target="_top">'.$user_info['email_secondary'].'</a></span><br>' : ""; ?>
                                <?php echo (!empty($user_info['phone'])) ? $user_info['phone'].'<br><br>' : ""; ?>

                                <?php
                                if (empty($user_info['country']) && empty($user_info['city']) && empty($user_info['state_or_region'])) {
                                    if (!empty($user_orders)) {
                                        ?>
        <?php echo (!empty($user_orders[0]['delivery_address'])) ? ucwords($user_orders[0]['delivery_address']).'<br>' : ""; ?>
        <?php echo (!empty($user_orders[0]['delivery_address_2'])) ? ucwords($user_orders[0]['delivery_address_2']).'<br>' : ""; ?>
        <?php echo (!empty($user_orders[0]['city'])) ? $user_orders[0]['city'] : ""; ?>, <?php echo (!empty($user_orders[0]['state'])) ? $user_orders[0]['state'] : ""; ?> <?php echo (!empty($user_orders[0]['zip'])) ? $user_orders[0]['zip'].'<br>' : ""; ?>
        <?php echo (!empty($user_orders[0]['country'])) ? ucwords($user_orders[0]['country']) : ""; ?>
    <?php } else {
        echo "";
    }
} else { ?>

    <?php echo (!empty($user_info['address_one'])) ? ucwords($user_info['address_one']).'<br>' : ""; ?>
    <?php echo (!empty($user_info['address_one'])) ? ucwords($user_info['address_one']).'<br>' : ""; ?>
    <?php echo (!empty($user_info['city'])) ? $user_info['city'] : ""; ?>, <?php echo (!empty($user_info['state_or_region'])) ? $user_info['state_or_region'] : ""; ?> <?php echo (!empty($user_info['postal_code'])) ? $user_info['postal_code'].'<br>' : ""; ?>
    <?php echo (!empty($user_info['country'])) ? ucwords($user_info['country']).'<br><br>' : ""; ?>
    <?php } ?>
                                    

                                   <?php if(!empty($user_info['company'])){?> Company:  <?php echo  ucwords($user_info['company']).'<br><br>'; }?>

                                <div style="font-style:italic">  
                                    <?php if(!empty($user_info['company'])) { ?>AKA: <span class="blue"><?php echo  ucwords($user_info['company']) ; ?></span><br><?php } ?>
                                   <?php if(!empty($user_info['twitter_handle'])) { ?> Twitter: <span class="blue"><?php echo (!empty($user_info['twitter_handle'])) ? ucwords($user_info['twitter_handle']) : ""; ?></span><br><?php } ?>
                                    <?php if(!empty($user_info['linkedin_handle'])) { ?> Instagram: <span class="blue"><?php echo (!empty($user_info['linkedin_handle'])) ? ucwords($user_info['linkedin_handle']) : ""; ?></span><br><?php } ?>
                                    <?php if(!empty($user_info['instagram_handle'])) { ?>LinkedIn: <span class="blue"><?php echo (!empty($user_info['instagram_handle'])) ? ucwords($user_info['instagram_handle']) : ""; ?></span><br><?php } ?>
                                   <?php if(!empty($user_info['reddit_handle'])) { ?> Reddit: <span class="blue"><?php echo (!empty($user_info['reddit_handle'])) ? ucwords($user_info['reddit_handle']) : ""; ?></span><br><br><br><?php } ?>
                                    
                                </div>

                                Last Login:  <?php echo (!empty($user_info['last_activity'])) ? date('M j, Y  H:i a', $user_info['last_activity']) : ""; ?><br>
                                # of Recent Logins:  8
                                </p>

                                <?php if(!empty($user_info['comments'])){ ?><div class="panel-heading" style="border-bottom:solid 1px #ddd;margin: 15px 0;padding:0">Comments</div>
                                <p><?php echo (!empty($user_info['comments'])) ? $user_info['comments'] : ""; ?></p><?php } ?>
                            </div>
                        </div>


                        <div class="panel panel-default">
                            <div class="panel-heading">Ride Settings</div>
                            <div class="panel-body rides">
                                <?php echo (!empty($user_info['units'])) ? '</b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['units'].'</span></p>' : ""; ?>
                                <?php echo (!empty($user_info['notifications'])) ? '<p><b>Notifications Rides: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['notifications'].'</span></p>' : ""; ?>
                                <?php echo (!empty($user_info['safety_brake'])) ? '<p><b>Safety Brake: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['safety_brake'].'</span></p>' : ""; ?>
                                <?php echo (!empty($user_info['reverse_turned'])) ? '<p><b>Reverse Turned: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['reverse_turned'].'</span></p>': ""; ?>
                                <?php echo (!empty($user_info['locked_settings'])) ?'<p><b>Lock: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['locked_settings'].'</span></p>' : ""; ?>
                                <?php echo (!empty($user_info['privacy_setting'])) ? '<p><b>Privacy Settings: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['privacy_setting'].'</span></p>': ""; ?>
                                <?php echo (!empty($user_info['range_alarm'])) ? '<p><b>Range Alarm: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['range_alarm'].'%</span></p>' : ""; ?>
                               <?php echo (!empty($user_info['primary_riding_style'])) ? ' <p><b>Primary Riding Style: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['primary_riding_style'].'</span></p>' : ""; ?>
                               <?php echo (!empty($user_info['preferred_braking_force'])) ? ' <p><b>Preffered Breaking Force: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['preferred_braking_force'].'%</span></p>': ""; ?>
                                <?php echo (!empty($user_info['terrain'])) ? '<p><b>Terrain: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['terrain'].'</span></p>': ""; ?>
                                <?php echo (!empty($user_info['parental_lock'])) ? '<p><b>Parental Lock: </b> <span class="btn btn-primary btn-blue btn-xs">'.$user_info['parental_lock'].'</span></p>' : ""; ?>
                            </div>
                        </div>
<!--                    <a data-target="#resetPasswordModal" data-toggle="modal" class="btn btn-custom btn-lg">Reset Password</a>-->
                    </div>
                 
                </div>
                <!--/.user info page-->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->
    <!--Reset password model-->
    <form id="resetPassword-row-form" action="" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Reset Password <span class="label label-info"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="col-md-12 form-group text-center">
                                <a href="<?php echo base_url('send_password_email_profile/' . $user_info['id']); ?>" class="btn btn-custom btn-sm">Send Reset Password Email</a>
                            </div>

                        </div>
                        <h1 class="text-center">OR</h1>
                        <div class="col-md-12">
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
                        <input type="hidden" name="id" value="<?php echo $user_info['id']; ?>">
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
<!--comment box-->
<div class="hidden comment-box">
<div class="panel shadow-none">
                       
                        
    <div class="notes" style="color: black;">
                            <textarea name="comment" class="comment-val" placeholder="Leave a comment..."></textarea>
                            <div class="actions">
                                <button class="btn btn-default addComments" >POST</button>
                            </div>
                        </div>
                      
                        <p class="notes-msg"><span class="pull-right">Only you and other staff members can see comment</span></p>
                    </div>
                    </div>
<!--//end...-->
<script>
    //resset password
    $(document).ready(function () {

        var base_url = $('body').find('#base_url').val();

        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#resetPasswordModal #form_loader').removeClass('hidden');
            },
            url: base_url + 'reset_password_users',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#resetPasswordModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#resetPasswordModal #" + index2).text(msg);
                            $("#resetPasswordModal #" + index2).removeClass('hidden');
                        });
                    });
                } else {
                    $('body').find('#resetPasswordModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#resetPasswordModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#resetPasswordSuccess").text(err.success);
                        $("#resetPasswordSuccess").removeClass('hidden');


                        setTimeout(function () {
                            $('body').find('#resetPasswordModal').modal('hide');
//                           window.location.href = '';
                        }, 500)
                    } else {
                        $('body').find('#resetPasswordModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#resetPasswordError").text(err.error);
                        $("#resetPasswordError").removeClass('hidden');
                        setTimeout(function () {
                            $('body').find('#resetPasswordModal').modal('hide');
                        }, 500)
                    }
                }
            }
        };
        $('body').find('#resetPassword-row-form').ajaxForm(options);
        
        
  //add note ajax call   
   var $formMyacct = $('#addNotes');
   $("#notes").keypress(function(event) {
   if (event.which == 13) {
       event.preventDefault();
       $formMyacct.submit();
   }
});
   $formMyacct.submit(function (ev) {
       ev.preventDefault();
       $('body').find('#invite_loader').removeClass('hidden');
       var notes=$('#notes').val();
       if($.trim(notes)!=''){
            $('#notes').css('border','none');
       $.ajax({
           type: 'POST',
           url: $formMyacct.attr('action'),
           data: $formMyacct.serialize(),
           success: function (res) {
              $('#not_available').remove();
              $('.comment-list').prepend(res);
              $('#notes').val('');
           }, complete: function () {
               $('body').find('#invite_loader').addClass('hidden');
           }
       });
   }else{
       
         $('#notes').css('border','1px solid red');
   }
   });
   
   //show comment box on comment button click
    $('body').on('click','.comment',function(){
      $(this).parents('li').find('.add-comment-box').html($('body').find('.comment-box').html());
   });
   
   //add comment according note ajax
     $('body').on('keypress','.comment-val',function(event){
   if (event.which == 13) {
      $('body').find('.addComments').trigger('click');
   }
});


   $('body').on('click','.addComments',function(){
       var objCmt = $(this);
       $('body').find('#invite_loader').removeClass('hidden');
       var comment = objCmt.parents('.notes').find('.comment-val').val();
       var note_id = objCmt.parents('.add-comment-box').attr('data-note');
       if($.trim(comment)!=''){
            objCmt.parents('.notes').find('.comment-val').css('border','none');
       $.ajax({
           type: 'POST',
           url: '<?php echo base_url('add_comments')?>',
           data: {'comment':comment,'note_id':note_id},
           success: function (res) {
             //  total-comment
               objCmt.parents('.add-comment-box').siblings('.reply-comment-box').find('.total-comment').text(parseInt(objCmt.parents('.add-comment-box').siblings('.reply-comment-box').find('.total-comment').text())+1);
               objCmt.parents('.add-comment-box').siblings('.reply-comment-box').find('.reply-comment-box-comment').prepend(res);
               objCmt.parents('.add-comment-box').html('');  
           }, complete: function () {
               $('body').find('#invite_loader').addClass('hidden');
           }
       });
       }else{
       objCmt.parents('.notes').find('.comment-val').css('border','1px solid red');
       
       }
       
   });

    });
    // JavaScript Document
</script>