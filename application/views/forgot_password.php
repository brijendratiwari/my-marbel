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
    <form action="./" method="post" class="form form--login">
      <div class="form__field">
        <label class="fontawesome-user" for="login__email"><span class="hidden">Email</span></label>
        <input id="login__email" type="text" class="form__input" placeholder="Email" required>
      </div>
      <div class="form__field">
        <input id="login__submit" type="submit" value="Request Reset">
      </div>
        <p class="text--center">Login? &nbsp<a class= "forgot" href="login">Click here</a></p> 
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
   
    $("#login__submit").click(function(){
    $('#login__submit').val('loading...');
    $('input[type="submit"]').attr('disabled','disabled');
     var email=$("#login__email").val();
      $.ajax({
        type: "POST",
        url: "/login/ajax_forgot",
        data: "reset_request_email="+email,
        success: function(html) { 
          if (html==0) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("Email not found");
            $('#login__submit').val('Request Reset');
            $('input[type="submit"]').removeAttr('disabled','disabled');
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
          } else {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#login__submit').val('Request Reset');
            $('input[type="submit"]').removeAttr('disabled','disabled');
            $("#error_text").html("Please check your email for a password reset link");
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
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
</html>