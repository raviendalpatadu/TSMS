<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Simple Sidebar Example</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
<header>
		<div class="appname">Technical Support Management System</div>
		<?php if (isset($_SESSION['user_id'])) {
			echo '<div class="loggedin">Welcome ' . $_SESSION['first_name'] . '! <a href="logout.php">Log Out</a></div>';
		} ?>
	</header>
	<?php display_sidebar($_SESSION['type']); ?>
	<main>
		<div class="content">
			<h1>Dashboard</h1>
		</div>
	</main>
	<script src="js/sidebar.js"></script>

</body>
</html>
