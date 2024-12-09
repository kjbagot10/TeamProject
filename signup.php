<?php
// Include database connection
require 'connecting_databaseforinventory.php';

$error = ""; // Initialize the error message variable

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? ''; // Correct variable name
    $email = $_POST['email'] ?? ''; // Fix $POST to $_POST
    $password_hash = $_POST['password_hash'] ?? ''; // Correct variable name
    $confirm_password = $_POST['confirm_password'] ?? ''; // Fix $POST to $_POST

    // Validation
    if (empty($username) || empty($email) || empty($password_hash) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($password_hash !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $password_hash = password_hash($password_hash, PASSWORD_DEFAULT);

        // Prepare SQL query to insert user data
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

        if ($stmt->execute()) {
            echo "<p>Registration successful! <a href='login.html'>Login here</a>.</p>";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Display error if it exists
if (!empty($error)) {
    echo "<p class='error'>$error</p>";
}
?>
