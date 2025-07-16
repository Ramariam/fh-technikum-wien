<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zimmer buchen</title>
    <link rel="stylesheet" href="css/buchung.css">
</head>
<body>
    <img class="logo" src="assets/images.jpg" alt="Logo">
    <div class="container">
        <h1>Zimmer buchen</h1>
        <form action="buchungsbestaetigung.php" method="post" id="buchungsformular">
            <label for="zimmerTyp">Zimmertyp:</label>
            <select id="zimmerTyp" name="zimmerTyp" required>
                <option value="Einzelzimmer">Einzelzimmer</option>
                <option value="Doppelzimmer">Doppelzimmer</option>
                <option value="Suite">Suite</option>
            </select>

            <label for="checkIn">Check-in Datum:</label>
            <input type="date" id="checkIn" name="checkIn" required>

            <label for="checkOut">Check-out Datum:</label>
            <input type="date" id="checkOut" name="checkOut" required>

            <!-- Verpflegungsoptionen -->
            <label for="verpflegung">Verpflegung:</label>
            <select id="verpflegung" name="verpflegung">
                <option value="ohne">Ohne Verpflegung</option>
                <option value="fruehstueck">Inklusive Frühstück - 40€</option>
                <option value="halbpension">Halbpension - 80€</option>
                <option value="allinclusive">All Inclusive - 150€</option>
            </select>
            <!-- Haustieroptionen -->
            <label for="haustiere">Haustiere:</label>
            <input type="checkbox" id="haustiere" name="haustiere">
            <label for="anzahlHaustiere">Anzahl der Haustiere (falls vorhanden):</label>
            <input type="number" id="anzahlHaustiere" name="anzahlHaustiere" min="0" max="5">

            <!-- Parkplatzreservierung -->
            <label for="parkplatz">Parkplatz benötigt:</label>
            <input type="checkbox" id="parkplatz" name="parkplatz">

            <input type="submit" value="Jetzt buchen">
        </form>
    </div>
    <p><a href="Homepage.php">Zurück zur Startseite</a></p>
</body>
</html>

<?php
include 'dbconnection/dbaccess.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validiere und bereinige die eingegebenen Daten
    $zimmerTyp = $_POST["zimmerTyp"];
    $checkIn = $_POST["checkIn"];
    $checkOut = $_POST["checkOut"];
    $verpflegung = $_POST["verpflegung"];
    $haustier = isset($_POST["haustiere"]) ? "Ja" : "Nein";
    $parkplatz = isset($_POST["parkplatz"]) ? "Ja" : "Nein";

    // Hier kannst du die Summe berechnen, basierend auf den ausgewählten Optionen
    // Zum Beispiel: $summe = ...; (Berechne die Summe hier)



    // Schließe die SQL-Verbindung
    $stmt->close();
}

// Schließe die Datenbankverbindung
$db_obj->close();
?>
