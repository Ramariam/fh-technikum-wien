<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservierungsstatus Aktualisieren</title>
    <link rel="stylesheet" href="css/editprofile.css"> 
    <?php include 'navbar.php'; ?>
</head>
<body>
<div class="reservation-section">
    <h2>Reservierungsstatus Aktualisieren</h2>
    
    <form action="editprofile.php" method="post">
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
</body>
</html>

<?php
// Starte die Session
session_start();

// Überprüfe, ob das Formular abgeschickt wurde (POST-Methode)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verbinde mit der Datenbank
    require 'dbconnection/dbaccess.php';

    // Validiere und bereinige die eingegebenen Daten
    $reservationId = $_POST['reservationId'];
    $newStatus = $_POST['newStatus'];

    // SQL-Abfrage, um den Reservierungsstatus zu aktualisieren
    $updateQuery = "UPDATE users SET status = ? WHERE ID = ?";
    $stmtUpdate = $db_obj->prepare($updateQuery);
    $stmtUpdate->bind_param("si", $newStatus, $bookingsId);

    // Führe die Aktualisierung aus
    if ($stmtUpdate->execute()) {
        $_SESSION['message'] = "Reservierungsstatus erfolgreich aktualisiert";
    } else {
        $_SESSION['message'] = "Fehler bei der Aktualisierung des Reservierungsstatus: " . mysqli_error($db_obj);
    }

    $stmtUpdate->close();
    
    // Schließe die Datenbankverbindung
    mysqli_close($db_obj);

    // Leite zur gewünschten Seite weiter
    header('Location: editprofile.php'); // Ändern Sie desired_page.php zur gewünschten Seite
    exit();
}
?>



<?php

$loggedInEmail = $_SESSION['email'];


// Definiere Variablen und setze sie auf leere Werte
$nameErr= $lnameErr= $emailErr = $userErr = $calenderErr = $password1Err = $password2Err = $validErr = $wdhEmailErr = "";
$name =$lname = $newEmail = $user = $calender = $password1 = $password2 = $succRegister = $updateId=$altesPasswort= "";

// Funktion zur Überprüfung und Bereinigung von Eingabedaten
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Überprüfe, ob das Formular abgeschickt wurde (POST-Methode)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validiere und bereinige die eingegebenen Daten
    if (empty($_POST["vorname"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["vorname"]);
    }
    if (empty($_POST["lname"])) {
        $lnameErr = "Name is required";
    } else {
        $lname = test_input($_POST["lname"]);
    }
    if (empty($_POST["user"])) {
        $userErr = "User is required";
    } else {
        $user = test_input($_POST["user"]);
    }
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        $notId=test_input($_POST["userId"]);
    }
    if (empty($_POST["password1"])) {
        $password1Err = "Password is required";
    } else {
        $password1 = test_input($_POST["password1"]);
    }
    if (empty($_POST["password2"])) {
        $password2Err = "Password is required";
    } else {
        $password2 = test_input($_POST["password2"]);
    }

    // Verbinde mit der Datenbank (Benutzerdaten abrufen)

// Verbinde mit der Datenbank
require 'dbconnection/dbaccess.php';

// SQL-Abfrage zum Aktualisieren des Status der Benutzer
$sql = "UPDATE users SET status = 'inactive' WHERE last_login_date <= DATE_SUB(NOW(), INTERVAL 30 DAY) AND status = 'active' AND role != 'Admin'";

// Führe das Update aus
if ($db_obj->query($sql) === TRUE) {
    echo "Benutzerstatus wurde erfolgreich aktualisiert.";
} else {
    echo "Fehler beim Aktualisieren des Benutzerstatus: " . $db_obj->error;
}

// Schließe die Datenbankverbindung
mysqli_close($db_obj);


    // SQL-Abfrage, um Benutzerdaten abzurufen

    if($loggedInEmail=='Admin@gmail.com'){
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param("i", $notId);
        $stmt->execute();
     $result = $stmt->get_result();
    }
    else{
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param("s", $loggedInEmail);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    // Überprüfe das Abfrageergebnis
  
        // Extrahiere Benutzerdaten aus dem Abfrageergebnis
        $db_id = mysqli_fetch_assoc($result);


            // Aktualisiere die Benutzerdaten
            $updateId = $db_id['id'];
            $anrede = $_POST['anrede'];
            $vorname = $_POST['vorname'];
            $currentPassword = $_POST['current_password'];
            $username = $_POST['user'];
            $newEmail = $_POST['email'];
            $nachname=$_POST['lname'];
            $row = mysqli_fetch_assoc($result);
            $altesPasswort = $db_id['passwort'];
            if (isset($_POST['saveChanges'])) {
                // Überprüfen, ob ein neues Passwort eingegeben wurde
                $currentPassword = isset($_POST['current_password']) ? $_POST['current_password'] : '';
                $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
                $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
            
                // Überprüfen, ob ein neues Passwort eingegeben wurde
                if ((!empty($password1) || !empty($password2)) && empty($currentPassword)) {
                    $password1Err = "Current password is required when changing password";
                }
            
                // Überprüfen, ob das aktuelle Passwort mit dem in der Datenbank übereinstimmt
                if (!empty($currentPassword)) {
                    $checkPasswordQuery = "SELECT passwort FROM users WHERE id=?";
                    $stmtCheckPassword = $db_obj->prepare($checkPasswordQuery);
                    $stmtCheckPassword->bind_param("s", $updateId);
                    $stmtCheckPassword->execute();
                    $checkPasswordResult = $stmtCheckPassword->get_result();
            
                    if ($checkPasswordResult) {
                        $dbPassword = mysqli_fetch_assoc($checkPasswordResult)['passwort'];
                        if (!password_verify($currentPassword, $dbPassword)) {
                            $password1Err = "Incorrect current password";
                        }
                    } else {
                        // Handle den Fall, dass die SQL-Abfrage nicht erfolgreich war.
                        echo "Error: " . mysqli_error($db_obj);
                    }
                    $stmtCheckPassword->close();
                }
            
                // Überprüfen, ob die neuen Passwörter übereinstimmen
                if ($password1 != $password2) {
                    $password2Err = "Passwords do not match";
                } elseif (!empty($password1) && !empty($password2)) {
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                }
            
                // Überprüfen, ob Benutzername oder E-Mail bereits existieren
                $checkDuplicateQuery = "SELECT id FROM users WHERE (username=? OR email=?) AND id != ?";
                $stmtCheckDuplicate = $db_obj->prepare($checkDuplicateQuery);
                $stmtCheckDuplicate->bind_param("ssi", $username, $newEmail, $updateId);
                $stmtCheckDuplicate->execute();
                $checkDuplicateResult = $stmtCheckDuplicate->get_result();
            
                if ($checkDuplicateResult->num_rows > 0) {
                    $userErr = "Username or email already exists";
                } else {
                    // Aktualisiere das Passwort nur, wenn ein neues angegeben wurde
                    if (isset($hashed_password)) {
                        $query = "UPDATE users
                                  SET anrede=?, Vorname=?, nachname=?, email=?, username=?, passwort=?
                                  WHERE id=?";
                        $stmtUpdate = $db_obj->prepare($query);
                        $stmtUpdate->bind_param("ssssssi", $anrede, $vorname, $nachname, $newEmail, $username, $hashed_password, $updateId);
                    } else {
                        $query = "UPDATE users 
                                  SET anrede=?, Vorname=?, nachname=?, email=?, username=?
                                  WHERE id=?";
                        $stmtUpdate = $db_obj->prepare($query);
                        $stmtUpdate->bind_param("sssssi", $anrede, $vorname, $nachname, $newEmail, $username, $updateId);
                    }
            
                    $query_run = $stmtUpdate->execute();
                    $stmtUpdate->close();
            
                    if ($loggedInEmail !== 'Admin@gmail.com') {
                        $_SESSION['email'] = $newEmail;
                        $loggedInEmail = $newEmail;
                    }


                
                    if ($query_run) {
                        $_SESSION['message'] = "Profil erfolgreich aktualisiert";
                    } else {
                        $_SESSION['message'] = "Profilaktualisierung fehlgeschlagen: " . mysqli_error($db_obj);
                    }
                }
            
                $stmtCheckDuplicate->close();
            } else {
                // Handle den Fall, dass die SQL-Abfrage nicht erfolgreich war.
                echo "Error: " . mysqli_error($db_obj);
            }
            

    // Überprüfe, ob die Lösch-Aktion angefordert wurde
    if (isset($_POST['delete'])) {
        $userToDelete = $_POST['userToDelete'];
        $query = "DELETE FROM users WHERE id='$userToDelete'";
        $query_run = mysqli_query($db_obj, $query);

        if ($query_run) {
            // Benutzer ausloggen und zur Startseite weiterleiten
            if($loggedInEmail !="Admin@gmail.com"){
                session_destroy();
                header('Location: homepage.php');
                exit();
            }
        } else {
            $_SESSION['message'] = "Fehler beim Löschen des Kontos: " . mysqli_error($db_obj);
            header('Location: profilverwaltung.php');
            exit();
        }
    }
} else {
    // ...
}
// Überprüfen, ob der Administrator angemeldet ist
// Überprüfen, ob der Administrator angemeldet ist
if ($_SESSION['email'] === 'Admin@gmail.com') {
    // Überprüfen, ob der Deaktivieren-Button geklickt wurde
    if (isset($_POST['deactivate'])) {
        $userToDeactivate = $_POST['userToDeactivate'];
        $query = "UPDATE users SET status='Deaktiviert' WHERE id='$userToDeactivate'";
        $query_run = mysqli_query($db_obj, $query);

        if ($query_run) {
            $_SESSION['message'] = 'Account deaktiviert';
        } else {
            $_SESSION['message'] = 'Fehler beim Deaktivieren des Accounts';
        }
        header('Location: profilverwaltung.php');
        exit();
    }

       // Überprüfen, ob der Activate-Button geklickt wurde
if (isset($_POST['activate'])) {
    $userToActivate = $_POST['userToActivate'];
    $query = "UPDATE users SET status='aktivieren' WHERE id='$userToActivate'";
    $query_run = mysqli_query($db_obj, $query);

    if ($query_run) {
        $_SESSION['message'] = 'Account aktiviert';
    } else {
        $_SESSION['message'] = 'Fehler beim Aktivieren des Accounts';
    }
    header('Location: profilverwaltung.php');
    exit();
}

// Überprüfe, ob der eingeloggte Benutzer ein Admin ist
if ($_SESSION['email'] === 'Admin@gmail.com') {
    // Füge den Code ein, um den Status der Benutzer anzuzeigen
    require_once 'dbconnection/dbaccess.php';

    $sql = "SELECT * FROM users";
    $result = mysqli_query($db_obj, $sql);

    if ($result) {
        echo '<div class="container"><br><br><br>';
        echo '<h1>User Status Overview</h1>';
        echo '<table class="table table-bordered"><thead><tr><th>username</th><th>status</th></tr></thead><tbody>';
      
        foreach ($result as $user) {
            echo '<tr>';
            echo '<td>' . $user['username'] . '</td>';
            echo '<td>' . $user['status'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    } else {
        echo "Error fetching user status: " . mysqli_error($db_obj);
    }
} else {

}

}
?>