<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

$errors = array();
$user_id = '';
$first_name = '';
$last_name = '';
$email = '';

if (isset($_GET['user_id'])) {
	// getting the user information
	$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
	$query = "SELECT * FROM tbl_user WHERE id = {$user_id} LIMIT 1";

	$result_set = mysqli_query($connection, $query);

	if ($result_set) {
		if (mysqli_num_rows($result_set) == 1) {
			// user found
			$result = mysqli_fetch_assoc($result_set);
			$first_name = $result['first_name'];
			$last_name = $result['last_name'];
			$email = $result['email'];
		} else {
			// user not found
			header('Location: dashboard.php?err=user_not_found');
		}
	} else {
		// query unsuccessful
		header('Location: dashboard.php?err=query_failed');
	}
}

if (isset($_POST['submit'])) {
	$user_id = $_POST['user_id'];
	$password = $_POST['password'];

	// checking required fields
	$req_fields = array('user_id', 'password');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('password' => 40);
	$errors = array_merge($errors, check_max_len($max_len_fields));

	if (empty($errors)) {
		// no errors found... adding new record
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = sha1($password);

		$query = "UPDATE tbl_user SET ";
		$query .= "password = '{$hashed_password}' ";
		$query .= "WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			// query successful... redirecting to users page
			if ($_POST['user_id'] == $_SESSION['user_id']) {
				header("location: profile.php?user_id={$_SESSION['user_id']}");
			} else {
				header("location: modify-user.php?user_id={$user_id}");
			}
		} else {
			$errors[] = 'Failed to update the password.';
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
	<?php display_sidebar($_SESSION['type']); ?>
	<?php display_header(); ?>

	<main>
		<div class="content">
			<h1>Change Password</h1>

			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			?>

			<form action="change-password.php" method="post" class="userform">
				<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
				<p>
					<label for="">First Name:</label>
					<input type="text" name="first_name" <?php echo 'value="' . $first_name . '"'; ?> disabled>
				</p>

				<p>
					<label for="">Last Name:</label>
					<input type="text" name="last_name" <?php echo 'value="' . $last_name . '"'; ?> disabled>
				</p>

				<p>
					<label for="">Email Address:</label>
					<input type="text" name="email" <?php echo 'value="' . $email . '"'; ?> disabled>
				</p>

				<p>
					<label for="">New Password:</label>
					<input type="password" name="password" id="password">
				</p>

				<p>
					<label for="">Show Password:</label>
					<input type="checkbox" name="showpassword" id="showpassword" onclick="showPassword()" style="width:20px;height:20px">
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Update Password</button>
				</p>

			</form>
		</div>
	</main>

	<script>
		// show password js script
		function showPassword() {
			var x = document.getElementById("password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>
	<?php display_footer(); ?>
</body>



</html>