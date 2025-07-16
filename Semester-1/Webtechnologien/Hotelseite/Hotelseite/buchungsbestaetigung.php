<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Buchungsdaten abrufen
    $zimmerTyp = $_POST["zimmerTyp"];
    $checkIn = $_POST["checkIn"];
    $checkOut = $_POST["checkOut"];
    $verpflegung = $_POST["verpflegung"];
    $haustiere = isset($_POST['haustiere']) ? 'Ja' : 'Nein';
    $anzahlHaustiere = isset($_POST['haustiere']) ? $_POST['anzahlHaustiere'] : 0;
    $parkplatz = isset($_POST['parkplatz']) ? 'Ja' : 'Nein';

    // Hier könnten Sie die Buchungsdaten in einer Datenbank speichern

if ($_SERVER["REQUEST_METHOD"] == "POST") 
    // Festgelegte Preise
    $preise = [
        'Einzelzimmer' => 180,
        'Doppelzimmer' => 230,
        'Suite' => 300,
        'fruehstueck' => 40,
        'halbpension' => 80,
        'allinclusive' => 150
    ];

    // Buchungsdaten abrufen
    $zimmerTyp = $_POST["zimmerTyp"];
    $checkIn = $_POST["checkIn"];
    $checkOut = $_POST["checkOut"];
    $verpflegung = $_POST["verpflegung"];

    // Anzahl der Übernachtungen berechnen
    $checkInDatum = new DateTime($checkIn);
    $checkOutDatum = new DateTime($checkOut);
    $anzahlNaechte = $checkInDatum->diff($checkOutDatum)->days;

    // Kosten pro Tag berechnen
    $zimmerPreisProTag = $preise[$zimmerTyp];
    $verpflegungsPreisProTag = $preise[$verpflegung];

    // Gesamtpreis berechnen
    $gesamtPreis = ($zimmerPreisProTag + $verpflegungsPreisProTag) * $anzahlNaechte;

    // Zahlungsinformationen anzeigen
    echo "<!DOCTYPE html>
    <html lang='de'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Buchungsbestätigung</title>
        <link rel='stylesheet' href='css/buchungsbestaetigung.css'>
      
    </head>
    <body>
    <?php include 'navbar.php'; ?>
    <img class='logo' src='/res/img/images.jpg' alt='Logo'>
    <div class='container'>
        <h1>Buchungsbestätigung</h1>
        <p>Vielen Dank für Ihre Buchung!</p>
        <p>Zimmertyp: " . htmlspecialchars($zimmerTyp) . "</p>
        <p>Check-in Datum: " . htmlspecialchars($checkIn) . "</p>
        <p>Check-out Datum: " . htmlspecialchars($checkOut) . "</p>
        <p>Verpflegung: " . htmlspecialchars($verpflegung) . "</p>
        <p>Haustiere: " . htmlspecialchars($haustiere) . ", Anzahl: " . htmlspecialchars($anzahlHaustiere) . "</p>
        <p>Parkplatz benötigt: " . htmlspecialchars($parkplatz) . "</p>

        <p>Bitte geben Sie Ihre Zahlungsinformationen ein:</p>
        <form action='zahlungsbestaetigung.php' method='post'>
            <!-- Zahlungsdetails Formularfelder -->
            <input type='hidden' name='zimmerTyp' value='" . htmlspecialchars($zimmerTyp) . "'>
            <input type='hidden' name='checkIn' value='" . htmlspecialchars($checkIn) . "'>
            <input type='hidden' name='checkOut' value='" . htmlspecialchars($checkOut) . "'>
            <input type='hidden' name='verpflegung' value='"
            . htmlspecialchars($verpflegung) . "'>
<input type='hidden' name='haustiere' value='" . htmlspecialchars($haustiere) . "'>
<input type='hidden' name='anzahlHaustiere' value='" . htmlspecialchars($anzahlHaustiere) . "'>
<input type='hidden' name='parkplatz' value='" . htmlspecialchars($parkplatz) . "'>
<label for='zahlungsart'>Zahlungsart:</label>
<select id='zahlungsart' name='zahlungsart' required>
    <option value='paypal'>PayPal</option>
    <option value='kreditkarte'>Kreditkarte</option>
    <option value='Barzahlung im Hotel'>Barzahlung</option>
    <!-- Weitere Zahlungsarten hier hinzufügen -->
</select>
<!-- Weitere Zahlungsdetails -->
<p>Gesamtpreis für Ihren Aufenthalt (für $anzahlNaechte Nächte): €" . $gesamtPreis . "</p>
</html>
<input type='submit' value='Zahlung abschließen'>
</form>
</div>
</body>
</html>";
} else {
    // Wenn die Seite nicht über das Formular aufgerufen wurde, zurück zur Buchungsseite
    header("Location: buchung.php");
    exit();
    }
    ?>
</body>
</head>