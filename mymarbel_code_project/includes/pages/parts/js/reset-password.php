<script>
  $(document).ready(function(){
    $('#loader').css('display', 'none', 'important');
    $("#login__update__password").click(function(){
      password1=$("#login_password").val();
      password2=$("#login_password_2").val();
      resetKey=$("#reset_key").val();
      email=$("#email").val();
      if (password1 != password2) {
        $("#error").fadeIn("slow");
        $('#error').addClass('error');
        $('#loader').css('display', 'none', 'important');
        $("#error_text").html("Your passwords do not match");
        setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
        return false;
      }
      $.ajax({
        type: "POST",
        url: "/ajax/reset-password",
        data: "reset_password="+password1+"&reset_key="+resetKey+"&reset_email="+email,
        success: function(html) { 
          console.log(html);
          if (html==1||html==2) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("Invalid reset key, please check the link in your email again");
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
          } else {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("Your password has been updated");
            setTimeout(function() { $("#error").fadeOut("slow"); window.location='/'; }, 5000); 
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


