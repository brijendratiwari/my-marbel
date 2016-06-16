<?php
if (isset($_POST['cd-submit'])) {
	
}

if (isset($_GET['status'])) {
	$status = $_GET['status'];
} else {
	$status = 'finished';
}
?>

<section id="main-content">
	<section class="wrapper" style="padding-top:20px;">
		<div id="msg" class="alert" style="display: none;"></div>

		<div class="row-fluid" style="text-align:center;">
			<a href="?status=pending" class="btn btn-success m-b-sm">Pending</a>
			<a href="?status=inhouse" class="btn btn-success m-b-sm">In House</a>
			<a href="?status=finished" class="btn btn-success m-b-sm">Finished</a>
		</div>
		<?php  if (strcmp($status, 'finished') == 0) :?>
			<table id="finished" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td></td>
						<td>First Name</td>
						<td>Last Name</td>
						<td>Finished Date</td>
						<td>Tracking Number</td>
						<td>Service Status</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		<?php  elseif (strcmp($status, 'inhouse') == 0) :?>
			<table id="inhouse" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td></td>
						<td>First Name</td>
						<td>Last Name</td>
						<td>Check in Date</td>
						<td>Priority</td>
						<td>Due Date</td>
						<td>Service Status</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		<?php  elseif (strcmp($status, 'pending') == 0) :?>
			<table id="pending" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td></td>
						<td>First Name</td>
						<td>Last Name</td>
						<td>Created Date</td>
						<td>Response</td>
						<td>Inbound Tracking</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		<?php endif; ?>
	</section>
</section>