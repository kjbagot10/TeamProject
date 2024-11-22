<?php
// Include database connection
require 'databaseconnection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password_hash'] ?? '';

    if (!empty($user) && !empty($pass)) {
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password_hash', $hashedPassword);
            $stmt->execute();
            echo "Signup successful!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Both fields are required.";
    }
}
?>
