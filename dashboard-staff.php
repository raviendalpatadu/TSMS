<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: index.php');
}

// getting the no of new_inqiries
$query_new_inqiries = "SELECT COUNT(inquiry_id) AS no_of_new_inqiries FROM tbl_inquiry WHERE inquiry_status = 'created' ";
$new_inqiries = mysqli_query($connection, $query_new_inqiries);

verify_query($new_inqiries);
$result_user = mysqli_fetch_assoc($new_inqiries);
$no_of_new_inqiries = $result_user['no_of_new_inqiries'];

// getting the no of solved
$query_solved = "SELECT COUNT(inquiry_id) AS no_of_solved FROM tbl_inquiry WHERE staff_fk={$_SESSION['user_id']} AND inquiry_status = 'solved' ";
$solved = mysqli_query($connection, $query_solved);

verify_query($solved);
$result_solved = mysqli_fetch_assoc($solved);
$no_of_solved = $result_solved['no_of_solved'];
?>


<!DOCTYPE html>
<html>

<head>
	<title>Simple Sidebar Example</title>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<?php display_sidebar($_SESSION['type']); ?>
	<?php display_header(); ?>
	<main>
		<div class="content">
			<h1>Dashboard</h1>

			<div class="row mb-1">
				<div class="column col-center">
					<div class="card card-user-width">
						<div class="container">
							<h1><b><?= $no_of_new_inqiries ?></b></h1>
							<p>New Inquires</p>
						</div>
					</div>
				</div>

				<div class="column col-center">
					<div class="card card-user-width">
						<div class="container">
							<h1><b><?= $no_of_solved ?></b></h1>
							<p>Solved Inquires</p>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="column col-center">
					<a href="inquries.php">
						<div class="card card-user-width">
							<div class="container">
								<h1><b>🆕</b></h1>
								<p>New Inquiries</p>
							</div>
						</div>
					</a>
				</div>
				<div class="column col-center">
					<a href="accepted-inquries.php">
						<div class="card card-user-width">
							<div class="container">
								<h1><b>✔️</b></h1>
								<p>Accepted Inquires</p>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</main>

	
	<script src="js/sidebar.js"></script>

<?php display_footer(); ?>
</body>



</html>