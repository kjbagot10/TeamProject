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
  <>
    <header>
      <div class="logo">Logo</div>
      <nav>
        <a href="#">Home</a>
        <a href="#">Something</a>
        <a href="foodInventory.php">Food Inventory</a>
        <a href="#">Waste Management</a>
        <a href="#">About Us</a>
      </nav>
      <div class="profile-icon" onclick="toggleMenu()">G</div>
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
    <script src="toggleScript.js"></script>
  </body>
</html>
