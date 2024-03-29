<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
}

$user_list = '';

// getting the list of users
$query = "SELECT * FROM tbl_user WHERE is_deleted=0 AND type='staff' ORDER BY first_name";
$users = mysqli_query($connection, $query);

verify_query($users);

while ($user = mysqli_fetch_assoc($users)) {
	$user_list .= "<tr>";
	$user_list .= "<td>{$user['first_name']}</td>";
	$user_list .= "<td>{$user['last_name']}</td>";
	$user_list .= "<td>{$user['last_login']}</td>";
	$user_list .= "<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
	$user_list .= "<td><a href=\"delete-user.php?user_id={$user['id']}\">Delete</a></td>";
	$user_list .= "</tr>";
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
			<h1>Staff</h1>

			<table class="masterlist">
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Last Login</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>

				<?php echo $user_list; ?>

			</table>
		</div>

	</main>
<?php display_footer(); ?>
</body>



</html>