<body>
<div class="site__container">
  <div class="grid__container">
    <img class="logo" src="/assets/img/loginlogo.png">
    <form action="./" method="post" class="form form--login">
      <input id="redirect" type="hidden" value="<?php echo $redirect; ?>" />
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
      <p class="text--center">Forgot Password?  &nbsp<a class= "forgot" href="/lost-password">Reset</a></p> 
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