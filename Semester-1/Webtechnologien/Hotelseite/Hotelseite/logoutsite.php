<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            background-color: #add8e6; /* Light Blue Background */
            color: #00008b; /* Dark Blue Text */
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <?php
    // Überprüfe, ob der Benutzer ausgeloggt ist
    if (!isset($_SESSION['eingeloggt']) || $_SESSION['eingeloggt'] === false) {
        echo "<h1>Sie sind nicht eingeloggt!</h1>";
    } else {
        // Beende die Session
        session_destroy();

        // Setze die Session-Variablen zurück
        $_SESSION['eingeloggt'] = false;
        unset($_SESSION['email']);
        unset($_SESSION['role']);

        // Anzeige der Erfolgsmeldung
        echo "<h1>Sie haben sich erfolgreich ausgeloggt!</h1>";
    }
    ?>
    <p><a href="Homepage.php">Zurück zur Startseite</a></p>
</body>
</html>
