<?php
if (isset($_POST['cd-submit'])) {
    #echo "<pre>"; print_r($_POST); die;
    $user_id = $_POST['cd-user_id'];
    $first_name = $_POST['cd-first_name'];
    $last_name = $_POST['cd-last_name'];
    $type = $_POST['cd-type'];
    $parent_type = $_POST['cd-parent'];
    $email = $_POST['cd-email'];
    $phone = $_POST['cd-phone'];
    $notes = $_POST['cd-notes'];
    $password = $_POST['cd-password'];
    $email_second = $_POST['cd-email-second'];
    $bio = $_POST['cd-bio'];
    $weight = $_POST['cd-weight'];
    $height = $_POST['cd-height'];
    $company = $_POST['cd-company'];
    $address_one = $_POST['cd-address-one'];
    $address_two = $_POST['cd-address-two'];
    $city = $_POST['cd-city'];
    $state_region = $_POST['cd-state-region'];
    $postal_code = $_POST['cd-postal-code'];
    $country = $_POST['cd-country'];
    $accepts_marketing = $_POST['cd-accepts-marketing'];
    $alias = $_POST['cd-alias'];
    $privacy_setting = $_POST['cd-privacy-setting'];
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
    $random_salt = '';
    if (!empty($password)) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password . $random_salt);
    }
    $error = adminUpdateCustomer(
            $user_id, 
            $first_name, 
            $last_name, 
            $type,
            $parent_type,  
            $email, 
            $phone, 
            $password, 
            $random_salt, 
            $notes,
            $email_second,
            $bio,
            $weight,
            $height,
            $company,
            $address_one,
            $address_two,
            $city,
            $state_region,
            $postal_code,
            $country,
            $accepts_marketing,
            $alias,
            $privacy_setting,
            $units,
            $rangealarm,
            $notifications_rides,
            $primary_riding_style,
            $safety_brake,
            $preferred_braking_force,
            $reverse_turned,
            $locked_settings,
            $terrain, 
            $twitter_handle,
            $linkedin_handle,
            $instagram_handle,
            $reddit_handle,
            $db);
}

if (isset($_GET['id'])) {
    $customer = getCustomer($_GET['id'], $db);
    #echo "<pre>"; print_r($customer); die;
 }
?>
<section id="main-content">
    <section class="wrapper" style="padding-top: 50px;">
        <div class="container">
            
            <div class="row-fluid">
                
                  
                <div class="col-md-12 menu-drop-down">
                    <?php
                    if (isset($user_id)) {
                        echo '<div class="alert alert-success">User ' . $first_name . ' ' . $last_name . ' has been updated</div>';
                    }
                    ?>
                    <form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
                        <fieldset>
                            <input type="hidden" name="cd-type" value="<?php echo $customer['type'];?>">
                            <input type="hidden" name="cd-parent" value="<?php echo $customer['parent_type'];?>">
                            <input type="hidden" name="cd-user_id" value="<?php echo $customer['user_id']; ?>" />
                            <h1 style="padding: 0">
                                <span style="float: left">Customer Details:</span>
                                <span style="float: right">
                                    <p class="cd-select">
                                        <?php
                                        $menu = array(
                                            'menus' => array(),
                                            'parent_menus' => array()
                                        );
                                        $user_type = getUserType($db);
                                        if (!empty($user_type)) {
                                            foreach ($user_type as $userTypeName) {
                                                $menu['menus'][$userTypeName['id']] = $userTypeName;
                                                $menu['parent_menus'][$userTypeName['parent']][] = $userTypeName['id'];
                                            }
                                        }
                                       ?>
                                        
                                        <div id='cssmenu'>
                                            <label>Users</label>
                                        <?php echo buildMenu(0, $menu,0); ?>
                                        </div>
                                         </p>
                                </span>
                            </h1>
                            <div class="row-fluid">
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <?php if(isset($customer['user_profile_pic']) && !empty($customer['user_profile_pic'])){?>
                                        <img alt="140x140" class="img-circle" data-src="<?php echo  $customer['user_profile_pic'];?>" style="width: 140px; height: 140px; float: left;"  data-holder-rendered="true">
                                        <?php
                                    }else{ ?>
                                    <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                    <?php }?>
                                </div>
                            </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">User:
                                        <p id="parentlevel"><?php echo getLevelUsersName($customer['parent_type'],$db)?></p>
                                    </div>
                                    <div class="col-md-6">User Type:
                                        <p id="childlevel"><?php echo getLevelUsersName($customer['type'],$db)?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-first_name" id="cd-first_name" value="<?php echo $customer['first_name']; ?>" placeholder="First Name"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-last_name" id="cd-last_name" value="<?php echo $customer['last_name']; ?>" placeholder="Last Name"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-email" id="cd-email" value="<?php echo $customer['email']; ?>" placeholder="Email"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-phone" id="cd-phone" value="<?php echo $customer['phone']; ?>" placeholder="Phone"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <p><input type="text" name="cd-password" id="cd-password" placeholder="Enter a new password"></p>
                                    </div>
                                </div>
                            </div>
                            <!--add new column for users-->
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-email-second" id="cd-email-second"  placeholder="Email Secondary" value="<?php echo $customer['email_secondary']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-bio" id="cd-email-second"  placeholder="Bio" value="<?php echo $customer['bio']; ?>"></p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-weight" id="cd-weight"  placeholder="Weight" value="<?php echo $customer['weight']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-height" id="cd-height"  placeholder="Height" value="<?php echo $customer['height']; ?>"></p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-company" id="cd-company"  placeholder="Company" value="<?php echo $customer['company']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-address-one" id="cd-address-one"  placeholder="Address One" value="<?php echo $customer['address_one']; ?>"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-address-two" id="cd-address-two"  placeholder="Address Two" value="<?php echo $customer['address_two']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-city" id="cd-city"  placeholder="City" value="<?php echo $customer['city']; ?>"></p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-state-region" id="cd-state-region"  placeholder="State/Region" value="<?php echo $customer['state_or_region']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-postal-code" id="cd-postal-code"  placeholder="Postal Code" value="<?php echo $customer['postal_code']; ?>"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-country" id="cd-country"  placeholder="Country" value="<?php echo $customer['country']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><select id="cd-accepts-marketing" name="cd-accepts-marketing">
                                            <option value="">Accepts Marketing</option>
                                            <option value="yes" <?php if (strcmp($customer['accepts'], 'yes') == 0) { echo 'selected="selected"'; }?>>Yes</option>
                                            <option value="no" <?php if (strcmp($customer['accepts'], 'no') == 0) { echo 'selected="selected"'; }?>>No</option>
                                           </select></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-alias" id="cd-alias"  placeholder="Alias" value="<?php echo $customer['alias']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><select id="cd-privacy-setting" name="cd-privacy-setting">
                                            <option value="">Privacy Setting</option>
                                            <option value="ON" <?php if (strcmp($customer['privacy_setting'], 'ON') == 0) { echo 'selected="selected"'; }?>>ON</option>
                                            <option value="OFF" <?php if (strcmp($customer['privacy_setting'], 'OFF') == 0) { echo 'selected="selected"'; }?>>OFF</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><select id="cd-units" name="cd-units">
                                            <option value="">Units</option>
                                            <option value="metric" <?php if (strcmp($customer['units'], 'metric') == 0) { echo 'selected="selected"'; }?>>Metric</option>
                                            <option value="english" <?php if (strcmp($customer['units'], 'admin') == 0) { echo 'selected="selected"'; }?>>English</option>
                                           </select></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p> <select id="cd-rangealarm" name="cd-rangealarm" >
                                                <option value="">Range Alarm</option>
                                                <option value="10" <?php if (strcmp($customer['range_alarm'], '10') == 0) { echo 'selected="selected"'; }?>>10%</option>
                                                <option value="25" <?php if (strcmp($customer['range_alarm'], '20') == 0) { echo 'selected="selected"'; }?>>25%</option>
                                                <option value="25" <?php if (strcmp($customer['range_alarm'], '25') == 0) { echo 'selected="selected"'; }?>>50%</option>
                                                <option value="OFF" <?php if (strcmp($customer['range_alarm'], 'OFF') == 0) { echo 'selected="selected"'; }?>>OFF</option>
                                               </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><select id="cd-notifications-rides" name="cd-notifications-rides">
                                                <option value="">Notifications Rides</option>
                                                <option value="ON" <?php if (strcmp($customer['notifications'], 'ON') == 0) { echo 'selected="selected"'; }?>>ON</option>
                                                <option value="OFF" <?php if (strcmp($customer['notifications'], 'OFF') == 0) { echo 'selected="selected"'; }?>>OFF</option>
                                            </select></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-primary-riding-style" id="cd-primary-riding-style"  placeholder="Primary Riding Style" value="<?php echo $customer['primary_riding_style']; ?>">
                                        </p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><select id="cd-safety-brake" name="cd-safety-brake">
                                            <option value="">Safety Brake</option>
                                            <option value="ON" <?php if (strcmp($customer['safety_brake'], 'ON') == 0) { echo 'selected="selected"'; }?>>ON</option>
                                            <option value="OFF" <?php if (strcmp($customer['safety_brake'], 'OFF') == 0) { echo 'selected="selected"'; }?>>OFF</option>
                                            </select></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-preferred-braking-force"  placeholder="Preferred Braking Force" value="<?php echo $customer['preferred_braking_force']; ?>">
                                        </p>
                                    </div>
                                </div>
                            </div>
                               <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><select id="cd-reverse-turned" name="cd-reverse-turned" >
                                            <option value="">Reverse Turned</option>
                                            <option value="ON" <?php if (strcmp($customer['reverse_turned'], 'ON') == 0) { echo 'selected="selected"'; }?>>ON</option>
                                            <option value="OFF" <?php if (strcmp($customer['reverse_turned'], 'OFF') == 0) { echo 'selected="selected"'; }?>>OFF</option>
                                           </select></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-locked-settings" id="cd-locked-settings"  placeholder="Preferred Braking Force" value="<?php echo $customer['locked_settings']; ?>">
                                        </p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-twitter-handle" id="cd-twitter-handle"  placeholder="Twitter Handle" value="<?php echo $customer['twitter_handle']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-linkedin-handle" id="cd-linkedin-handle"  placeholder="Linkedin Handle" value="<?php echo $customer['linkedin_handle']; ?>">
                                        </p>
                                    </div>
                                </div>
                            </div>
                             <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-instagram-handle" id="cd-instagram-handle"  placeholder="Instagram Handle" value="<?php echo $customer['instagram_handle']; ?>"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><input type="text" name="cd-reddit-handle" id="cd-reddit-handle"  placeholder="Reddit Handle" value="<?php echo $customer['reddit_handle']; ?>">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <p><input type="text" name="cd-terrain" id="cd-terrain" placeholder="Terrain" value="<?php echo $customer['terrain']; ?>"></p>
                                    </div>
                                </div>
                            </div>
                            <!--end here-->
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <p><textarea class="notes" name="cd-notes" id="cd-notes" placeholder="Add notes to this user"><?php echo $customer['notes']; ?></textarea></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <a href="/new-service?id=<?php echo $customer['user_id']; ?>" class="btn btn-primary btn-lg outline text-center" >Add Service Record</a>
                                    </div>
                                    <div class="col-md-offset-6 col-md-3">
                                        <input type="submit" name="cd-submit" class="btn btn-primary btn-lg outline text-center" value="Save Changes">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
