<?php
try {
    require_once "DatabaseFunctions.php"; // Contains database connection logic
    require_once "LoginFunctions.php"; // Contains input validation functions
    $dbConn = getConnection();

    // Validate input from the registration form
    [$input, $errors] = validateInput();
    $name = $input["name"];
    $email = $input["email"];
    $newPassword = $input["newPassword"];
    $confirmPassword = $input["confirmPassword"];
    // Ensure there are no validation errors
    if (empty($errors)) {
        // Check if email already exists in the database
        $checkEmailSQL = "SELECT email FROM GROUP_users WHERE email = :email";
        $stmt = $dbConn->prepare($checkEmailSQL);
        $stmt->execute(["email" => $email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = "An account with this email already exists.";
        } else {
            // Check if passwords match
            if ($newPassword !== $confirmPassword) {
                $errors[] = "Passwords do not match.";
            } else {
                // Hash the password securely
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Insert new user into the database
                $insertSQL = "
                    INSERT INTO GROUP_users (username, email, password_hash)
                    VALUES (:name, :email, :passwordHash)";
                $stmt = $dbConn->prepare($insertSQL);
                $stmt->execute([
                    "name" => $name,
                    "email" => $email,
                    "passwordHash" => $passwordHash,
                ]);

                // Redirect to the login page
                echo "<script>
                        window.addEventListener('load', function () {
                            alert('Account created successfully. Please log in.');
                            window.location.replace('loginForm.php');
                        });
                      </script>";
                exit; // Ensure no further processing occurs
            }
        }
    }
} catch (Exception $e) {
    // Handle database or unexpected errors
    echo "<p>Query failed: " . $e->getMessage() . "</p>\n";
}

// If errors exist, include the create account form with error messages
include "registerForm.php";
?>