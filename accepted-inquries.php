<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

$errors = array();
$inquiry_list = '';
$query = '';


// getting the list of accepted inquries of the staff member
if ($_SESSION['type'] == 'staff') {
	// $query = "SELECT i.*, u.first_name as user_name FROM tbl_inquiry i, tbl_user u WHERE u.id = i.staff_fk AND i.staff_fk ={$_SESSION['user_id']} ORDER BY inquiry_type";
	
	$query = "SELECT tbl_inquiry.inquiry_id, tbl_user.first_name as user_name,  tbl_inquiry.inquiry_type, tbl_inquiry.inquiry_date, tbl_inquiry.inquiry_description ";
	$query .= "FROM tbl_inquiry ";
	$query .= "JOIN tbl_user ON ";
	$query .= "tbl_inquiry.user_fk = tbl_user.id ";
	$query .= "LEFT JOIN tbl_user a ON ";
	$query .= "tbl_inquiry.staff_fk = a.id ";
	$query .= "WHERE tbl_inquiry.staff_fk = {$_SESSION['user_id']} AND tbl_inquiry.inquiry_status = 'Member Accepted'; ";
	
	$inquiries = mysqli_query($connection, $query);

	verify_query($inquiries);

	while ($inquiry = mysqli_fetch_assoc($inquiries)) {
		$inquiry_list .= "<tr>";
		$inquiry_list .= "<td>{$inquiry['user_name']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_type']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_description']}</td>";
		$inquiry_list .= "<td>{$inquiry['inquiry_date']}</td>";
		$inquiry_list .= "<td><a href=\"solved-inquiry.php?inquiry_id={$inquiry['inquiry_id']}\">Solved</a></td>";
		$inquiry_list .= "</tr>";
	}
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Tech Support</title>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	
	<?php display_sidebar($_SESSION['type']); ?>
	<?php display_header();?>
	<main>
		<div class="content">
			<h1>Accepted Inquries</h1>
			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			if (isset($_GET['email'])) {
				if($_GET['email'] == 'false'){
					echo '<p class="error">Failed to send notification</p>
					';
				}
			}

			?>
			<table class="masterlist">
				<?php 
					if ($_SESSION['type'] ==  "staff") {
						echo "<tr>
							<th>User Name</th>
							<th>Inqury Type</th>
							<th>Inquiry Description</th>
							<th>Inqurry date</th>
							<th>Solved</th>	
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