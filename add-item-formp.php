<?php
require "DatabaseFunctions.php";
$dbConn = getConnection();

require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
if ($isLoggedIn):
  $userID = $_SESSION["userID"];
  $userName = getUserNameByID($userID);
endif;
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
  <link rel="stylesheet" href="add-inventory.css">
  
  <title>Add Item Form</title>
</head>
<body>
  <header>
    <div class="logo">Logo</div>
    <nav>
        <a href="HomePage.php">Home</a>
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
    <div class="title is-4">Add Food to Inventory</div>

    <div class="box">
      <form action="addFood.php" method="POST">
        <div class="field">
          <label class="label" for="name">Name</label>
          <div class="control">
            <input class="input" id="item_name" name="item" type="text" placeholder="Food Name" required>
          </div>
        </div>

        <div class="field">
          <label class="label" for="foodType">Food Type</label>
          <div class="control">
            <div class="select">
              <select id="foodType" name="category_name" required>
              <option value="">Select Food Type</option>
                <?php echo getCatForAdd($dbConn); ?>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label" for="storageType">Storage Type</label>
          <div class="control">
            <div class="select">
              <select id="storageType" name="storage_type_name" required>
                <option value="">Select Food Type</option>
                <?php echo getStorageForAdd($dbConn); ?>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label" for="expiryDate">Expiry Date</label>
          <div class="control">
            <input class="input" id="expiryDate" name="expiry_date" type="date" required>
          </div>
        </div>

        <div class="field">
          <div class="control">
            <button type="submit" class="button is-primary">Add to Inventory</button>
          </div>
        </div>
      </form>
      <a href="foodInventory.php" class="button">View Inventory</a> <!-- Button to view inventory -->

    </div>
  </div>
</body>
</html>
