<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])  || $_SESSION['type'] != 'admin') {
	header('Location: login.php



');
}



// getting the no of users
$query_users = "SELECT COUNT(id) AS no_of_users FROM tbl_user WHERE is_deleted=0 AND type='user' ";
$users = mysqli_query($connection, $query_users);

verify_query($users);
$result_user = mysqli_fetch_assoc($users);
$no_of_users = $result_user['no_of_users'];

// getting the no of staff
$query_staff = "SELECT COUNT(id) AS no_of_staff FROM tbl_user WHERE is_deleted=0 AND type='staff' ";
$staff = mysqli_query($connection, $query_staff);

verify_query($staff);
$result_staff = mysqli_fetch_assoc($staff);
$no_of_staff = $result_staff['no_of_staff'];

// getting the no of inquiries
$query_inquiries = "SELECT COUNT(inquiry_id) AS no_of_inquiries FROM tbl_inquiry";
$inquiries = mysqli_query($connection, $query_inquiries);

verify_query($inquiries);
$result_inquiries = mysqli_fetch_assoc($inquiries);
$no_of_inquiries = $result_inquiries['no_of_inquiries'];

// getting the no of solved
$query_solved = "SELECT COUNT(inquiry_id) AS no_of_solved FROM tbl_inquiry WHERE inquiry_status='solved'";
$solved = mysqli_query($connection, $query_solved);

verify_query($solved);
$result_solved = mysqli_fetch_assoc($solved);
$no_of_solved = $result_solved['no_of_solved'];



?>


<!DOCTYPE html>
<html>

<head>
	<title>TSMS</title>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<?php display_sidebar($_SESSION['type']); ?>
	<?php display_header(); ?>
	<main>
		<div class="content">
			<h1>Dashboard</h1>

			<div class="card-group">
				<a href="./users.php">
					<div class="card">
						<div class="container">
							<h1><b><?= $no_of_users ?></b></h1>
							<p>Users</p>
						</div>
					</div>
				</a>

				<a href="./staff.php">
					<div class="card">
						<div class="container">
							<h1><b><?= $no_of_staff ?></b></h1>
							<p>Staff</p>
						</div>
					</div>
				</a>
				<a href="./inquries.php">
					<div class="card">
						<div class="container">
							<h1><b><?= $no_of_inquiries ?></b></h1>
							<p>Inquires</p>
						</div>
					</div>
				</a>

				<a href="./inquries.php">
					<div class="card">
						<div class="container">
							<h1><b><?= $no_of_solved ?></b></h1>
							<p>Solved</p>
						</div>
					</div>
				</a>
			</div>
		</div>
	</main>
	<script src="js/sidebar.js"></script>

	<?php display_footer(); ?>
</body>



</html>