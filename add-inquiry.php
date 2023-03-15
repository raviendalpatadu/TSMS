<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

$errors = array();
$user_id = $_SESSION['user_id'];
$inquiry_type = '';
$inquiry_description = '';


if (isset($_POST['submit'])) {

	$inquiry_type = $_POST['inquiry_type'];
	$inquiry_description = trim($_POST['inquiry_description']);

	// checking required fields
	$req_fields = array('inquiry_type', 'inquiry_description');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('inquiry_type' => 30, 'inquiry_description' => 1000000);
	$errors = array_merge($errors, check_max_len($max_len_fields));


	if (empty($errors)) {
		// no errors found... adding new record
		$inquiry_type = mysqli_real_escape_string($connection, $_POST['inquiry_type']);
		$inquiry_description = mysqli_real_escape_string($connection, $_POST['inquiry_description']);

		$query = "INSERT INTO tbl_inquiry ( ";
		$query .= "user_fk, inquiry_type, inquiry_description, inquiry_status";
		$query .= ") VALUES (";
		$query .= " '{$user_id}', '{$inquiry_type}', '{$inquiry_description}', 'created'";
		$query .= ")";

		$result = mysqli_query($connection, $query);

		if ($result) {
			// query successful... redirecting to users page
			header('Location: inquries.php?inqury_added=true');
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
	<title>Add New User</title>
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<?php
	if (isset($_SESSION['type'])) {
		display_sidebar($_SESSION['type']);
	}
	?>
	<?php display_header(); ?>
	<main>
		<div class="content">
			<h1>Create Inquiry</h1>

			<?php

			if (!empty($errors)) {
				display_errors($errors);
			}

			?>

			<form action="add-inquiry.php" method="post" class="userform">

				<p>
					<label for="">Inquiry Type:</label>
					<select name="inquiry_type">
						<option value="High Priorty">High Priorty</option>
						<option value="Medium Priorty">Medium Priorty</option>
						<option value="Low Priorty">Low Priorty</option>
					</select>
				</p>

				<p>
					<label for="">Inquiry Description:</label>
					<textarea type="text" name="inquiry_description" <?php echo 'value="' . $inquiry_description . '"'; ?>>
					</textarea>
				</p>

				<p>
					<label for="">&nbsp;</label>
					<button type="submit" name="submit">Create Inquiry</button>
				</p>

			</form>

		</div>
	</main>
	<script src="js/sidebar.js"></script>

	<?php display_footer(); ?>
</body>



</html>