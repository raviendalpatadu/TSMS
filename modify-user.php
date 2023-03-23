<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id']) ) {
	header('Location: login.php');
}

$errors = array();
$user_id = '';
$first_name = '';
$last_name = '';
$email = '';
$user_type = '';

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
			$user_type = $result['type'];
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
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$user_type = $_POST['user_type'];
	$email = $_POST['email'];

	// checking required fields
	$req_fields = array('user_id', 'first_name', 'last_name', 'email');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('first_name' => 50, 'last_name' => 100, 'email' => 100);
	$errors = array_merge($errors, check_max_len($max_len_fields));

	// checking email address
	if (!is_email($_POST['email'])) {
		$errors[] = 'Email address is invalid.';
	}

	// checking if email address already exists
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$query = "SELECT * FROM tbl_user WHERE email = '{$email}' AND id != {$user_id} LIMIT 1";

	$result_set = mysqli_query($connection, $query);

	if ($result_set) {
		if (mysqli_num_rows($result_set) == 1) {
			$errors[] = 'Email address already exists';
		}
	}

	if (empty($errors)) {
		// no errors found... adding new record
		$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
		// email address is already sanitized

		$query = "UPDATE tbl_user SET ";
		$query .= "first_name = '{$first_name}', ";
		$query .= "last_name = '{$last_name}', ";
		$query .= "email = '{$email}', ";
		$query .= "type = '{$user_type}' ";
		$query .= "WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);
		verify_query($result);

		if ($result) {
			// query successful... redirecting to users page
			header('Location: dashboard.php?user_modified=true');
		} else {
			$errors[] = 'Failed to modify the record.';
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
			<h1>View / Modify User</h1>

			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			?>

			<form action="modify-user.php" method="post" class="userform">
				<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
				<p>
					<label for="">First Name:</label>
					<input type="text" name="first_name" <?php echo 'value="' . $first_name . '"'; ?>>
				</p>

				<p>
					<label for="">Last Name:</label>
					<input type="text" name="last_name" <?php echo 'value="' . $last_name . '"'; ?>>
				</p>

				<p>
					<label for="">Email Address:</label>
					<input type="text" name="email" <?php echo 'value="' . $email . '"'; ?>>
				</p>

				<p>
					<label for="">User Type:</label>
					<!-- only admins can change user account types -->
					<select name="user_type" <?php if ($_SESSION['type'] != "admin") {
													echo "disabled";
												} ?>>
						<option value="admin" <?php if ($user_type == "admin") {
													echo "selected";
												} ?>>Admin</option>
						<option value="staff" <?php if ($user_type == "staff") {
													echo "selected";
												} ?>>Staff</option>
						<option value="user" <?php if ($user_type == "user") {
													echo "selected";
												} ?>>User</option>
					</select>
				</p>
				<p>
					<label for="">Password:</label>
					<span>******</span> | <a href="change-password.php?user_id=<?php echo $user_id; ?>">Change Password</a>
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Save</button>
				</p>

			</form>


			
		</div>

	</main>
<?php display_footer(); ?>
</body>



</html>