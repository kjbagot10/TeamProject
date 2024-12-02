<?php

function startSession()
{
    if (session_status() == PHP_SESSION_NONE) {
        ini_set("session.save_path", "0;644;/var/www/html/TeamProject/sessionData");
        session_start();
    }
}

function checkLogin()
{
    return isset($_SESSION["logged-in"]);
}
function validateInput()
{
    $input = []; // Create array for form input
    $errors = []; // Create empty array for errors

    // Retrieve input, trim, remove special charaters and store in $input array
    foreach ($_POST as $key => $value) {
        $input[$key] = getdata($key);
    }

    //Check is field is empty
    foreach ($input as $key => $value) {
        $errors[] = isEmpty($input[$key], $key);
    }

    //Check field length
    if (isset($input["email"])) {
        $errors[] = isEmpty($input["email"], "email");
    }

    if (isset($input["newPassword"])) {
        $errors[] = validatePassword($input["newPassword"]);
    }

    // Remove null errors and return an array of $input and $errors
    $errors = array_values(array_filter($errors));
    return [$input, $errors];
}

function getData($data)
{
    return filter_has_var(INPUT_POST, $data)
        ? htmlspecialchars(trim($_POST[$data]))
        : "";
}
function isEmpty($data, $key)
{
    if (empty($data)) {
        return $key . " must not be empty";
    }
}
function checkLength($data, $key, $length)
{
    if (strlen($data) > $length) {
        return $key . " must not be greater than " . $length . " characters";
    }
}

function isValidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
    }
}

function validatePassword($password)
{
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    }

    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }

    if (!preg_match('/[\W]/', $password)) {
        $errors[] = "Password must contain at least one special character";
    }

    return $errors;
}

function dispayLoginError($input, $data)
{
    echo '<script> 
        loginForm.email.value ="' .
        $input["email"] .
        '" ;
        loginForm.password.value ="' .
        $input["password"] .
        '" ;
    </script>';

    foreach ($data as $error) {
        echo '<span style="color: red;">' .
            $error .
            '</span>
        <br>';
    }
}

?>