<?php

$templates = get_templates(get_mandrill());
if (isset($_POST['to'])) {
	$toArr = explode(',', $_POST['to']);
	$to = '';
	foreach ($toArr as $usrs) {
		if (empty(trim($usrs))) { continue; }
		if (!empty($to)) { $to .= ', '; }
		$to .= trim($usrs);
	}
}

if (isset($_POST['template-only'])) {
	$users = getUserEmailData($to, $db);
	$subject = $_POST['subject'];
	if (!empty($users)) {
		try {
			$result = sendTemplateEmail($_POST['template'], $users, $subject);
		} catch (Mandrill_Error $e) {
			$error = get_class($e) . ' - ' . $e->getMessage();
		}
	}
} else if (isset($_POST['body-only'])) {
	$users = getUserEmailData($to, $db);
	$subject = $_POST['subject'];
	$body = $_POST['body'];
	if (!empty($users)) {
		try {
			$result = sendTemplateBodyEmail($_POST['template'], $users, $subject, $body);
		} catch (Mandrill_Error $e) {
			$error = get_class($e) . ' - ' . $e->getMessage();
		}
	}
}

if (isset($_POST['custom_filters_country'], $_POST['custom_filters_start_date'], $_POST['custom_filters_end_date'], $_POST['custom_filters_status'])) {
	$country = $_POST['custom_filters_country'];
	$start_date = $_POST['custom_filters_start_date'];
	$end_date = $_POST['custom_filters_end_date'];
	$status = $_POST['custom_filters_status'];
	$emails = getEmails($country, $start_date, $end_date, $status, $db);
}
?>

<section id="main-content">
	<section class="wrapper">
		<?php if (isset($users) && empty($users)) { echo '<div class="alert alert-warning">We could not find any users with the names or emails of <b>'.$_POST['to'].'</b></div>'; } ?>
		<?php if (isset($result)) { echo '<div class="alert alert-success">Email has been sent to '.sizeof($result).' users</div>'; } ?>
		<?php if (isset($error)) { echo '<div class="alert alert-success">There was a problem sending out the email:<br /> '.$error.'</div>'; } ?>
		<form action="" method="post">				
			<legend>Retrieve Email List</legend>
			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<select class="form-control" name="custom_filters.country">
							<option value="">Please select a country</option>
							<option value="US">United States</option>
							<option value="INTL">International</option>
						</select>
					</div>
					<div class="col-md-6">
						<select class="form-control" name="custom_filters.status">
							<option value="">Please select a status</option>
							<option value="deposit">Deposit Paid</option>
							<option value="balance">Balance Paid</option>
							<option value="building">Building</option>
							<option value="qa">Quality Assurance</option>
							<option value="shipping">Shipping</option>
                            <option value="shipped">Shipped</option>
							<option value="refunded">Refunded</option>
							<option value="all_waiting">All Waiting</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<input type="date" class="form-control" name="custom_filters.start_date">
					</div>
					<div class="col-md-6">
						<input type="date" class="form-control" name="custom_filters.end_date">
					</div>
				</div>
			</div>
			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-offset-10 col-md-2">
						<input class="btn btn-success" type="submit"> 
					</div>
				</div>
			</div>
		</form>

		<?php if (isset($emails)) : ?> 
			<p>Emails based upon your search (Country: <?php echo $_POST['custom_filters_country']; ?>, <?php echo $_POST['custom_filters_start_date'].' to '. $_POST['custom_filters_end_date']; ?>, Status: <?php echo $_POST['custom_filters_status']; ?>)</p>
			<pre>
				<code><?php $i = 0; $str = '';foreach ($emails as $email) { if (empty($email)) { continue; } if ($i > 0) { $str .=  ', '; }  $str .= $email; $i += 1; } echo trim($str); ?></code>
			</pre>
		<?php endif; ?>

		<form method="POST" onsubmit="return postForm()">
			<legend>Send Template</legend>
			<input type="hidden" name="template-only" id="template-only" value="true">

			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<select id="template" class="form-control" name="template">
							<option>Please select a template...</option>
							<?php foreach ($templates as $template): ?>
								<option value="<?php echo $template['slug']; ?>"><?php echo $template['name']; ?> (Sends from email address: <?php echo $template['from_email'] ?>)</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-6">
						<input class="form-control" type="text" name="subject" id="subject" placeholder="Subject Line" required="">
					</div>
				</div>
			</div>

			<div class="form-group" style="height:54px">
				<div class="row-fluid">
					<div class="col-md-12">
						<textarea class="form-control" name="to" id="to" placeholder="To" required=""></textarea>
					</div>
				</div>
			</div>

			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-offset-10 col-md-2">
						<input class="btn btn-success" type="submit"> 
					</div>
				</div>
			</div>
		</form>

		<form method="POST" onsubmit="return postForm()">
			<legend>Compose Email</legend>
			<input type="hidden" name="body-only" id="body-only" value="true">

			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-6">
						<select id="template" class="form-control" name="template">
							<option>Please select a template...</option>
							<?php foreach ($templates as $template): ?>
								<option value="<?php echo $template['slug']; ?>"><?php echo $template['name']; ?> (Sends from email address: <?php echo $template['from_email'] ?>)</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-6">
						<input class="form-control" type="text" name="subject" id="subject" placeholder="Subject Line" required="">
					</div>
				</div>
			</div>

			<div class="form-group" style="height:54px">
				<div class="row-fluid">
					<div class="col-md-12">
						<textarea class="form-control" name="to" id="to" placeholder="To" required=""></textarea>
					</div>
				</div>
			</div>

			<div class="form-group" style="height:360px">
				<div class="row-fluid">
					<div class="col-md-12">
						<textarea class="summernote" id="body" name="body" placeholder="Body Content"></textarea>
					</div>
				</div>
			</div>
			<div class="form-group" style="height:30px">
				<div class="row-fluid">
					<div class="col-md-offset-10 col-md-2">
						<input class="btn btn-success" type="submit"> 
					</div>
				</div>
			</div>
		</form>
	</section>