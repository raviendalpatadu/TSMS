<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 


if (isset($_GET['user_id'])) {
	$id = $_GET['user_id'];
	$query = "UPDATE tbl_user SET is_deleted = 1 WHERE id={$id} LIMIT 1 ";
	$result_set = mysqli_query($connection, $query);
	verify_query($result_set);
	if ($result_set) {
		header('Location: users.php');
	} else {
		echo "<h1>Query Unsuccessful</h1>";
	}
}
mysqli_close($connection); 
?>