<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

$errors = array();
$inquiry_id = '';
$staff_id = '';
$user_name = '';
$staff_name = '';
$inquiry_description = '';
$inquiry_type = '';
$inquiry_date = '';

if (isset($_GET['inquiry_id'])) {
	// getting the inquiry information
	$inquiry_id = mysqli_real_escape_string($connection, $_GET['inquiry_id']);
	$query = "SELECT tbl_inquiry.inquiry_id, tbl_user.first_name as user_name, a.first_name as staff_name, ";
	$query .= "tbl_inquiry.staff_fk, tbl_inquiry.inquiry_type, tbl_inquiry.inquiry_date, tbl_inquiry.inquiry_description, tbl_inquiry.inquiry_status ";
	$query .= "FROM tbl_inquiry ";
	$query .= "JOIN tbl_user ON ";
	$query .= "tbl_inquiry.user_fk = tbl_user.id ";
	$query .= "LEFT JOIN tbl_user a ON ";
	$query .= "tbl_inquiry.staff_fk = a.id OR tbl_inquiry.staff_fk = null ";
	$query .= "WHERE tbl_inquiry.inquiry_id = {$inquiry_id}";
	$result_set = mysqli_query($connection, $query);
	verify_query($result_set);

	if ($result_set) {
		if (mysqli_num_rows($result_set) == 1) {
			// inquiry found
			$result = mysqli_fetch_assoc($result_set);
			$user_name = $result['user_name'];
			$staff_name = $result['staff_name'];
			$inquiry_description = $result['inquiry_description'];
			$inquiry_type = $result['inquiry_type'];
			$inquiry_date = $result['inquiry_date'];
			$inquiry_status = $result['inquiry_status'];
			$staff_id = $result['staff_fk'];
		} else {
			// inquiry not found
			header('Location: inquries.php?err=inquiry_not_found');
		}
	} else {
		// query unsuccessful
		header('Location: inquries.php?err=query_failed');
	}
}

// if a user submits
if (isset($_POST['submit']) && $_SESSION['type'] == 'user') {

	$inquiry_id = $_POST['inquiry_id'];
	$inquiry_type = $_POST['inquiry_type'];
	$inquiry_description = $_POST['inquiry_description'];

	// checking required fields
	$req_fields = array('inquiry_id', 'inquiry_type', 'inquiry_description');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('inquiry_type' => 30, 'inquiry_description' => 1000000);
	$errors = array_merge($errors, check_max_len($max_len_fields));



	if (empty($errors)) {
		// no errors found... adding new record
		$inquiry_id = mysqli_real_escape_string($connection, $_POST['inquiry_id']);
		$inquiry_type = mysqli_real_escape_string($connection, $_POST['inquiry_type']);
		$inquiry_description = mysqli_real_escape_string($connection, $_POST['inquiry_description']);

		$query = "UPDATE tbl_inquiry SET ";
		$query .= "inquiry_type = '{$inquiry_type}', ";
		$query .= "inquiry_description = '{$inquiry_description}' ";
		$query .= "WHERE inquiry_id = {$inquiry_id} LIMIT 1";

		$result = mysqli_query($connection, $query);
		verify_query($result);

		if ($result) {
			// query successful... redirecting to inquirys page
			header("Location: modify-inquiry.php?inquiry_id={$inquiry_id}&inquiry_modified=true");
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
	<title>View / Modify inquiry</title>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	
	<?php display_sidebar($_SESSION['type']); ?>
	<?php display_header(); ?>
	<main>
		<div class="content">
			<h1>View / Modify Inquiry</h1>

			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			?>

			<form action="modify-inquiry.php" method="post" class="userform">
				<input type="hidden" name="inquiry_id" value="<?php echo $inquiry_id; ?>">
				<p>
					<label for="">User Name:</label>
					<input type="text" name="user_name" <?php echo 'value="' . $user_name . '"';
														if ($_SESSION['type'] == "admin" || $_SESSION['type'] == "user") {
															echo "disabled";
														} ?>>
				</p>

				<p>
					<label for="">Staff Name:</label>
					<input type="text" name="staff_name" <?php echo 'value="' . $staff_name . '"';
															if ($_SESSION['type'] == "admin" || $_SESSION['type'] == "user") {
																echo "disabled";
															} ?>>

				</p>

				<p>
					<label for="">Inquiry Type:</label>
					<select name="inquiry_type" <?php
												if ($_SESSION['type'] == "admin") {
													echo "disabled";
												} ?>>
						<option value="type1" <?php if ($inquiry_type == 'type1') {
													echo "selected";
												} ?>>type1</option>
						<option value="type2" <?php if ($inquiry_type == 'type2') {
													echo "selected";
												} ?>>type2</option>
						<option value="type3" <?php if ($inquiry_type == 'type3') {
													echo "selected";
												} ?>>type3</option>
					</select>
				</p>


				<p>
					<label for="">Inquiry Description:</label>
					<textarea type="text" name="inquiry_description" <?php
																		if ($_SESSION['type'] == "admin") {
																			echo "disabled";
																		} ?>> <?= $inquiry_description ?></textarea>
				</p>

				<p>
					<label for="">Inquiry Date:</label>
					<input type="text" name="inquiry_type" <?php echo 'value="' . $inquiry_date . '"';
															if ($_SESSION['type'] == "admin" || $_SESSION['type'] == "user") {
																echo "disabled";
															} ?>>
				</p>

				<p>
					<label for="">Inquiry Status:</label>
					<input type="text" name="inquiry_status" <?php echo 'value="' . $inquiry_status . '"';
																if ($_SESSION['type'] == "admin" || $_SESSION['type'] == "user") {
																	echo "disabled";
																} ?>>
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit" <?php if ($_SESSION['type'] == "admin") {
															echo "disabled";
														}
														?>>Save</button>
				</p>

			</form>



		</div>

	</main>
<?php display_footer(); ?>
</body>



</html>