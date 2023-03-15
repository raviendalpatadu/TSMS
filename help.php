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

<body>
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
                    <h1><span class="brand-name">HELP</span></h1>
                </div>
                <div>
                    <button type="button" class="collapsible">Create User Account
                        <span style="float:right;">+</span>
                    </button>
                    <div class="content">
                        <p>To create an account, first, click on the <b><i>"Login"</i></b> button, then find and click on the <b><i>"Create Account"</i></b> or <b><i>"Make Account"</i></b> link. Next, fill out the required fields in the form with your personal information.
                            Finally, click the <b><i>"Save"</i></b> button to complete the account creation process.</p>
                    </div>
                </div>

                <div>
                    <button type="button" class="collapsible">Create Staff Account
                        <span style="float:right;">+</span>
                    </button>
                    <div class="content">
                        <p>Login to the platform as an <b><i>admin user</i></b>, click on <b><i>"Add User"</i></b>, and fill out the user creation form with the required details.
                            Then, select <b><i>"Staff"</i></b> as the user type from the available options and click on <b><i>"Save"</i></b> to complete the process.
                        </p>
                    </div>
                </div>

                <div>
                    <button type="button" class="collapsible">Create Inquiry
                        <span style="float:right;">+</span>
                    </button>
                    <div class="content">
                        <p>To create an inquiry, log in with your <b><i>user account</i></b> and click on <b><i>"Create Inquiry"</i></b>. Fill out the given form with the necessary details and click on <b><i>"Save"</i></b> to submit your inquiry.</p>
                    </div>
                </div>
                <div>
                    <button type="button" class="collapsible">View Inquiry
                        <span style="float:right;">+</span>
                    </button>
                    <div class="content">
                        <p>To view an inquiry, log in with your <b><i>user account</i></b> and click on <b><i>"Your Inquiries"</i></b>. All inquiries and status of your inquiries will be listed below.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy TECH SUPPORT 2023</p>
    </footer>
</body>


</html>

<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script>
<?php mysqli_close($connection); ?>