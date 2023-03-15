<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tech Support</title>
    <link rel="stylesheet" href="css/website.css">
</head>

<body class="about">
    <header>
        <div class="appname">
            <img src="./img/logo.png" alt="logo">
        </div>
        <div class="loggedin">
            <ul>
                <li class="fromCenter"><a href="index.php">Home</a></li>
                <li class="fromCenter"><a href="facilities.php">Facilities</a></li>
                <li class="fromCenter"><a href="help.php">Help</a></li>
                <li class="fromCenter"><a href="login.php">Login</a></li>
            </ul>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row-home">
                <div>
                    <h1><span class="brand-name">Facilities</span></h1>
                </div>
                <div>
                    <p>Welcome to our technical support management system! Our platform is designed to streamline your support operations
                        and improve the overall customer experience. With our system, you can:</p>
                    <ul>
                        <li>Keep track of all support requests in one place.</li>
                        <li>Assign tickets to the appropriate team members.</li>
                        <li>Prioritize urgent issues to minimize downtime.</li>
                        <li>Monitor response times and track resolution progress.</li>
                        <li>Provide customers with real-time updates on their support requests.</li>
                        <li>Collect feedback to continually improve your support processes.</li>
                    </ul>
                    <p>
                        Our system is user-friendly and customizable to fit your unique needs. Plus, our team of experts is always available to
                        provide support and answer any questions you may have.Don't let technical support become a headache for you and your
                        customers. Let our management system simplify your operations and improve your overall support performance.
                        Try our system today and see the difference it can make!
                    </p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy TECH SUPPORT 2023</p>
    </footer>
</body>


</html>
<?php mysqli_close($connection); ?>