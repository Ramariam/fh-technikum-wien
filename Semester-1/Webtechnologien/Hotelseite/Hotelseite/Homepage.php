<?php

session_start();


$dotClass = isset($_SESSION['username']) ? 'logged' : 'not-logged';
?>
<?php

// Überprüfe, ob der Benutzer eingeloggt ist
$welcomeMessage = isset($_SESSION['email']) ? 'Willkommen, ' . $_SESSION['email'] . '!' : '';

$dotClass = isset($_SESSION['email']) ? 'logged' : 'not-logged';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Startseite</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>

    <header>
        <h1>Hotel del Luna</h1>
    </header>
<?php
    include 'navbar.php';
?>
    <div class="container">
        <div class="hotel-info">
            <h2>Über uns</h2>
            <p>Herzlich willkommen im Hotel del Luna! Wir bieten Ihnen einen komfortablen und entspannten Aufenthalt inmitten einer herrlichen Umgebung. Unser erfahrenes Personal steht Ihnen jederzeit zur Verfügung, um sicherzustellen, dass Ihr Aufenthalt unvergesslich wird.</p>
        </div>

        <div id="mycarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
                <li data-target="#mycarousel" data-slide-to="1"></li>
                <!-- Weitere Indikatoren bei Bedarf hinzufügen -->
            </ol> 

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/res/img/hotel.jpg" class="d-block w-100" alt="Unser Hotel">
                </div>
                <div class="carousel-item">
                    <img src="/res/img/lobby.png" class="d-block w-100" alt="Lobby">
                </div>
                <div class="carousel-item">
                    <img src="/res/img/esssaal.jpg" class="d-block w-100" alt="Esssaal">
                </div>
                <div class="carousel-item">
                    <img src="/res/img/breakfast.jpg" class="d-block w-100" alt="Unser Frühstück">
                </div>
            </div>

            <a class="carousel-control-prev" href="#mycarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#mycarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div>

    <div class="section">
        <h2>Zimmer und Suiten</h2>
        <p>Unsere Zimmer und Suiten sind stilvoll eingerichtet und bieten modernen Komfort. Egal, ob Sie geschäftlich oder privat reisen, wir haben die perfekte Unterkunft für Sie.</p>
    </div>

    <div class="section">
        <h2>Einrichtungen</h2>
        <p>Genießen Sie unsere erstklassigen Einrichtungen, darunter ein hervorragendes Restaurant, einen Wellnessbereich und Tagungsräume für geschäftliche Veranstaltungen.</p>
    </div>

    <footer class="footer">
        &copy; 2023 Hotel del Luna. Alle Rechte vorbehalten.
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
