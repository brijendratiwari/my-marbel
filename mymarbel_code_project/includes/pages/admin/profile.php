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
		<form method="POST" action="">
			<legend>Profile Information</legend>

			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<input class="form-control" type="text" name="cd-first" id="cd-first" <?php if (isset($_SESSION['marbel_user']['first_name'])) { echo 'value="'.$_SESSION['marbel_user']['first_name'].'"'; } ?> placeholder="First Name" required>
					</div>
					<div class="col-md-6">
						<input class="form-control" type="text" name="cd-last" id="cd-last" <?php if (isset($_SESSION['marbel_user']['last_name'])) { echo 'value="'.$_SESSION['marbel_user']['last_name'].'"'; } ?> placeholder="Last Name" required>
					</div>
				</div>
			</div>
			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<input class="form-control" type="text" name="cd-email" id="cd-email" <?php if (isset($_SESSION['marbel_user']['email'])) { echo 'value="'.$_SESSION['marbel_user']['email'].'"'; } ?> placeholder="Email" required>
					</div>
					<div class="col-md-6">
						<input class="form-control" type="password" name="cd-password" id="cd-password" placeholder="Password">
					</div>
				</div>
			</div>
			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<select class="form-control disabled" id="cd-type" name="cd-type">
							<?php
							if ($_SESSION['marbel_user']['type'] == 'admin') { 
								echo '<option value="admin">Admin</option>';
							} else if ($_SESSION['marbel_user']['type'] == 'employee') { 
								echo '<option value="employee">Employee</option>';
							} else if ($_SESSION['marbel_user']['type'] == 'dealer') { 
								echo '<option value="dealer">Dealer</option>';
							} else if ($_SESSION['marbel_user']['type'] == 'customer') { 
								echo '<option value="customer">Customer</option>';
							} 
							?>
						</select>					
					</div>
					<div class="col-md-6">
						<input class="form-control" type="text" name="cd-phone" id="cd-phone" <?php if (isset($_SESSION['marbel_user']['phone'])) { echo 'value="'.$_SESSION['marbel_user']['phone'].'"'; } ?> placeholder="Phone Number" required>
					</div>
				</div>
			</div>
			<div class="form-group" style="height:54px">
				<div class="row-fluid">
					<div class="col-md-12">
						<textarea class="form-control" name="cd-notes" id="cd-notes" placeholder="Notes"><?php if (isset($_SESSION['marbel_user']['email'])) { echo $_SESSION['marbel_user']['notes']; } ?></textarea>
					</div>
				</div>
			</div>

			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-offset-10 col-md-2">
						<input class="btn btn-success" type="submit" value="Update"> 
					</div>
				</div>
			</div>
		</form>
	</section>
</section>
