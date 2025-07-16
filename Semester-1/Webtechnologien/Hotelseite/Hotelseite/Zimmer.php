<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zimmerauswahl</title>
    <link rel="stylesheet" href="css/zimmer.css">
</head>
</body>
</html>

<img class="logo" src="/res/img/images.jpg" alt="Logo">
    <div class="container">
        <h1>Verfügbare Zimmer</h1>
        <?php
    include 'navbar.php';
?>
        <div class="zimmer">
            <div class="zimmer-auswahl" onclick="window.location.href='buchung.php?zimmer=Einzelzimmer'">
                <img src="assets/Einzelzimmer.jpg" alt="Einzelzimmer">
                <p>Einzelzimmer</p>
                <p>180,-€/Nacht</p>
                <a href="buchung.php?zimmer=Einzelzimmer" class="buchen-link">Buchen</a>
            </div>

            <div class="zimmer-auswahl" onclick="window.location.href='buchung.php?zimmer=Doppelzimmer'">
                <img src="assets/doppelzimmer.jpg" alt="Doppelzimmer">
                <p>Doppelzimmer</p>
                <p>230,-€/Nacht</p>
                <a href="buchung.php?zimmer=Doppelzimmer" class="buchen-link">Buchen</a>
            </div>

            <div class="zimmer-auswahl" onclick="window.location.href='buchung.php?zimmer=Suite'">
                <img src="assets/Suite.jpg" alt="Suite">
                <p>Suite</p>
                <p>300,-€/Nacht</p>
                <a href="buchung.php?zimmer=Suite" class="buchen-link">Buchen</a>
            </div>
        </div>
    </div>

    <p class="back-to-home"><a href="Homepage.php">Zurück zur Startseite</a></p>

</body>
</html>
