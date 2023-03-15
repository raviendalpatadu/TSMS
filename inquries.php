<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

$inquiry_list = '';
$query = '';

// getting the list of inquries of the user
if ($_SESSION['type'] == 'user') {
	//query eka gahanna && accet eka dannada staff ekek
	$query = "SELECT a.first_name as staff_name, tbl_inquiry.inquiry_type, tbl_inquiry.inquiry_status, a.*, tbl_inquiry.* ";
	$query .= "FROM tbl_inquiry ";
	$query .= "JOIN tbl_user ON ";
	$query .= "tbl_inquiry.user_fk = tbl_user.id ";
	$query .= "LEFT JOIN tbl_user a ON ";
	$query .= "tbl_inquiry.staff_fk = a.id OR tbl_inquiry.staff_fk = null ";
	$query .= "WHERE tbl_inquiry.user_fk = {$_SESSION['user_id']}";
	$inquiries = mysqli_query($connection, $query);

	verify_query($inquiries);

	while ($inquiry = mysqli_fetch_assoc($inquiries)) {
		$inquiry_list .= "<tr>";
		$inquiry_list .= "<td>{$inquiry['staff_name']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_type']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_description']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_date']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_status']}</td>";
		$inquiry_list .= "<td><a href=\"modify-inquiry.php?inquiry_id={$inquiry['inquiry_id']}\">More</a></td>";
		$inquiry_list .= "</tr>";
	}
}

// getting the list of inquries of the staff
if ($_SESSION['type'] == 'staff') {

	$query = "SELECT tbl_inquiry.inquiry_id, tbl_user.first_name as user_name,  tbl_inquiry.inquiry_type, tbl_inquiry.inquiry_date, tbl_inquiry.inquiry_description ";
	$query .= "FROM tbl_inquiry ";
	$query .= "JOIN tbl_user ON ";
	$query .= "tbl_inquiry.user_fk = tbl_user.id ";
	$query .= "LEFT JOIN tbl_user a ON ";
	$query .= "tbl_inquiry.staff_fk = a.id ";
	$query .= "WHERE tbl_inquiry.staff_fk IS NULL; ";

	$inquiries = mysqli_query($connection, $query);

	verify_query($inquiries);

	while ($inquiry = mysqli_fetch_assoc($inquiries)) {
		$inquiry_list .= "<tr>";
		$inquiry_list .= "<td>{$inquiry['user_name']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_type']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_description']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_date']}</td>";
		$inquiry_list .= "<td><a href=\"accept-inquiry.php?inquiry_id={$inquiry['inquiry_id']}\">Accept</a></td>";
		$inquiry_list .= "</tr>";
	}
}

// getting the list of inquries of the admin
if ($_SESSION['type'] == 'admin') {
	$query = "SELECT tbl_inquiry.inquiry_id, tbl_user.first_name as userName, a.first_name as staffName, tbl_inquiry.inquiry_type, tbl_inquiry.inquiry_status ";
	$query .= "FROM tbl_inquiry ";
	$query .= "JOIN tbl_user ON ";
	$query .= "tbl_inquiry.user_fk = tbl_user.id ";
	$query .= "LEFT JOIN tbl_user a ON ";
	$query .= "tbl_inquiry.staff_fk = a.id OR tbl_inquiry.staff_fk = null;";
	$inquiries = mysqli_query($connection, $query);

	verify_query($inquiries);

	while ($inquiry = mysqli_fetch_assoc($inquiries)) {
		$inquiry_list .= "<tr>";
		$inquiry_list .= "<td>{$inquiry['inquiry_type']}</td>";
		$inquiry_list .= "<td>{$inquiry['userName']}</td>";
		$inquiry_list .= "<td>{$inquiry['staffName']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_status']}</td>";
		$inquiry_list .= "<td><a href=\"modify-inquiry.php?inquiry_id={$inquiry['inquiry_id']}\">More</a></td>";
		$inquiry_list .= "</tr>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Users</title>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<?php display_sidebar($_SESSION['type']); ?>
	<?php display_header(); ?>

	<main>
		<div class="content">
			<h1>Inquries</h1>

			<table class="masterlist">
				<?php
				if ($_SESSION['type'] ==  "admin") {
					echo "<tr>
							<th>Inqury Type</th>
							<th>User Name</th>
							<th>Staff Member Name</th>
							<th>Inqury Status</th>
							<th>More</th>	
						</tr>";
				}
				if ($_SESSION['type'] ==  "staff") {
					echo "<tr>
							<th>User Name</th>
							<th>Inqury Type</th>
							<th>Inquiry Description</th>
							<th>Inqurry date</th>
							<th>Accept</th>	
						</tr>";
				}
				if ($_SESSION['type'] ==  "user") {
					echo "<tr>
							<th>Staff Name</th>
							<th>Inquiry Type</th>
							<th>Inquiry Description</th>
							<th>Inqurry date</th>
							<th>Inqurry Status</th>
							<th>More</th>	
						</tr>";
				}
				?>

				<?php echo $inquiry_list; ?>

			</table>
		</div>

	</main>
	<?php display_footer(); ?>
</body>



</html>