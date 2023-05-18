<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php


$errors = array();
$first_name = '';
$last_name = '';
$email = '';
$password = '';

if (isset($_POST['submit'])) {

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$user_type = $_POST['user_type'];

	// check to passwords match
	if ($confirm_password != $password){
		$errors[] = 'Passwords doesn\'t match.';
	}

	// checking required fields
	$req_fields = array('first_name', 'last_name', 'email', 'password', 'user_type');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('first_name' => 50, 'last_name' => 100, 'email' => 100, 'password' => 40);
	$errors = array_merge($errors, check_max_len($max_len_fields));

	// checking email address
	if (!is_email($_POST['email'])) {
		$errors[] = 'Email address is invalid.';
	}

	// checking if email address already exists
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$query = "SELECT * FROM tbl_user WHERE email = '{$email}' LIMIT 1";

	$result_set = mysqli_query($connection, $query);
	verify_query($result_set);

	if ($result_set) {
		if (mysqli_num_rows($result_set) == 1) {
			$errors[] = 'Email address already exists';
		}
	}

	if (empty($errors)) {
		// no errors found... adding new record
		$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
		$user_type = mysqli_real_escape_string($connection, $_POST['user_type']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		$confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);
		
		

		// email address is already sanitized
		$hashed_password = sha1($password);

		$query = "INSERT INTO tbl_user ( ";
		$query .= "first_name, last_name, email, password, is_deleted, type";
		$query .= ") VALUES (";
		$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0, '{$user_type}'";
		$query .= ")";

		$result = mysqli_query($connection, $query);
		verify_query($result);

		if ($result) {
			// query successful... redirecting to users page
			header('Location: dashboard.php?user_added=true');
		} else {
			$errors[] = 'Failed to add the new record.';
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
	
	<?php 
	if(isset($_SESSION['type'])){
		display_sidebar($_SESSION['type']); 
	}
	?>
	<?php display_header(); ?>
	<main>
		<div class="content">
			<h1>Add New User</h1>

			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			?>
	
			<form action="add-user.php" method="post" class="userform">

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
					<label for="">Password:</label>
					<input type="password" name="password">
				</p>

				<p>
					<label for="">Confirm Password:</label>
					<input type="password" name="confirm_password">
				</p>


				<?php
				if (isset($_SESSION['type'])) {
					echo '<p>
								<label for="">User Type:</label>
								<select name="user_type">
									<option value="admin">Admin</option> <!-- user means a typical customer-->
									<option value="user">User</option> <!-- user means a typical customer-->
									<option value="staff">Staff</option>
								</select>
							</p>';
				} else {
					echo '<input type="hidden" name="user_type" value="user"></input>';
				}
				?>


				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Save</button>
				
					<a href="./login.php" style="margin-left: 4rem;">Back</a>
				</p>

			</form>



		</div>
	</main>
	<script src="js/sidebar.js"></script>

<?php display_footer(); ?>
</body>



</html>