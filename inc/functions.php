	<?php

function display_header()
{
	if(!isset($_SESSION['first_name'])){
		$title = "Technical Support Management System";
	}else{
		$title="";
	}


	echo '<header>
		<div class="appname">'.$title.'</div>
		<div class="loggedin">
			<ul>';
	if(isset($_SESSION['first_name'])){
		echo '		
		<li>
			<a href="profile.php">
				<div class="chip">
					<img src="img/user.jpg" alt="user" width="96" height="96">'.
					ucfirst($_SESSION['first_name']).
				'</div>
			</a>
		</li>
		<li><a href="logout.php">Log Out</a></li>';
	}
				
	echo'
			</ul>						
		</div>
</header>';
}

function display_sidebar($user_type)
{
	if (strtolower($user_type) == 'admin') {
		echo '<div class="sidebar">
		<a href="./index.php">
		<div class="logo">
						<img src="img/logo.png" alt="logo" class="logo"/>
						</div>
						</a>
					<div class="user-info">
						
							<div class="img-sidebar">
								<img src="img/user.jpg" alt="logo" class="user"/>
							</div>
						
						<div class="user-content-sidebar">
								Welcome <br> <h2>'.ucfirst($_SESSION['first_name']).'</h2>
						</div>

					</div>
					<ul>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li><a href="add-user.php">Add Users</a></li>
						<li><a href="users.php">Users</a></li>
						<li><a href="staff.php">Staff</a></li>
						<li><a href="inquries.php">Staff Allocation</a></li>
					</ul>
				</div>';
	}
	if (strtolower($user_type) == 'user') {
		echo '<div class="sidebar">
		<a href="./index.php">
		<div class="logo">
						<img src="img/logo.png" alt="logo" class="logo"/>
						</div>
						</a>
					<div class="user-info">
						<div class="img-sidebar">
							<img src="img/user.jpg" alt="logo" class="user"/>
						</div>
						<div class="user-content-sidebar">
								Welcome <br> <h2>'.ucfirst($_SESSION['first_name']).'</h2>
						</div>

					</div>
					<ul>
						<li><a href="dashboard-user.php">Dashboard</a></li>
						<li><a href="inquries.php">Inquires</a></li>
						<li><a href="add-inquiry.php">Create Inquiry</a></li>
					</ul>
				</div>';
	}
	if (strtolower($user_type) == 'staff') {
		echo '<div class="sidebar">
		<a href="./index.php">
		<div class="logo">
						<img src="img/logo.png" alt="logo" class="logo"/>
						</div>
						</a>
					<div class="user-info">
						<div class="img-sidebar">
							<img src="img/user.jpg" alt="logo" class="user"/>
						</div>
						<div class="user-content-sidebar">
								Welcome <br> <h2>'.ucfirst($_SESSION['first_name']).'</h2>
						</div>

					</div>
					<ul>
						<li><a href="dashboard-staff.php">Dashboard</a></li>
						<li><a href="inquries.php">Inquires</a></li>
						<li><a href="accepted-inquries.php">Accepted Inquires</a></li>
						<li><a href="solved-inquries.php">Solved Inquires</a></li>
					</ul>
				</div>';
	}
}
function display_footer(){
	echo '
	<footer>
		<p>&copy TECH SUPPORT 2023</p>
	</footer>
	';
}

function verify_query($result_set)
{

	global $connection;

	if (!$result_set) {
		die("Database query failed: " . mysqli_error($connection));
	}
}

function check_req_fields($req_fields)
{
	// checks required fields
	$errors = array();

	foreach ($req_fields as $field) {
		$trimVal = trim($_POST[$field]);
		if (empty($trimVal)) {
			$errors[] = $field . ' is required';
		}
	}
	return $errors;
}

function check_max_len($max_len_fields)
{
	// checks max length
	$errors = array();

	foreach ($max_len_fields as $field => $max_len) {
		if (strlen(trim($_POST[$field])) > $max_len) {
			$errors[] = $field . ' must be less than ' . $max_len . ' characters';
		}
	}
	return $errors;
}

function display_errors($errors)
{
	// format and displays form errors
	echo '<div class="errmsg">';
	echo '<b>There were error(s) on your form.</b><br>';
	foreach ($errors as $error) {
		$error = ucfirst(str_replace("_", " ", $error));
		echo '- ' . $error . '<br>';
	}
	echo '</div>';
}

function is_email($email)
{
	return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}
?>
