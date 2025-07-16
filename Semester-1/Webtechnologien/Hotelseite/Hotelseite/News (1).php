<?php
// News.php
include 'dbaccess (1).php'; // Assuming this file establishes the database connection
include 'navbar.php';

// Fetch news data from the database
$sql = "SELECT * FROM news ORDER BY publish_date DESC"; // Adjust the query as needed
$result = $db_obj->query($sql);

$newsData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newsData[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <style>
        .news-post {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        .thumbnail {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php
if (isset($newsData) && is_array($newsData)) {
    foreach ($newsData as $news) {
        echo '<div class="news-post">';

        echo '<h2>' . htmlspecialchars($news['Title'] ?? 'Kein Titel vorhanden') . '</h2>';
        echo '<p>' . htmlspecialchars($news['Text'] ?? 'Kein Text vorhanden') . '</p>';

        // Check if 'image' index exists and is not null, and if the file actually exists
        if (!empty($news['Image']) && file_exists($news['Image'])) {
            echo '<img src="' . htmlspecialchars($news['Image']) . '" width="200" height="200" alt="News Thumbnail" class="thumbnail">';
        } else {
            echo '<p>Kein Bild vorhanden.</p>';
        }

        // Check if 'publish_date' index exists and is not null
        echo '<p>Veröffentlicht am: ' . htmlspecialchars($news['Publish_date'] ?? 'Kein Veröffentlichungsdatum vorhanden') . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>Keine News verfügbar.</p>';
}

?>

<!-- Formular zum Bearbeiten einer News -->

</body>
</html>
