
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(str_replace('-', ' ', $page)); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style-login.css">
  </head>
<div class="site__container">
  <div class="grid__container">
    <img class="logo" src="<?php echo base_url(); ?>/assets/img/loginlogo.png">
    <form action="./" method="post" class="form form--login">
      <input id="redirect" type="hidden" value="<?php //echo $redirect; ?>" />
      <div class="form__field">
        <label class="fontawesome-user" for="login__email"><span class="hidden">Email</span></label>
        <input id="login__email" type="text" class="form__input" placeholder="Email" required>
      </div>
      <div class="form__field">
        <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
        <input id="login__password" type="password" class="form__input" placeholder="Password" required>
      </div>
      <div class="form__field">
        <input id="login__submit" type="submit" value="Sign In">
      </div>
      <!-- <p class="text--center">Not a member? &nbsp <a class= "forgot" href="#">Sign up now</a></p> -->
      <p class="text--center">Forgot Password?  &nbsp<a class= "forgot" href="forgot_password">Reset</a></p> 
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
  </body>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script>
  $(document).ready(function(){
    <?php 
    if (!isset($error)) { 
      echo "$('#error').css('display', 'none', 'important'); "; 
    } else {
      echo "$('#error').addClass('error'); $('#error_text').html('".$error."');";
    }
    ?>
    $('#loader').css('display', 'none', 'important');
    $("#login__submit").click(function(){
      var email=$("#login__email").val();
      var password=$("#login__password").val();
      if(email!=''){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>/login/ajax_login",
        data: "login__email="+email+"&login__password="+password,
        success: function(html) { 
            
          if (html==1) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("You have tried to log in too many times <br /> Your IP address was recorded and your account has been locked for 2 hours");
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
          } else if (html==2) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("Wrong username or password");
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
          } else {
            window.location=html;
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
      }else{
        
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("Can not be empty username or password");
             setTimeout(function() { $("#error").fadeOut("slow"); }, 5000);
      }
return false;
});
});
</script>
</html>