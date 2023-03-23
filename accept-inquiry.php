<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id']) && $_SESSION['type'] != 'staff') {
	header('Location: login.php');
}

$errors = array();
$inquiry_id = '';
$staff_id = '';
$status = '';

if (isset($_GET['inquiry_id']) && $_SESSION['type'] == 'staff') {
	$inquiry_id = mysqli_real_escape_string($connection, $_GET['inquiry_id']);
	$staff_id = $_SESSION['user_id'];

	$query = "UPDATE tbl_inquiry SET ";
	$query .= "staff_fk = '{$staff_id}', inquiry_status = 'Member Accepted' ";
	$query .= "WHERE inquiry_id = {$inquiry_id} LIMIT 1";

	$result = mysqli_query($connection, $query);
	verify_query($result);

	if ($result) {
		// query successful... 
		// sending notification
		$query = "SELECT tbl_inquiry.inquiry_id, tbl_user.email as user_name ";
		$query .= "FROM tbl_inquiry ";
		$query .= "JOIN tbl_user ON ";
		$query .= "tbl_inquiry.user_fk = tbl_user.id ";
		$query .= "LEFT JOIN tbl_user a ON ";
		$query .= "tbl_inquiry.staff_fk = a.id ";
		$query .= "WHERE tbl_inquiry.staff_fk = {$staff_id} AND tbl_inquiry.inquiry_id = {$inquiry_id}; ";

		$result_set = mysqli_query($connection, $query);
		verify_query($result_set);

		if (mysqli_num_rows($result_set) == 1) {
			// email address found sending mail.
			$data = mysqli_fetch_assoc($result_set);
			
			$username = $data['user_name'];
			$to	 		  = $username;
			$mail_subject = 'TECH SUPPORT - Inquiry Accepted';
			$email_body   = "Your new inquriy({$inquiry_id}) has been accepted. <br> Login to your account for more info.";
	
			$header       = "From: {$username}\r\nContent-Type: text/html;";
	
			$send_mail_result = mail($to, $mail_subject, $email_body, $header);
	
			if ($send_mail_result) {
				
				// redirecting to inquirys page
				header("Location: accepted-inquries.php?inquiry_accepted=true&email=true");
			} else {
				$errors[] = 'Error: Message Was Not Sent.';
				header("Location: accepted-inquries.php?inquiry_accepted=true&email=false");
			}
		}{
			$errors[] = "couldnt find email address.";
		}

	} else {
		$errors[] = 'Failed to accept the inquiry.';
	}
}


?>
