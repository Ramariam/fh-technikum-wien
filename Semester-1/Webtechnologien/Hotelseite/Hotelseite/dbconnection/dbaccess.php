<?php
$host = "localhost";
$user = "Admin"; // Default XAMPP MySQL user
$password = "Admin123"; // Default XAMPP MySQL password
$database = "hotel_del_luna";


// Create a new MySQLi object
$db_obj = new mysqli($host, $user, $password);

// Check the connection
if ($db_obj->connect_error) {
    die("Connection Error: " . $db_obj->connect_error);
}

// Create the database if it doesn't exist
$create_db_query = "CREATE DATABASE IF NOT EXISTS $database";



// Select the created/available database
$db_obj->select_db($database);

// Create table
$query = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anrede VARCHAR(255) NOT NULL,
    vorname VARCHAR(255) NOT NULL,
    nachname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    passwort VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL
)";


// Close the connection when you're done
//$db_obj->close();
?>


