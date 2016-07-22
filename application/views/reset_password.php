<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(str_replace('-', ' ', $page)); ?></title>
    <link rel="stylesheet" href="/assets/css/style-login.css">
  </head>
   <div class="site__container">
  <div class="grid__container">
            <img class="logo" src="/assets/img/loginlogo.png">
            <form action="" method="post" class="form form--login">
                <input type="hidden" id="reset_key" value="<?php echo $resetKey; ?>">
                <input type="hidden" id="email" value="<?php echo $email; ?>">
                <div class="form__field">
                    <label class="fontawesome-user" for="login_password"><span class="hidden">New Password</span></label>
                    <input id="login_password" type="password" class="form__input" placeholder="New Password" required>
                </div>
                <div class="form__field">
                    <label class="fontawesome-user" for="login_password_2"><span class="hidden">Confirm Password</span></label>
                    <input id="login_password_2" type="password" class="form__input" placeholder="Confirm Password" required>
                </div>
                <div class="form__field">
                    <input id="login__update__password" type="submit" value="Update Password">
                </div>
                <div class="form__field">&nbsp
                    <div id="error">
                        <div id="loader">
                            <div id="loader_1" class="loader"></div>
                            <div id="loader_2" class="loader"></div>
                            <div id="loader_3" class="loader"></div>
                            <div id="loader_4" class="loader"></div>
                            <div id="loader_5" class="loader"></div>
                            <div id="loader_6" class="loader"></div>
                            <div id="loader_7" class="loader"></div>
                            <div id="loader_8" class="loader"></div>
                            <div class="clearfix"></div>
                        </div><br />
                        <p id="error_text"></p>
                    </div>
                </div>
            </form>
            </div>
</div>
  
 <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
  $(document).ready(function(){
    $("#login__update__password").click(function(){
     $('#login__update__password').val('loading...');
    $('#login__update__password').attr('disabled','disabled');   
     var password1=$("#login_password").val();
     var password2=$("#login_password_2").val();
     var resetKey=$("#reset_key").val();
     var email=$("#email").val();
    if (password1=='') {
         $("#error").fadeIn("slow");
         $('#error').addClass('error');
        
         $("#error_text").html("New password is required");
          $('#login__update__password').val('Update Password');
            $('input[type="submit"]').removeAttr('disabled','disabled');
         setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
         return false;
      }
      else if(password2==''){
         $("#error").fadeIn("slow");
         $('#error').addClass('error');
         $("#error_text").html("Confirm password is required");
         $('#login__update__password').val('Update Password');
         $('input[type="submit"]').removeAttr('disabled','disabled');
         setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
         return false;
      }
      else
      {
          
        if (password1 != password2) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $("#error_text").html("Your passwords do not match");
            $('#login__update__password').val('Update Password');
            $('input[type="submit"]').removeAttr('disabled','disabled');
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
            return false;
         }
      }
      
      $.ajax({
        type: "POST",
        url: "/login/ajax_forgot",
        data: "reset_password="+password1+"&reset_key="+resetKey+"&reset_email="+email,
        success: function(html) { 
          console.log(html);
          if (html==1||html==2) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#login__update__password').val('Update Password');
            $('input[type="submit"]').removeAttr('disabled','disabled');
            $("#error_text").html("Invalid reset key, please check the link in your email again");
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
          } else {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
             $('#login__update__password').val('Update Password');
            $('input[type="submit"]').removeAttr('disabled','disabled');
            $("#error_text").html("Your password has been updated");
            setTimeout(function() { $("#error").fadeOut("slow"); 
            window.location='<?php echo base_url();?>'; }, 5000); 
          }
        },
        beforeSend:function() {
          <?php 
          if (isset($error)) { echo "$('#error').removeClass('error');"; }
          ?>
          $('#loader').fadeIn('10');
          $('#error_text').html('');
          $("#error").fadeIn("slow");
        }
      });
      return false;
    });
  });
</script>


