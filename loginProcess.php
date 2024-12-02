<?php
try {
    require_once "DatabaseFunctions.php";
    require_once "LoginFunctions.php";
    $dbConn = getConnection();
    startSession();
    //User form validation
    [$input, $errors] = validateInput();
    $email = $input["email"];
    $password = $input["password"];

    if (empty($errors)) {
        $selectSQL =
            "SELECT password_hash FROM GROUP_users WHERE email = :email";
        $stmt = $dbConn->prepare($selectSQL);
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        //If username was found
        if ($user) {
            $passwordHash = $user["password_hash"];

            // Check if passwords match
            if (password_verify($password, $passwordHash)) {
                $_SESSION["logged-in"] = true;
                //Sends the user back to the home page
                echo "<script> window.addEventListener('load', function () {
                        window.location.replace('HomePage.php');});
                        </script>";
            } else {
                //If Passwords dont match
                $errors[] = "Password is incorrect";
            }
        } else {
            //If username is not found
            $errors[] = "Username is incorrect";
        }
    } else {
        echo "<p>Failed: " . $e->getMessage() . "</p>\n";
    }
} catch (Exception $e) {
    echo "<p>Query failed: " . $e->getMessage() . "</p>\n";
}
include "loginForm.php";
?>
