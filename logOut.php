<?php
session_start();
//Removes any data in Session
$_SESSION = [];
//Clears any cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"],
    );
}
//Destroys the session
session_destroy();
//Redirect back to homepage
echo "<script> window.addEventListener('load', function () {
    window.location.replace('HomePage.php');});
    </script>";
?>
