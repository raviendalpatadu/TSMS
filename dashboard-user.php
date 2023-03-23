<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

// getting the no of unsolved
$query_unsolved = "SELECT COUNT(inquiry_id) AS no_of_unsolved FROM tbl_inquiry WHERE user_fk={$_SESSION['user_id']} AND inquiry_status != 'solved' ";
$unsolved = mysqli_query($connection, $query_unsolved);

verify_query($unsolved);
$result_user = mysqli_fetch_assoc($unsolved);
$no_of_unsolved = $result_user['no_of_unsolved'];

// getting the no of solved
$query_solved = "SELECT COUNT(inquiry_id) AS no_of_solved FROM tbl_inquiry WHERE user_fk={$_SESSION['user_id']} AND inquiry_status = 'solved' ";
$solved = mysqli_query($connection, $query_solved);

verify_query($solved);
$result_solved = mysqli_fetch_assoc($solved);
$no_of_solved = $result_solved['no_of_solved'];

?>


<!DOCTYPE html>
<html>

<head>
	<title>Tech Support</title>
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
							<h1><b><?= $no_of_unsolved ?></b></h1>
							<p>Unsolved Inquires</p>
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
					<a href="add-inquiry.php">
						<div class="card card-user-width">
							<div class="container">
								<h1><b>+</b></h1>
								<p>Create Inquiry</p>
							</div>
						</div>
					</a>
				</div>
				<div class="column col-center">
					<a href="inquries.php">
						<div class="card card-user-width">
							<div class="container">
								<h1><b>?</b></h1>
								<p>Your Inquires</p>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</main>

	<!-- <div class="container-main">
		<div class="row-main">
			<div class="column-main-left">
				<?php // display_sidebar($_SESSION['type']); 
				?>
			</div>
			<div class="column-main-right">
				<?php // display_header(); 
				?>
				<main>
					<div class="content">
						<h1>Dashboard</h1>

						<div class="row mb-1">
							<div class="column col-center">
								<div class="card card-user-width">
									<div class="container">
										<h1><b><?php //$no_of_unsolved 
												?></b></h1>
										<p>Unsolved Inquires</p>
									</div>
								</div>
							</div>
							<div class="column col-center">
								<div class="card card-user-width">
									<div class="container">
										<h1><b><?php //$no_of_solved 
												?></b></h1>
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
											<h1><b>+</b></h1>
											<p>Create Inquiry</p>
										</div>
									</div>
								</a>
							</div>
							<div class="column col-center">
								<a href="add-inquries.php">
									<div class="card card-user-width">
										<div class="container">
											<h1><b>?</b></h1>
											<p>Your Inquires</p>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
	</div> -->
	<script src="js/sidebar.js"></script>

<?php display_footer(); ?>
</body>



</html>