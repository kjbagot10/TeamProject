<?php
require_once "DatabaseFunctions.php";
$dbConn = getConnection();
require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
$userID = $_SESSION["userID"];
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
    <link rel="stylesheet" href="foodInventorystyle.css">
    <!-- Font Awesome for icons -->
    <!-- <style>
      :root {
        --bulma-primary-h: 0deg;
        --bulma-primary-s: 0%;
        --bulma-primary-l: 83%;
        --bulma-link-h: 260deg;
        --bulma-link-s: 60%;
        --bulma-link-l: 65%;
      }

      body {
        font-family: Arial, sans-serif;
        background-color: #d3d3d3;
        color: #000;
      }
      .navbar {
        background-color: #f5f5f5;
      }
      
      .navbar-start {
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    </style> -->
    <title>Food Inventory</title>
    <!-- Title of the webpage -->
  </head>
  <body>
  <header>
      <div class="logo">Logo</div>
      <nav>
        <a href="#">Home</a>
        <a href="#">Something</a>
        <a href="foodInventory.php">Food Inventory</a>
        <a href="wasteManagment.php">Waste Management</a>
        <a href="#">About Us</a>
      </nav>
      <divdiv class="profile-icon" onclick="toggleMenu()">
        <?php echo $isLoggedIn ? strtoupper(substr($userName, 0, 1)) : 'G'; ?>
      </div>
      <div class="dropdown-menu" id="menuContent">
        <?php if ($isLoggedIn): ?>
          <a href="logOut.php">Logout</a>
        <?php else: ?>
          <a href="loginForm.php">Login</a>
        <?php endif; ?>
      </div>
      <script>
        function toggleMenu() {
          var menuContent = document.getElementById("menuContent");
          menuContent.style.display = menuContent.style.display === "block" ? "none" : "block";
        }
      </script>
    </header>
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
