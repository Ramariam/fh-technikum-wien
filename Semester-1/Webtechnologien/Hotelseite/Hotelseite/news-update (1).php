<!DOCTYPE html>
<html lang="de">
<head>

<?php
    include 'navbar.php';
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Bereich</title>
    <link rel="stylesheet" href="css/news-update.css">
</head>

<body>
    <div class="container">
        <!-- News Upload Section -->
        <div class="upload-section">
            <h2>News Upload</h2>
            
<form action="upload_news.php" method="post" enctype="multipart/form-data">
    <label for="newsTitle">Titel:</label><br>
    <input type="text" id="newsTitle" name="newsTitle" required><br><br>
    <label for="newsContent">Inhalt:</label><br>
    <textarea id="newsContent" name="newsContent" rows="4" cols="50" required></textarea><br><br>
    <label for="newsImage">Bild hochladen:</label><br>
    <input type="file" id="newsImage" name="newsImage" accept="image/*"><br><br>
    <input type="submit" value="News hochladen">
</form>

        </div>

        <!-- Reservation Status Update Section -->
        <div class="reservation-section">
            <h2>Reservierungsstatus Aktualisieren</h2>
            
<form action="update_reservation_status.php" method="post">
    <label for="reservationId">Reservierungs-ID:</label><br>
    <input type="text" id="reservationId" name="reservationId" required><br><br>
    <label for="newStatus">Neuer Status:</label><br>
    <select id="newStatus" name="newStatus" required>
        <option value="neu">Neu</option>
        <option value="bestätigt">Bestätigt</option>
        <option value="storniert">Storniert</option>
    </select><br><br>
    <input type="submit" value="Status aktualisieren">
</form>

        </div>
    </div>
    <p><a href="Homepage.php">Zurück zur Startseite</a></p>

</body>
</html>