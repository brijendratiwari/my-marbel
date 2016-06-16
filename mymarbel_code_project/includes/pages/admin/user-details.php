<?php
if (isset($_POST['cd-first']) || isset($_POST['cd-last']) || isset($_POST['cd-email']) || isset($_POST['cd-phone'])) {
	$email = isset($_POST['cd-email']) && !empty($_POST['cd-email']) ? $_POST['cd-email'] : $_SESSION['marbel_user']['email'];
	$first_name = isset($_POST['cd-first']) && !empty($_POST['cd-first']) ? $_POST['cd-first'] : $_SESSION['marbel_user']['first_name'];
	$last_name = isset($_POST['cd-last']) && !empty($_POST['cd-last']) ? $_POST['cd-last'] : $_SESSION['marbel_user']['last_name'];
	$type = $_POST['cd-type'];
	$phone = isset($_POST['cd-phone']) && !empty($_POST['cd-phone']) ? $_POST['cd-phone'] : $_SESSION['marbel_user']['phone'];
	$notes = $_POST['cd-notes'];
	$password = '';
	$random_salt = '';
	if (isset($_POST['cd-password']) && !empty($_POST['cd-password'])) {
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		$password = hash('sha512', $_POST['cd-password'] . $random_salt);
	}
	$_SESSION['marbel_user']['email'] = $email;
	$_SESSION['marbel_user']['first_name'] = $first_name;
	$_SESSION['marbel_user']['last_name'] = $last_name;
	$_SESSION['marbel_user']['phone'] = $phone;
	$error = updateUser($_SESSION['marbel_user']['user_id'], $email, $first_name, $last_name, $type, $phone, $notes, $password, $random_salt, $db);
}
?>
<section id="main-content">
<section class="wrapper">
<?php 
		if (isset($error)) {
			if ($error == 0) {
				echo '<div id="error" class="alert alert-success"><p>Your profile was updated successfully</p></div>';
			} else if ($error == 1) {
				echo '<div id="error" class="alert alert-danger"><p>Could not update '.$first_name.' '.$last_name.'.<br />Unknown Error</p></div>';
			}
		}
		?>
  <div class="col-md-9 col-md-offset-1 user-info" style="padding-top:100px;">
   
   

    <div class="col-md-6 left-info-section">
     <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
      <h2>Harmani Owens</h2>

      <div class="clearfix"></div>
        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>
            <div class="panel-body">
               Empty
                    
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
    <div class="row-fluid" style="text-align:right;">
      <button type="button" class="btn btn-success m-b-sm" data-toggle="modal" data-target="#usersModal" style="margin: 0 auto;">Edit</button>
    </div>
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

<!--        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>
            <div class="panel-body">
                Empty
            </div>
        </div>-->
        <div class="aka">
            <div class="social">TWITTER:</div>
            <div class="social">LINKED IN:</div>
        </div>

<!--        <div class="text-right">
          <button class="btn btn-info">NEW PASSWORD RESET</button>
        </div>-->
    </div>
  </div>
<form id="add-row-form" action="" method="POST">
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
          </div>
          <div class="modal-body">
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6"> 
                  <label class="custom-file-input file-blue">
						<input type="file">
				</label>
                
                </div>
              </div>
            </div>
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
                    <input type="text" name="cd-bio" class="form-control" placeholder="Bio" >
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-weight" class="form-control" placeholder="Weight" >
                </div>
              </div>
            </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-height" class="form-control" placeholder="Height">
                </div>
                   <div class="col-md-6">
                   <input type="text" name="cd-company" class="form-control" placeholder="Company" >
                </div>
                
              </div>
            </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-address-one" class="form-control" placeholder="Address one" >
                </div>
                <div class="col-md-6">
                  <input type="text" name="cd-address-two" class="form-control" placeholder="Address Two" >
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-city" class="form-control" placeholder="City" >
                </div>
                <div class="col-md-6">
                 <input type="text" name="cd-state-region" class="form-control" placeholder="State/Region" >
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                  <input type="text" name="cd-postal-code" class="form-control" placeholder="Postal Code" >
                </div>
                <div class="col-md-6">
                   <input type="text" name="cd-country" class="form-control" placeholder="Country" >
                </div>
              </div>
            </div>
               <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                 <select id="cd-accepts-marketing" name="cd-accepts-marketing" class="form-control">
                       <option value="">Accepts Marketing</option>
                       <option value="yes">Yes</option>
                       <option value="no">No</option>
                      </select>
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
                   
                </div>
              </div>
              </div>
              <div class="form-group" style="height:30px">
                   <div class="row-fluid">
                <div class="col-md-6">
                 <input type="text" name="cd-primary-riding-style" class="form-control" placeholder="Primary Riding Style">
                </div>
                <div class="col-md-6">
                    <select id="cd-safety-brake" name="cd-safety-brake" class="form-control">
                       <option value="">Safety Brake</option>
                       <option value="ON">ON</option>
                       <option value="OFF">OFF</option>
                      </select>
                </div>
              </div>
              </div>
              <div class="form-group" style="height:30px">
              <div class="row-fluid">
                <div class="col-md-6">
                <input type="text" name="cd-preferred-braking-force" class="form-control" placeholder="Preferred Braking Force">
                </div>
                <div class="col-md-6">
                    <select id="cd-reverse-turned" name="cd-reverse-turned" class="form-control">
                       <option value="">Reverse Turned</option>
                       <option value="ON">ON</option>
                       <option value="OFF">OFF</option>
                      </select> 
                </div>
              </div>
              </div>
             
             
               <div class="form-group" style="height:30px">
                  <div class="row-fluid">
                <div class="col-md-6">
                 <input type="text" name="cd-reddit-handle" class="form-control" placeholder="Reddit Handle">
                </div>
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
            <button type="submit" id="add-row" class="btn btn-success">Update</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
</section>
<style>
    
.custom-file-input {
    color: #533e00;
    display: inline-block;
    position: relative;
}
.custom-file-input input {
    visibility: hidden;
    width: 100px;
}
.custom-file-input::before {
    background: rgba(0, 0, 0, 0) linear-gradient(-180deg, #ffdc73, #febf01) repeat scroll 0 0;
    border: 3px solid #dca602;
    border-radius: 10px;
    content: "Choose File";
    cursor: pointer;
    display: block;
    font-size: 10pt;
    font-weight: bold;
    left: 0;
    outline: medium none;
    padding: 5px 0;
    position: absolute;
    right: 0;
    text-align: center;
    text-shadow: 1px 1px rgba(255, 255, 255, 0.7);
    white-space: nowrap;
}
.custom-file-input:hover::before {
    border-color: #febf01;
}
.custom-file-input:active::before {
    background: #febf01 none repeat scroll 0 0;
}
.file-blue::before {
    background: rgba(0, 0, 0, 0) linear-gradient(-180deg, #99dff5, #02b0e6) repeat scroll 0 0;
    border-color: #57cff4;
    color: #fff;
    content: "Profile Image";
    text-shadow: 1px 1px rgba(0, 0, 0, 0.5);
}
.file-blue:hover::before {
    border-color: #02b0e6;
}
.file-blue:active::before {
    background: #02b0e6 none repeat scroll 0 0;
}
</style>