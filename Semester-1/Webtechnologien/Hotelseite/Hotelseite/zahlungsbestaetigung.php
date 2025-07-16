<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Zahlungsdaten abrufen
    $zimmerTyp = $_POST["zimmerTyp"];
    $checkIn = $_POST["checkIn"];
    $checkOut = $_POST["checkOut"];
    $zahlungsart = $_POST["zahlungsart"];
    
    // Hier könnten Sie die Zahlungsdaten speichern oder verarbeiten
    
    // Bestätigungsseite anzeigen
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Zahlungsbestätigung</title>
        <link rel='stylesheet' href='css/zahlungsbestaetigung.css'>
    </head>
    <body>
        <img class='logo' src='/res/img/images.jpg' alt='Logo'>
        <div class='container'>
            <h1>Zahlungsbestätigung</h1>
            <p>Vielen Dank für Ihre Zahlung!</p>
            <p>Zimmertyp: $zimmerTyp</p>
            <p>Check-in Datum: $checkIn</p>
            <p>Check-out Datum: $checkOut</p>
            <p>Zahlungsart: $zahlungsart</p>
            <p>Ihre Buchung wurde erfolgreich abgeschlossen.</p>
            <p><a href='Homepage.php'>Zurück zur Startseite</a></p>
        </div>
    </body>
    </html>";
} else {
    // Zahlungsformular anzeigen
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Zahlungsformular</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 100vh;
                background-color: blue; /* Hintergrundfarbe ändern */
            }

            .container {
                width: 80%;
                margin: 0 auto;
                overflow: hidden;
                background: rgba(0, 0, 0, 0.8); /* Hintergrundfarbe ändern */
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                color: white; /* Textfarbe ändern */
            }

            h1 {
                text-align: center;
                color: white;
            }

            form {
                display: flex;
                flex-direction: column;
                margin-top: 20px;
            }

            label {
                margin: 10px 0;
                font-weight: bold;
            }

            input {
                margin-bottom: 15px;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            input[type='submit'] {
                font-weight: bold;
                background-color: #4CAF50; /* Hintergrundfarbe für den Submit-Button */
                color: white;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Zahlungsformular</h1>
            <form action='zahlungsbestaetigung.php' method='post'>
                <label for='zahlungsart'>Zahlungsart:</label>
                <select id='zahlungsart' name='zahlungsart' required>
                    <option value='Kreditkarte'>Kreditkarte</option>
                    <option value='PayPal'>PayPal</option>
                    <option value='Überweisung'>Überweisung</option>
                </select>
                <label for='kartennummer'>Kartennummer:</label>
                <input type='text' id='kartennummer' name='kartennummer' required>
                <label for='ablaufdatum'>Ablaufdatum:</label>
                <input type='text' id='ablaufdatum' name='ablaufdatum' placeholder='MM/YY' required>
                <label for='cvv'>CVV:</label>
                <input type='text' id='cvv' name='cvv' required>
                <input type='hidden' name='zimmerTyp' value='$zimmer'>
                <input type='hidden' name='checkIn' value='$CheckIn'>
                <input type='hidden' name='checkOut' value='$CheckOut'>
                <input type='submit' value='Zahlung abschließen'>
            </form>
        </div>
    </body>
    </html>";
}
?>
