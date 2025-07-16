User
<?php
// Verbindung zur Datenbank herstellen

// Session starten (nur einmal)
session_start();
$host = "localhost";
$user = "Admin"; // Default XAMPP MySQL user
$password = "Admin123"; // Default XAMPP MySQL password
$database = "hotel_del_luna";

// Create a new MySQLi object
$db_obj = new mysqli($host, $user, $password, $database);

// Check the connection
if ($db_obj->connect_error) {
    die("Connection Error: " . $db_obj->connect_error);
};// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Benutzerdaten aus dem Formular
    $email = $_POST['email'];
    $password = $_POST['passwort'];

 // Sichere SQL-Abfrage mit Prepared Statement
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $db_obj->prepare($query);

// Variablen deklarieren
$email = $_POST['email'];

// Werte an die Platzhalter binden
$stmt->bind_param("s", $email);

// Statement ausführen
$stmt->execute();

// Ergebnis abrufen
$result = $stmt->get_result();

// Überprüfe, ob die Abfrage erfolgreich war
if ($result) {
    // Überprüfe, ob es einen Benutzer mit der angegebenen E-Mail gibt
    if ($result->num_rows > 0) {
        // Benutzer existiert
        $user = $result->fetch_assoc();

        // Passwort überprüfen
        if (password_verify($_POST['passwort'], $user['passwort'])) {
            // Passwort ist korrekt

            // Session-Variable für eingeloggten Benutzer setzen
            $_SESSION['eingeloggt'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Weiterleitung oder andere Aktionen nach erfolgreichem Login
            header("Location: ../Homepage.php");
            exit();
        } else {
            // Passwort ist falsch
            $loginError = "Falsches Passwort";
        }
    } else {
        // Benutzer existiert nicht
        $loginError = "Benutzer existiert nicht";
    }
} else {
    // Fehler bei der Abfrage
    $loginError = "Fehler bei der Datenbankabfrage: " . $db_obj->error;
}

// Schließe das Prepared Statement
$stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
          <!-- Ersetze 'dein_logo.png' durch den genauen Pfad zu deinem Logo -->


            <form action="Login.php" method="post" id="login-form">
                <h1>Login</h1>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">E-Mail-Adresse:</label>
                <input type="email" id="email" name="email" required>

                <label for="passwort">Passwort:</label>
                <input type="password" id="passwort" name="passwort" required>

                <input type="submit" value="Anmelden">
            </form>

            <p class="register-link"> <a href="Registrierung.php">Noch keinen Account? Registrieren</a></p>
        </div>
    </div>
</body>
</html>
