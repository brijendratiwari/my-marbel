<?php 
  if (isset($_GET['email'], $_GET['lost_password_code'])) {
    $email = $_GET['email'];
    $resetKey = $_GET['lost_password_code'];
  }
?>
<div class="site__container">
	<div class="grid__container">
		<img class="logo" src="/assets/img/loginlogo.png">
		<form action="./" method="post" class="form form--login">
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