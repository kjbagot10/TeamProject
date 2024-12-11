<?php
require_once "DatabaseFunctions.php";
require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <header>
      <div class="logo">Logo</div>
      <nav>
        <a href="#">Home</a>
        <a href="loginForm.php">LogIn</a>
        <a href="#">Food Inventory</a>
        <a href="#">Waste Management</a>
        <a href="#">About Us</a>
      </nav>
      <div class="profile-icon">M</div>
    </header>

    <main>
      <?php
      require_once "DatabaseFunctions.php";

      if ($isLoggedIn) {
        $userID = $_SESSION['userID'];
        $userName = getUserNameByID($userID);
        echo "<p>Welcome back, User $userName!</p>";
      } else {
        echo "<h1>Welcome, Guest!</h1>";
      }
      ?>
      <div class="cards">
        <div class="card">
          <p>Food Saved</p>
        </div>
        <div class="card">
          <p>Waste Reduced</p>
        </div>
        <div class="card">
          <p>Sort My Waste</p>
          <button>Upload Image</button>
        </div>
      </div>
    </main>
  </body>
</html>
