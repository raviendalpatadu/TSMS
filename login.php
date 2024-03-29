<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

// check for form submission
if (isset($_POST['submit'])) {

	$errors = array();

	// check if the username and password has been entered
	if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1) {
		$errors[] = 'Username is Missing / Invalid';
	}

	if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1) {
		$errors[] = 'Password is Missing / Invalid';
	}

	// check if there are any errors in the form
	if (empty($errors)) {
		// save username and password into variables
		$email 		= mysqli_real_escape_string($connection, $_POST['email']);
		$password 	= mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = sha1($password);

		// prepare database query
		$query = "SELECT * FROM tbl_user 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		verify_query($result_set);

		if (mysqli_num_rows($result_set) == 1) {
			// valid user found
			$user = mysqli_fetch_assoc($result_set);
			
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['first_name'] = $user['first_name'];
			$_SESSION['type'] = $user['type'];
			// updating last login
			$query = "UPDATE tbl_user SET last_login = NOW() ";
			$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);

			// redirect to dashboard.php
			if ($user['type'] == 'admin') {
				header('Location: dashboard.php');
			}
			if ($user['type'] == 'user') {
				header('Location: dashboard-user.php');
			}
			if ($user['type'] == 'staff') {
				header('Location: dashboard-staff.php');
			}
		} else {
			// user name and password invalid
			$errors[] = 'Invalid Username / Password';
		}
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
	<div class="login">
		<div class="login-img img-gradient">
			<img src="img/login-left.png" alt="login">
		</div>
		<div class="login-form">
			<form action="login.php" method="post">
				<div class="login-logo">
					<img src="./img/logo.png" alt="" srcset="">
				</div>
				<h1>Log In</h1>

				<?php
				if (isset($errors) && !empty($errors)) {
					echo '<p class="error">Invalid Username / Password</p>
						<p><a href="./forget-password.php">Forget Password?</a></p>
					';
				}
				?>

				<?php
				if (isset($_GET['logout'])) {
					echo '<p class="info">You have successfully logged out from the system</p>';
				}
				?>

				<p>
					<label for="">Username:</label>
					<input type="text" name="email" id="" placeholder="Email Address">
				</p>

				<p>
					<label for="">Password:</label>
					<input type="password" name="password" id="" placeholder="Password">
				</p>

				<p>
					<button type="submit" name="submit">Log In</button>
				</p>

				<p>
					<a href="add-user.php">Make Account</a>

					<span style="float:right">
						<a href="./index.php">Home</a>
					</span>
				</p>


			</form>
		</div>

	</div> <!-- .login -->
	<?php display_footer(); ?>
</body>


</html>
<?php mysqli_close($connection); ?>