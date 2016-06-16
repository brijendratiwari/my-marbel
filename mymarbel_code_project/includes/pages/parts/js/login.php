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
      email=$("#login__email").val();
      password=$("#login__password").val();
      redirect=$("#redirect").val();
      $.ajax({
        type: "POST",
        url: "/ajax/login",
        data: "login__email="+email+"&login__password="+password+"&redirect="+redirect,
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
return false;
});
});
</script>