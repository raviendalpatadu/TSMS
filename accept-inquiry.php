<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id']) && $_SESSION['type'] != 'staff') {
	header('Location: index.php');
}

$errors = array();
$inquiry_id = '';
$staff_id = '';


if (isset($_GET['inquiry_id']) && $_SESSION['type'] == 'staff') {
		$inquiry_id = mysqli_real_escape_string($connection, $_GET['inquiry_id']);
		$staff_id = $_SESSION['user_id'];

		$query = "UPDATE tbl_inquiry SET ";
		$query .= "staff_fk = '{$staff_id}', inquiry_status = 'Member Accepted' ";
		$query .= "WHERE inquiry_id = {$inquiry_id} LIMIT 1";

		$result = mysqli_query($connection, $query);
		verify_query($result);

		if ($result) {
			// query successful... redirecting to inquirys page
			header("Location: accepted-inquries.php?inquiry_accepted=true");
		} else {
			$errors[] = 'Failed to accept the inquiry.';
		}
}


?>
