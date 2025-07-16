<?php
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
}

// Check if the user is already logged in
if (isset($_SESSION['eingeloggt'])) {
    header("Location: ../Homepage.php"); // Redirect to homepage if the user is already logged in
    exit();
}

// Server-side validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $anrede = $_POST["anrede"];
    $vorname = $_POST["vorname"];
    $nachname = $_POST["nachname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $passwort = password_hash($_POST["passwort"], PASSWORD_BCRYPT); // Hash the password
    $role = "user"; // Default role is user

    // Insert user data into the database
    $insertQuery = "INSERT INTO users (anrede, vorname, nachname, email, username, passwort, role) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db_obj->prepare($insertQuery);
    $stmt->bind_param("sssssss", $anrede, $vorname, $nachname, $email, $username, $passwort, $role);

    if ($stmt->execute()) {
        // Set the username in the session to indicate the user is logged in
        $_SESSION['username'] = $username;

        // Set other session variables if needed (e.g., email, role)
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // Debugging output
        var_dump($_SESSION);

        // Redirect to the homepage after successful registration
        header("Location: ../Homepage.php");
        exit();
    } else {
        echo "<p style='color: red;'>Fehler bei der Registrierung: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Close the database connection
$db_obj->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Registrierung</title>
    <link rel="stylesheet" href="../css/registrierung.css">
</head>
<body>
<center>
    <img class="logo" src="../assets/images.jpg" alt="Logo">
    <div class="container">
        <div class="form-container">
            <h1>Registrierungsformular</h1>

            <form action="Registrierung.php" method="post" id="registrierungsformular">
                <label for="anrede">Anrede:</label>
                <select id="anrede" name="anrede" required>
                    <option value="Herr">Herr</option>
                    <option value="Frau">Frau</option>
                </select>

                <label for="vorname">Vorname:</label>
                <input type="text" id="vorname" name="vorname" required>

                <label for="nachname">Nachname:</label>
                <input type="text" id="nachname" name="nachname" required>

                <label for="email">E-Mail-Adresse:</label>
                <input type="email" id="email" name="email" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="passwort">Passwort:</label>
                <input type="password" id="passwort" name="passwort" required>

                <label for="passwortBestaetigen">Passwort bestätigen:</label>
                <input type="password" id="passwortBestaetigen" name="passwortBestaetigen" required>

                <input type="submit" value="Registrieren">
            </form>
</center>
<p class="back-to-home"><a href="../Homepage.php">Zurück zur Startseite</a></p>
<?php
if (empty($anrede) || empty($vorname) || empty($nachname) || empty($email) || empty($username) || empty($passwort) || empty($passwortBestaetigen)) {
    echo "<p style='color: red;'>Bitte füllen Sie alle Felder aus.</p>";
} elseif ($passwort != $passwortBestaetigen) {
    echo "<p style='color: red;'>Die Passwörter stimmen nicht überein.</p>";
} else {
    // Hier sollte die Logik zur Speicherung der Daten in der Datenbank eingefügt werden
    // header('Location: Hotel_del_Luna.php'); // Weiterleitung nach erfolgreicher Registrierung
    echo "<p style='color: green;'>Registrierung erfolgreich!</p>";
}
?>
</body>
</html>
