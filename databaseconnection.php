<?php
$host = 'nuwebspace';
$dbname = 'w21018460';
$username = 'w21018460';
$password = 'bpRAtdZ8';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
