<!DOCTYPE html>
<html>
<head>
    <title>Buchungsinfo</title>
    <link rel="stylesheet" href="css/buchungsinfo.css">
</head>
<body>
    <?php 
    include 'navbar.php';

    require_once 'dbconnection/dbaccess.php';
    // Verbindung zur Datenbank herstellen (Du kannst deine eigenen Datenbankinformationen verwenden)
    $servername = "localhost";
    $username = "Admin";
    $password = "Admin123";
    $database = "hotel_del_luna";

    $conn = new mysqli($servername, $username, $password, $database);

    // Überprüfen Sie die Verbindung
    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }
    
    // Angenommen, der Benutzer ist angemeldet und seine Benutzer-ID ist in der Session gespeichert
    session_start();

    // SQL-Abfrage zum Abrufen der Buchungsinformationen des Benutzers
    $sql = "SELECT * FROM bookings WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Daten wurden gefunden, Buchungsinformationen anzeigen
        while ($row = $result->fetch_assoc()) {
            echo "<h1>Ihre Buchungsinformationen:</h1>";
            echo "<p>Zimmer: " . htmlspecialchars($row["zimmer"]) . "</p>";
            echo "<p>Verpflegung: " . htmlspecialchars($row["verpflegung"]) . "</p>";
            echo "<p>GesamtPreis: " . htmlspecialchars($row["GesamtPreis"]) . "</p>";
            echo "<p>CheckIn: " . htmlspecialchars($row["CheckIn"]) . "</p>";
            echo "<p>CheckOut: " . htmlspecialchars($row["CheckOut"]) . "</p>";
        }
    } else {
        // Keine Buchungen gefunden
        echo "<h1>Keine Buchungsinformationen gefunden.</h1>";
    }

    ?>
</body>
</html>


<?php

$conn = new mysqli($servername, $username, $password, $database);

$zimmer = $verpflegung = $GesamtPreis = $CheckIn = $CheckOut = ""; // Variablen initialisieren
// Überprüfen Sie die Verbindung
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verbindung zur Datenbank herstellen (Sie müssen Ihre eigenen Datenbankinformationen einfügen)
    $servername = "localhost";
    $username = "Admin";
    $password = "Admin123";
    $database = "hotel_del_luna";

    $conn = new mysqli($servername, $username, $password, $database);

    // Überprüfen Sie die Verbindung
    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }

    $zimmer = $_POST["zimmer"];
    $verpflegung = $_POST["verpflegung"];
    $GesamtPreis = $_POST["GesamtPreis"];
    $CheckIn = $_POST["CheckIn"];
    $CheckOut = $_POST["CheckOut"];

    // SQL-Abfrage zum Einfügen der Buchungsinformationen in die Datenbank
    $sql = "INSERT INTO bookings (zimmer, verpflegung, GesamtPreis, CheckIn, CheckOut) VALUES ('$zimmer', '$verpflegung', '$GesamtPreis', '$CheckIn', '$CheckOut')";

    if ($conn->query($sql) === TRUE) {
        echo "Buchungsinformationen wurden erfolgreich gespeichert.";
    } else {
        echo "Fehler beim Speichern der Buchungsinformationen: " . $conn->error;
    }

    // Datenbankverbindung schließen
    $conn->close();
}
?>

