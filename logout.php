<?php 

	session_start();

	$_SESSION = array();

	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}
	unset($_SESSION);
	session_destroy();

	// redirecting the user to the login page
	header('Location: login.php?logout=yes');

 ?>


































<?php
$x="ffdsdfs"; $y=2; function moDaYaka($X,$y)
{	
	return $X + $y;
		
}
moDaYakaa()




?>