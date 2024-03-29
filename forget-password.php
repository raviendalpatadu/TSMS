<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php


$errors = array();

$status = '';



if (isset($_POST['submit'])) {
	// check if the username and password has been entered
	if (!isset($_POST['username']) || strlen(trim($_POST['username'])) < 1) {
		$errors[] = 'Username is Missing';
	}


	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$query = "SELECT * FROM tbl_user WHERE email = '{$username}'";
	$result = mysqli_query($connection, $query);
	verify_query($result);

	if (mysqli_num_rows($result) == 1) {
		// username found
		$length = 8;
		$string = rand();
    	$randomString = substr($string, 0, $length);
		
		$password = sha1($randomString);
		$query_update = "UPDATE tbl_user SET password ='{$password}' WHERE email='{$username}' LIMIT 1";
		$result_update = mysqli_query($connection, $query_update);
		verify_query($result_update);

		if ($result_update) {
			// send mail
			$to	 		  = $username;
			$mail_subject = 'TECH SUPPORT - Reset Password';
			$email_body   = "Your new password will be {$randomString}. <br> login and change it imediatly.";

			$header       = "From: {$username}\r\nContent-Type: text/html;";

			$send_mail_result = mail($to, $mail_subject, $email_body, $header);

			if ($send_mail_result) {
				$status = '<p class="info">Message Sent Successfully.</p>';
			} else {
				$status = '<p class="error">Error: Message Was Not Sent.</p>';
			}
		}

	}
	else{
		$errors[] = "User Not Found";	
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
	<?php if (isset($_SESSION['type'])) {
		display_sidebar($_SESSION['type']);
	} ?>
	<?php display_header(); ?>

	<main>
		<div class="content">
			<h1>Forget Password</h1>

			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			echo $status;

			?>

			<form action="forget-password.php" method="post" class="userform">

				<p>
					<label for="">Enter Username:</label>
					<input type="text" name="username" id="username">
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Send Link</button>
				
					<a href="./login.php" style="margin-left: 4rem;">Back</a>
				</p>
			
			</form>
		</div>
	</main>

	<?php display_footer(); ?>
</body>



</html>