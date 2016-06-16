<script>
  $(document).ready(function(){
    $('#loader').css('display', 'none', 'important');
    $("#login__submit").click(function(){
      email=$("#login__email").val();
      $.ajax({
        type: "POST",
        url: "/ajax/reset-password",
        data: "reset_request_email="+email,
        success: function(html) { 
          if (html==1) {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
            $("#error_text").html("Email not found");
            setTimeout(function() { $("#error").fadeOut("slow"); }, 5000); 
          } else {
            $("#error").fadeIn("slow");
            $('#error').addClass('error');
            $('#loader').css('display', 'none', 'important');
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