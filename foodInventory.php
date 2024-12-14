<?php
require_once "DatabaseFunctions.php";
$dbConn = getConnection();
require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
$userID = checkUserId();
$userName = getUserNameByID(userID: $userID);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Sets the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Ensures responsiveness on mobile devices -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
    />
    <!-- Bulma CSS framework for styling -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <!-- Font Awesome for icons -->

    <title>Food Inventory</title>
    <!-- Title of the webpage -->
  </head>
    <nav class="navbar" role="navigation" aria-label="main navigation"></nav>
    <div class="container has-text-centered">
       <!-- Title for the inventory -->
      <div class="title is-4">My Food Inventory</div>
        <div class="container has-text-centered">
            <!-- need to change this -->
            <?php 
            if ($isLoggedIn)
            {
              $userID = $_SESSION["userID"];
              echo viewInventoryTable($dbConn, $userID);
            }
            else
            {
              echo '
              <p>Please sign in or create an account.</p>
              <p><a href="loginForm.php">Log in</a></p>
              <p><a href="registerForm.php">Register Form</a></p>
              ';
            }
            ?> 
        </div>
    </div>

    <script src="toggleScript.js"></script>
  </body>
</html>
