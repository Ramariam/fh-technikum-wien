<?php

$dotClass = isset($_SESSION['username']) ? 'logged' : 'not-logged';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel del Luna</title>
    <link rel="stylesheet" href="css/navbar.css">

</head>
<body>

<div class="header">
    <div class="logo">
    </div>
    <div class="navbar">
        <a href="Hilfeseite.php">FAQs</a>
        <a href="impressum.php">Impressum</a>
        <a href="homepage.php">Homepage</a>
        <?php
        if (isset($_SESSION['eingeloggt'])) {
            echo '<a href="Logoutsite.php">Logout</a>';
        
            // Überprüfe, ob die E-Mail-Adresse 'admin@gmail.com' ist 
            if (strtolower($_SESSION['email']) == 'admin@gmail.com') {
                echo '<a href="news-update.php">Upload</a>';
                echo '<a href="editprofile.php">Profilverwaltung</a>';
            }

            echo '<a href="Zimmer.php">Zimmer reservieren</a>';
            echo '<a href="profilverwaltung.php">My Account</a>';
        }else {
            echo '<a href="authentication/Login.php">Login</a>';
            echo '<a href="authentication/Registrierung.php">Registrierung</a>';
        }

        echo '<a href="News.php">News</a>';
        ?>
    </div>
</div>

</body>
</html>
        