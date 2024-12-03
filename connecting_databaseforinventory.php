<?php
$host = 'nuwebspace';
$dbname = 'w21018460';
$username ='w21018460';
$password = 'bpRAtdZ8';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database is not connecting: " . $e->getMessage());
}
?>