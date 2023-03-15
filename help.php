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
                    <button type="button" class="collapsible">Help Item</button>
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, voluptatibus? Corrupti, quas cum sapiente exercitationem deleniti quibusdam quod alias voluptas saepe consequatur voluptatibus nisi quidem rerum id quia reprehenderit error.</p>
                    </div>
                </div>
                <div>
                    <button type="button" class="collapsible">Help Item</button>
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, voluptatibus? Corrupti, quas cum sapiente exercitationem deleniti quibusdam quod alias voluptas saepe consequatur voluptatibus nisi quidem rerum id quia reprehenderit error.</p>
                    </div>
                </div>
                <div>
                    <button type="button" class="collapsible">Help Item</button>
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, voluptatibus? Corrupti, quas cum sapiente exercitationem deleniti quibusdam quod alias voluptas saepe consequatur voluptatibus nisi quidem rerum id quia reprehenderit error.</p>
                    </div>
                </div>
                <div>
                    <button type="button" class="collapsible">Help Item</button>
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, voluptatibus? Corrupti, quas cum sapiente exercitationem deleniti quibusdam quod alias voluptas saepe consequatur voluptatibus nisi quidem rerum id quia reprehenderit error.</p>
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