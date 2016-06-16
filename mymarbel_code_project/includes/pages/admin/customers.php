<?php
if (isset($_POST['cd-first'], $_POST['cd-last'], $_POST['cd-email'], $_POST['cd-password'], $_POST['cd-type'], $_POST['cd-phone'], $_POST['cd-notes'])) {
  $email = $_POST['cd-email'];
  $first_name = $_POST['cd-first'];
  $last_name = $_POST['cd-last'];
  $password = $_POST['cd-password'];
 
  if($_POST['cd-type-parent']!=''){
        $type = $_POST['cd-type-parent'];
        $parent_type = $_POST['cd-type'];
  }else{
       $type = $_POST['cd-type'];
       $parent_type = $_POST['cd-type'];
  }
  $phone = $_POST['cd-phone'];
  //assign value for new input fields
   $email_second = $_POST['cd-email-second'];
   $bio = $_POST['cd-bio'];
   $height = $_POST['cd-height'];
   $weight = $_POST['cd-weight'];
   $company = $_POST['cd-company'];
   $address_one = $_POST['cd-address-one'];
   $address_two = $_POST['cd-address-two'];
   $city = $_POST['cd-city'];
   $state_region = $_POST['cd-state-region'];
   $postal_code = $_POST['cd-postal-code'];
   $country = $_POST['cd-country'];
   $accepts_marketing = $_POST['cd-accepts-marketing'];
   $alias = $_POST['cd-alias'];
   $privacy_setting= $_POST['cd-privacy-setting'];
   $units = $_POST['cd-units'];
   $rangealarm = $_POST['cd-rangealarm'];
   $notifications_rides = $_POST['cd-notifications-rides'];
   $primary_riding_style = $_POST['cd-primary-riding-style'];
   $safety_brake = $_POST['cd-safety-brake'];
   $preferred_braking_force = $_POST['cd-preferred-braking-force'];
   $reverse_turned = $_POST['cd-reverse-turned'];
   $locked_settings = $_POST['cd-locked-settings'];
    $terrain = $_POST['cd-terrain'];
    $twitter_handle = $_POST['cd-twitter-handle'];
   $linkedin_handle = $_POST['cd-linkedin-handle'];
   $instagram_handle = $_POST['cd-instagram-handle'];
    $reddit_handle = $_POST['cd-reddit-handle'];
   //end here
   $notes = $_POST['cd-notes'];

  $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
  $password = hash('sha512', $password . $random_salt);
  $error = insertUser($email, $first_name, $last_name, $type,$parent_type, $phone, $notes,$email_second,$bio,$height,$weight,$terrain,$company,$address_one,$address_two,$city,$state_region,$postal_code,$country,$accepts_marketing,$alias,$privacy_setting,$units,$rangealarm,$notifications_rides,$primary_riding_style,$safety_brake,$preferred_braking_force,$reverse_turned,$locked_settings,$twitter_handle,$linkedin_handle,$instagram_handle,$reddit_handle, $password, $random_salt, $db);
}
?>
<section id="main-content">
  <section class="wrapper" style="padding-top:20px;">
    <?php 
    if (isset($error)) {
      if ($error == 0) {
        echo '<div id="error" class="alert alert-success"><p>'.$first_name.' '.$last_name.' was added successfully</p></div>';
      } else if ($error == 1) {
        echo '<div id="error" class="alert alert-danger"><p>Could not add '.$first_name.' '.$last_name.'.<br />\''.$email.'\' is already in use</p></div>';
      } else if ($error == 2) {
        echo '<div id="error" class="alert alert-danger"><p>Could not add '.$first_name.' '.$last_name.'.<br />Unknown Error</p></div>';
      }
    }
    ?>
    <div id="msg" class="alert" style="display: none;"></div>
    <div class="row-fluid" style="text-align:center;">
      <button type="button" class="btn btn-success m-b-sm" data-toggle="modal" data-target="#usersModal" style="margin: 0 auto;">Add New Customer</button>
    </div>
    <table id="customers" class="table table-bordered table-hover">
      <thead>
        <tr>
          <td></td>
          <td>Email</td>
          <td>First Name</td>
          <td>Last Name</td>
          <td>Last Activity</td>
          <td>Phone Number</td>
          <td>Notes</td>
          <td></td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </section>

  <form id="add-row-form" action="" method="POST">
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
          </div>
          <div class="modal-body">
            <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-first" class="form-control" placeholder="First Name" required="">
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-last" class="form-control" placeholder="Last Name" required="">
                </div>
              </div>
            </div>
            <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="col-md-6">
                  <input type="password" name="cd-password" class="form-control" placeholder="Password">
                </div>
              </div>
            </div>
            <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                    <select id="cd-type" name="cd-type" class="form-control">
                    <?php $user_type=getUserType($db);
                            if(!empty($user_type)){
                                foreach($user_type as $userTypeName){
                                    if($userTypeName['parent']==0){
                                    ?>
                                if()    
                      <option value="<?php echo $userTypeName['id']; ?>"><?php echo $userTypeName['user_role_type'];?></option>
                      
                    
                                    
                                    <?php } }
                            }
                      ?>
                  </select>
                </div>
                  
                <div class="col-md-6">
                  <input class="form-control" type="text" placeholder="Phone Number" name="cd-phone" id="cd-phone" <?php if (isset($error) && $error > 0) { echo 'value="'.$phone.'"'; } ?>>
                </div>
              
              </div>
            </div>
              
              <div class="col-md-6" id="typeparent" style="height:40px">
                      <select id="cd-type-parent" name="cd-type-parent" class="form-control">
                         
                      </select>
                </div>
              <!--add some more addition field-->
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-email-second" class="form-control" placeholder="Email Secondary" >
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-bio" class="form-control" placeholder="Bio" >
                </div>
              </div>
            </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-weight" class="form-control" placeholder="Weight" >
                </div>
                   <div class="col-md-6">
                  <input type="text" name="cd-height" class="form-control" placeholder="Height">
                </div>
                
              </div>
            </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-company" class="form-control" placeholder="Company" >
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-address-one" class="form-control" placeholder="Address one" >
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-address-two" class="form-control" placeholder="Address Two" >
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-city" class="form-control" placeholder="City" >
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-state-region" class="form-control" placeholder="State/Region" >
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-postal-code" class="form-control" placeholder="Postal Code" >
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-country" class="form-control" placeholder="Country" >
                </div>
                <div class="col-md-6">
                   <select id="cd-accepts-marketing" name="cd-accepts-marketing" class="form-control">
                       <option value="">Accepts Marketing</option>
                       <option value="yes">Yes</option>
                       <option value="no">No</option>
                      </select>
                </div>
              </div>
            </div>
             <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-alias" class="form-control" placeholder="Alias" >
                </div>
                <div class="col-md-6">
                   <select id="cd-privacy-setting" name="cd-privacy-setting" class="form-control">
                       <option value="">Privacy Setting</option>
                       <option value="ON">ON</option>
                       <option value="OFF">OFF</option>
                      </select>
                </div>
              </div>
            </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                 <select id="cd-units" name="cd-units" class="form-control">
                       <option value="">Units</option>
                       <option value="metric">Metric</option>
                       <option value="english">English</option>
                      </select>
                </div>
                <div class="col-md-6">
                   <select id="cd-rangealarm" name="cd-rangealarm" class="form-control">
                       <option value="">Range Alarm</option>
                       <option value="10">10%</option>
                       <option value="25">25%</option>
                       <option value="25">50%</option>
                       <option value="OFF">OFF</option>
                      </select>
                </div>
              </div>
              </div>
              <div class="form-group" style="height:30px">
                   <div class="row-fluid">
                <div class="col-md-6">
                 <select id="cd-notifications-rides" name="cd-notifications-rides" class="form-control">
                       <option value="">Notifications Rides</option>
                       <option value="ON">ON</option>
                       <option value="OFF">OFF</option>
                      </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="cd-primary-riding-style" class="form-control" placeholder="Primary Riding Style">
                </div>
              </div>
              </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                 <select id="cd-safety-brake" name="cd-safety-brake" class="form-control">
                       <option value="">Safety Brake</option>
                       <option value="ON">ON</option>
                       <option value="OFF">OFF</option>
                      </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="cd-preferred-braking-force" class="form-control" placeholder="Preferred Braking Force">
                </div>
              </div>
              </div>
              <div class="form-group" style="height:30px">
                  <div class="row-fluid">
                <div class="col-md-6">
                 <select id="cd-reverse-turned" name="cd-reverse-turned" class="form-control">
                       <option value="">Reverse Turned</option>
                       <option value="ON">ON</option>
                       <option value="OFF">OFF</option>
                      </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="cd-locked-settings" class="form-control" placeholder="Locked Settings">
                </div>
              </div>
            </div>
              <div class="form-group" style="height:30px">
                  <div class="row-fluid">
                <div class="col-md-6">
                 <input type="text" name="cd-twitter-handle" class="form-control" placeholder="Twitter Handle">
                </div>
                <div class="col-md-6">
                    <input type="text" name="cd-linkedin-handle" class="form-control" placeholder="Linkedin Handle">
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
                  <div class="row-fluid">
                <div class="col-md-6">
                 <input type="text" name="cd-instagram-handle" class="form-control" placeholder="Instagram Handle">
                </div>
                <div class="col-md-6">
                    <input type="text" name="cd-reddit-handle" class="form-control" placeholder="Reddit Handle">
                </div>
              </div>
            </div>
                <div class="form-group" style="height:30px">
                  <div class="row-fluid">
              <div class="col-md-6">
                  <input type="text" name="cd-terrain" class="form-control" placeholder="Terrain">
                </div>
                      </div>
            </div>
              <!--end here new changes-->
              <div class="form-group" style="height:90px">
              <div class="row-fluid">
                <div class="col-md-12"> 
                  <textarea name="cd-notes" class="form-control" placeholder="Comment" style="max-height: 90px; height: 90px;"></textarea>
                </div>
              </div>
            </div>
              
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" id="add-row" class="btn btn-success">Add</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
