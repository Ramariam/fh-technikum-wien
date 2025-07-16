<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilverwaltung</title>
    <link rel="stylesheet" href="css/profilverwaltung.css">
</head>
<body>
    <?php
    session_start();
    include 'navbar.php';

    $servername = "localhost";
    $username = "Admin";
    $password = "Admin123";
    $dbname = "hotel_del_luna";

    // Verbindung zur Datenbank herstellen
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Überprüfen der Verbindung
    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }
    ?>

    <div class="container">
        <br><br><br>
        <h1>Edit Profile</h1>

        <?php
        $users = $benutzer_id = '';
        require_once 'dbconnection/dbaccess.php';

        $email = '';
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email']; // Weise den Wert aus der Session der Variable $email zu
        }

        if ($email == 'admin@gmail.com') {
            $sql = "SELECT * FROM users";
        } else {
            $sql = "SELECT * FROM users WHERE email = '$email'";
        }

        $result = mysqli_query($db_obj, $sql);

        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $user) {
                ?>

                <?php
                // Überprüfe, ob eine Meldung vorhanden ist
                if (!empty($_SESSION['message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    // Meldung aus der Session entfernen, damit sie nicht erneut angezeigt wird
                    unset($_SESSION['message']);
                }
                ?>

                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                            <h6><i class="fas fa-camera"></i> Update profile picture</h6>
                            <input type="file" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="alert alert-info alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">×</a>
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h3>Personal information <p>ID Nr.:<?= $user['id_user']; ?></h3>

                        <form name="<?= $user['email']; ?>" class="form-horizontal" action="profilverwaltung.php"
                              method="POST">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Anrede:</label>
                                <div class="col-md-9">
                                    <input name="anrede" class="form-control" type="text"
                                           value="<?= $user['anrede']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">First name:</label>
                                <div class="col-md-9">
                                    <input name="vorname" class="form-control" type="text"
                                           value="<?= $user['vorname']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last name:</label>
                                <div class="col-md-9">
                                    <input name="lname" class="form-control" type="text"
                                           value="<?= $user['nachname']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">E-mail:</label>
                                <div class="col-md-9">
                                    <input name="email" class="form-control" type="text"
                                           value="<?= $user['email']; ?>">
                                    <input name="userId" class="form-control" type="hidden"
                                           value="<?= $user['id_user']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">username:</label>
                                <div class="col-md-9">
                                    <input name="user" class="form-control" type="text"
                                           value="<?= $user['username']; ?>">
                                </div>
                            </div>
                            <div class="form-group">

                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Current Password:</label>
                                <div class="col-md-9">
                                    <input name="current_password" placeholder="****************"
                                           class="form-control" type="password" value="">
                                    <?php if (!empty($password1Err) && $password1Err === "Incorrect current password"): ?>
                                        <div class="errormessage"><?= $password1Err; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group" id="newPasswordFields" style="display: none;">
                                <label class="col-md-3 control-label">New Password:</label>
                                <div class="col-md-9">
                                    <input name="password1" placeholder="****************"
                                           class="form-control" type="password" value="">
                                    <?php if (!empty($currentPassword) && (!empty($password1Err) && $password1Err === "Password is required")): ?>
                                        <div class="errormessage"><?= $password1Err; ?></div>
                                    <?php elseif (!empty($currentPassword) && (!empty($password2Err) && $password2Err === "Passwords do not match")): ?>
                                        <div class="errormessage"><?= $password2Err; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group" id="confirmPasswordField" style="display: none;">
                                <label class="col-md-3 control-label">Confirm Password:</label>
                                <div class="col-md-9">
                                    <input name="password2" placeholder="****************"
                                           class="form-control" type="password" value="">
                                    <?php if (!empty($currentPassword) && (!empty($password2Err) && $password2Err === "Passwords do not match")): ?>
                                        <div class="errormessage"><?= $password2Err; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <!-- Füge den Button für das Anzeigen des Passwortbereichs hinzu -->
                                    <button type="button" id="changePasswordButton" class="btn btn-default">Change
                                        Password
                                    </button>
                                    <span></span>
                                    <input name="saveChanges" type="submit" class="btn btn-primary"
                                           value="Save Changes">
                                    <span></span>
                                    <input type="reset" class="btn btn-default" value="Cancel">
                                    <span></span>
                                    <form action="profilverwaltung.php" method="POST">
                                        <input type="submit" name="delete" class="btn btn-danger"
                                               value="Delete Account">
                                        <input type="hidden" name="userToDelete" value="<?= $user['id_user']; ?>">
                                        <!-- Deaktivieren-Button für den Admin -->
                                        <?php if ($_SESSION['email'] === 'admin@gmail.com'): ?>
                                            <form action="profilverwaltung.php" method="POST">
                                                <?php if ($user['status'] == 'deaktiviert'): ?>
                                                    <input type="submit" name="activate" class="btn btn-success"
                                                           value="Aktivieren">
                                                    <input type="hidden" name="userToActivate" value="<?= $user['id_user']; ?>">
                                                <?php else: ?>
                                                    <input type="submit" name="deactivate" class="btn btn-warning"
                                                           value="Deaktivieren">
                                                    <input type="hidden" name="userToDeactivate" value="<?= $user['id_user']; ?>">
                                                <?php endif; ?>
                                            </form>
                                        <?php endif; ?>
                                    </form>
                                    <br> </br>
                                    <?php
                                    // ...
                                    echo "Gespeicherter Hash: " . $user["email"] . "<br>";
                                    echo "Gespeicherter Hash: " . $user["id_user"] . "<br>";
                                    // ...
                                    ?>
                                    <a href="buchungsinfo.php"><i class="fas fa-bed"></i> Zu den Reservierungen</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                // Hier sollte der Benutzerdatenabruf basierend auf der eingeloggten Session implementiert werden.
                // Die Benutzerdaten, wie z.B. $user_id, können aus der Session oder der Datenbank abgerufen werden.

                // SQL-Abfrage zum Abrufen der Buchungen des Benutzers
                $sql = "SELECT * FROM bookings WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user['id_user']);

                // Führen Sie die Abfrage aus
                if ($stmt->execute()) {
                    // Verarbeiten Sie das Ergebnis hier
                    $bookingResult = $stmt->get_result();

                    // Buchungsdaten in ein Array speichern
                    $bookingData = [];
                    while ($row = $bookingResult->fetch_assoc()) {
                        $bookingData[] = $row;
                    }

                    // Hier kannst du die Buchungsinformationen anzeigen
                    foreach ($bookingData as $booking) {
                        echo "<h3>Buchungsinformationen</h3>";
                        echo "<p>Zimmer: " . htmlspecialchars($booking['zimmer']) . "</p>";
                        echo "<p>Verpflegung: " . htmlspecialchars($booking['verpflegung']) . "</p>";
                        echo "<p>GesamtPreis: " . htmlspecialchars($booking['GesamtPreis']) . "</p>";
                        echo "<p>CheckIn: " . htmlspecialchars($booking['CheckIn']) . "</p>";
                        echo "<p>CheckOut: " . htmlspecialchars($booking['CheckOut']) . "</p>";
                    }
                } else {
                    echo "Fehler bei der Abfrage: " . $stmt->error;
                }

                // Schließen Sie die Anweisung
                $stmt->close();
                ?>
            <?php
            }
        } else {
            echo 'No record found';
        }
        ?>
    </div>

    <!-- Weitere HTML-Elemente und Abschnitte deiner Seite -->

    <!-- JavaScript-Code für das Anzeigen/Verstecken des Passwortfelds -->
    <script>
        document.getElementById("changePasswordButton").addEventListener("click", function () {
            var newPasswordFields = document.getElementById("newPasswordFields");
            var confirmPasswordField = document.getElementById("confirmPasswordField");
            if (newPasswordFields.style.display === "none") {
                newPasswordFields.style.display = "block";
                confirmPasswordField.style.display = "block";
            } else {
                newPasswordFields.style.display = "none";
                confirmPasswordField.style.display = "none";
            }
        });
    </script>
</body>
</html>
