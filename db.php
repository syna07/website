<?php
$host = 'localhost';
$dbname = 'ecommerce'; // match the DB you created
$username = 'root';
$password = ''; // for XAMPP/WAMP the password is often empty

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
