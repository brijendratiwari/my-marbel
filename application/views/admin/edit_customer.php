<div id="page-wrapper">

            
            <div class="row">
             
                <div class="col-md-12" style="margin-top:10px"><a class='btn btn-sm btn-default' href="<?php echo base_url('customers'); ?>">Go Back</a>  </div>
                  
                <div class="col-md-12 menu-drop-down">
                    <?php
                    if ( $this->session->flashdata('success')) {
                        echo '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>';
                    }
                    ?>
                    <form class="cd-form floating-labels" style="max-width: 100%; width: 100%;margin: 0px;" method="POST" action="">
                            <input type="hidden" name="cd-type" value="<?php echo $customer['type'];?>">
                            <input type="hidden" name="cd-parent" value="<?php echo $customer['parent_type'];?>">
                            <input type="hidden" name="cd-user_id" value="<?php echo $customer['id']; ?>" />
                            <div style="margin-top:25px;">
                            <h1 style="padding: 0">
                                <span style="float: left">User Details:</span>
                                <span style="float: right">
                                    <p class="cd-select">
                                        <?php
                                        $menu = array(
                                            'menus' => array(),
                                            'parent_menus' => array()
                                        );
                                        if (!empty($user_type)) {
                                            foreach ($user_type as $userTypeName) {
                                                $menu['menus'][$userTypeName['id']] = $userTypeName;
                                                $menu['parent_menus'][$userTypeName['parent']][] = $userTypeName['id'];
                                            }
                                        }
                                       ?>
                                        
                                        <div id='cssmenu'>
                                            <label>Users <span class="caret"></span></label>
                                        <?php 
                                     
                                        echo buildMenu(0, $menu,0); ?>
                                        </div>
                                         
                                </span>
                            </h1>
                                </div>
                                <div class="col-md-12">
                                    <?php if(empty($customer['user_profile_pic'])){ ?>
                             <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                <?php }else{ ?>
                             <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="<?php echo base_url('assets/profile-imgs/'.$customer['user_profile_pic'].''); ?>" data-holder-rendered="true">
                                <?php } ?>
                                   
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label>User</label>
                                        <p id="parentlevel"><?php echo $customer['parent_name']?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>User Type</label>
                                        <p id="childlevel"><?php echo $customer['child_name']?></p>
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                   
                                    
                               
                                    <div class="col-md-6  form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="cd-first_name" id="cd-first_name" value="<?php echo $customer['first_name']; ?>" placeholder="First Name">
                                    </div>
                                    <div class="col-md-6  form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="cd-last_name" id="cd-last_name" value="<?php echo $customer['last_name']; ?>" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6 form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="cd-email" id="cd-email" value="<?php echo $customer['email']; ?>" placeholder="Email">
                                    </div>
                                    <div class="col-md-6  form-group">
                                         <label>Phone</label>
                                        <input type="text" class="form-control" name="cd-phone" id="cd-phone" value="<?php echo $customer['phone']; ?>" placeholder="Phone">
                                    </div>
                                </div>
<!--                                <div class="col-md-12">
                                     
                                    <div class="col-md-12 form-group">
                                         <label>Password</label>
                                        <input type="password" class="form-control" name="cd-password" id="cd-password" placeholder="Enter a new password">
                                    </div>
                                </div>-->
                            <!--add new column for users-->
                                <div class="col-md-12">
                                    <div class="col-md-6 form-group">
                                         <label>Email Secondary</label>
                                        <input type="text" class="form-control" name="cd-email-second" id="cd-email-second"  placeholder="Email Secondary" value="<?php echo $customer['email_secondary']; ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Bio</label>
                                        <input type="text" class="form-control" name="cd-bio" id="cd-email-second"  placeholder="Bio" value="<?php echo $customer['bio']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Weight</label>
                                        <input type="text" class="form-control" name="cd-weight" id="cd-weight"  placeholder="Weight" value="<?php echo $customer['weight']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Height</label>
                                        <input type="text" class="form-control" name="cd-height" id="cd-height"  placeholder="Height" value="<?php echo $customer['height']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                         <label>Company</label>
                                        <input type="text" class="form-control" name="cd-company" id="cd-company"  placeholder="Company" value="<?php echo $customer['company']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="cd-address-one" id="cd-address-one"  placeholder="Address One" value="<?php echo $customer['address_one']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Address Two</label>
                                        <input type="text" class="form-control" name="cd-address-two" id="cd-address-two"  placeholder="Address Two" value="<?php echo $customer['address_two']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input type="text" class="form-control" name="cd-city" id="cd-city"  placeholder="City" value="<?php echo $customer['city']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                         <label>State/Region</label>
                                        <input type="text" class="form-control" name="cd-state-region" id="cd-state-region"  placeholder="State/Region" value="<?php echo $customer['state_or_region']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                          <label>Postal Code</label>
                                        <input type="text" class="form-control" name="cd-postal-code" id="cd-postal-code"  placeholder="Postal Code" value="<?php echo $customer['postal_code']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="cd-country" id="cd-country"  placeholder="Country" value="<?php echo $customer['country']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                          <label>Alias</label>
                                        <input type="text" class="form-control" name="cd-alias" id="cd-alias"  placeholder="Alias" value="<?php echo $customer['alias']; ?>">
                                    </div>
                                    
                                </div>
                            <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Twitter Handle</label>
                                        <input type="text" class="form-control" name="cd-twitter-handle" id="cd-twitter-handle"  placeholder="Twitter Handle" value="<?php echo $customer['twitter_handle']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                         <label>Linkedin Handle</label>
                                        <input type="text" class="form-control" name="cd-linkedin-handle" id="cd-linkedin-handle"  placeholder="Linkedin Handle" value="<?php echo $customer['linkedin_handle']; ?>">
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Instagram Handle</label>
                                        <input type="text" class="form-control" name="cd-instagram-handle" id="cd-instagram-handle"  placeholder="Instagram Handle" value="<?php echo $customer['instagram_handle']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Reddit Handle</label>
                                        <input type="text" class="form-control" name="cd-reddit-handle" id="cd-reddit-handle"  placeholder="Reddit Handle" value="<?php echo $customer['reddit_handle']; ?>">
                                        
                                    </div>
                                </div>
                                
                              <div class="col-md-12 form-group">
                                  <div class="col-md-12">
                                          <label>Note of order</label>
                                           <textarea name="cd-note-order" class="form-control" placeholder="Write here note of order....." style="max-height: 90px; height: 90px;"><?php echo $customer['note_orders']?></textarea>
                                   
                                    </div>
                                    <div class="col-md-12">
                                          <label>Note Of Services</label>
                                          <textarea name="cd-note-services" class="form-control" placeholder="Write here note of services....." style="max-height: 90px; height: 90px;"><?php echo $customer['note_services']?></textarea>
                                        
                                    </div>
                                    <div class="col-md-12">
                                          <label>Note of Tasks Regarding</label>
                                           <textarea name="cd-note-task" class="form-control" placeholder="Write here note of tasks regarding....." style="max-height: 90px; height: 90px;"><?php echo $customer['note_tasks']?></textarea>
                                        
                                    </div>
                                  <div class="col-md-12">
                                    <label>Note of Open Support Tickets</label>
                                   <textarea name="cd-support-tickets" class="form-control" placeholder="Write here note of open support tickets" style="max-height: 90px; height: 90px;"><?php echo $customer['note_support_ticket']?></textarea>
                                  </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Accepts Marketing : </label>
                                        <span class='label label-info'><?php echo (!empty($customer['accepts']))?$customer['accepts']:"";?></span>
                                      
                                    </div>
                                    <div class="col-md-6">
                                        <label>Privacy Setting : </label>
                                        
                                         <span class='label label-info'><?php echo (!empty($customer['privacy_setting']))?$customer['privacy_setting']:"Empty";?></span>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                          <label>Units : </label>
                                        <span class='label label-info'><?php echo (!empty($customer['units']))?$customer['units']:"Empty";?></span>
                                    </div>
                                    <div class="col-md-6">
                                         <label>Range Alarm : </label>
                                         <span class='label label-info'><?php echo (!empty( $customer['range_alarm']))? $customer['range_alarm'].'%':"Empty";?></span>
                                       
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Notifications Rides : </label>
                                        <span class='label label-info'><?php echo (!empty($customer['notifications']))? $customer['notifications']:"Empty";?></span>
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label>Primary Riding Style : </label>
                                        <span class='label label-info'><?php echo (!empty($customer['primary_riding_style']))? $customer['primary_riding_style']:"Empty";?></span>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Safety Brake : </label>
                                        <span class='label label-info'><?php echo (!empty($customer['safety_brake']))? $customer['safety_brake']:"";?></span>
                                       
                                    </div>
                                    <div class="col-md-6">
                                         <label>Preferred Braking Force : </label>
                                         <span class='label label-info'><?php echo (!empty($customer['preferred_braking_force']))? $customer['preferred_braking_force'].'%':"Empty";?></span>
                                       
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Reverse Turned : </label>
                                         <span class='label label-info'><?php echo (!empty( $customer['reverse_turned']))?  $customer['reverse_turned']:"Empty";?></span>
                                       
                                    </div>
                                     <div class="col-md-6">
                                          <label>Terrain : </label>
                                          <span class='label label-info'><?php echo (!empty( $customer['terrain']))?  $customer['terrain']:"Empty";?></span>
                                       
                                    </div>
                                </div>
                                 <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                        <label>Lock : </label>
                                         <span class='label label-info'><?php echo (!empty( $customer['locked_settings']))?  $customer['locked_settings']:"Empty";?></span>
                                       
                                    </div>
                                     <div class="col-md-6">
                                          <label>Parental lock : </label>
                                          <span class='label label-info'><?php echo (!empty( $customer['parental_lock']))?  $customer['parental_lock']:"Empty";?></span>
                                       
                                    </div>
                                </div>
                            <!--end here-->
                             
                                <div class="col-md-12" style="margin-top:10px">
                                     <div class="col-md-6 form-group">
                                    
                                        <a href="/new_services/<?php echo $customer['id']; ?>" class="btn btn-custom btn-lg" >Add Service Record</a>
                                            <input type="submit" name="cd-submit" class="btn btn-custom btn-lg" value="Save Changes">
                                           <a href="javascript:deleteCustomer('<?php echo $customer['id']; ?>')" class="btn btn-lg btn-danger">Delete</a>
                                    </div>
                                </div>
                    </form>
                </div>

           
        </div>
</div>
<style>
    /* add cee for custome menu user on edit customer*/
 .menu-drop-down h1{
       float: left;
    padding: 0;
    position: relative;
    width: 100%;  
    }
    .menu-drop-down .cd-select{
        z-index: 10!important;
    }
    
.menu-drop-down #cssmenu ul#nav{
    display: none;
    border: 1px solid #d3d3d3;
}
.menu-drop-down #cssmenu:hover ul#nav{display: block;}
.menu-drop-down #nav li{
    display: block; 
    font-size: 14px;
    padding: 8px 3px;
    border-bottom: 1px solid #e0e0e0;
    cursor: pointer;
}
.menu-drop-down #nav li ul{
    background: #f1f1f1 none repeat scroll 0 0;
    border: 1px solid #e6e6e6;
    display: none;
    left: -99%;
    padding: 10px;
    position: absolute;
    width: 130px;
    padding: 0;
}
.menu-drop-down #nav li ul li{
    font-size: 13px;
}
.menu-drop-down #nav li:hover ul{
    display: block;
    margin-top: -24px;
}
.menu-drop-down #nav li:hover{
    background: #eee;
}
#cssmenu {
    background: #fff none repeat scroll 0 0;
    /*box-shadow: 0 0 7px -3px #000;*/
    position: absolute;
    right: -2px;
    top: -39px;
    width: 130px;
    z-index: 9;
}
/*end here*/
</style>
<script>
   // JavaScript Document

        startList = function() {
        if (document.all&&document.getElementById) {
        navRoot = document.getElementById("nav");
        for (i=0; i<navRoot.childNodes.length; i++) {
        node = navRoot.childNodes[i];
        if (node.nodeName=="LI") {
        node.onmouseover=function() {
        this.className+=" over";
          }
          node.onmouseout=function() {
          this.className=this.className.replace(" over", "");
           }
           }
          }
         }
        }
window.onload=startList;
$(function(){
          // Your event
        $('.child-li').click(function(){
               // Get the ID for the element that was clicked
               var childId = $(this).attr('id');
               var parentId = $(this).parents('li').attr('id');
               $('input[name="cd-type"').val(childId);
                $('input[name="cd-parent"').val(parentId);
                $("#parentlevel").html($('#'+parentId).clone().children().remove().end().text());
                $("#childlevel").html($(this).text());
          });
           $('.parent-li').on('click',function(){
            if($(this).children().length == 0){
                  
                   var currentId = $(this).attr('id');
                 $('input[name="cd-type"').val(currentId);
                 $('input[name="cd-parent"').val(currentId);
                  $("#parentlevel").html($(this).text());
                    $("#childlevel").html($(this).text());
              }
              
          })
       
     });
 function deleteCustomer(id){
      
       if (confirm('Are you sure you want to delete?'))
        {
            window.location.href = "<?php echo base_url() ?>deleteCustomer/" + id;
        }
      
  }
</script>