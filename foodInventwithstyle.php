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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <title>Food Inventory</title>
    <style>
      body {
        background-color: #f8f9fa;
      }
      .search-bar {
        margin: 20px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
      }
      .inventory-table {
        margin: 20px auto;
        width: 90%;
        border-collapse: collapse;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .inventory-table th,
      .inventory-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      .inventory-table th {
        background-color: #f0f0f0;
        font-weight: bold;
      }
      .footer-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px auto;
      }
      .footer-buttons button {
        background-color: #7d5fff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
      }
      .footer-buttons button:hover {
        background-color: #5a3bff;
      }
      .sort-container {
        margin: 20px auto;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
      }
      .dropdown {
        margin-bottom: 10px;
      }
    </style>
  </head>
  <body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" href="#">Home</a>
          <a class="navbar-item" href="#">Information</a>
          <a class="navbar-item" href="#">Food Inventory</a>
          <a class="navbar-item" href="#">Waste Management</a>
          <a class="navbar-item" href="#">About Us</a>
        </div>
        <div class="navbar-end">
          <div class="navbar-item">
            <figure class="image is-24x24">
              <img src="user-icon.png" alt="User" />
            </figure>
          </div>
        </div>
      </div>
    </nav>

    <div class="title is-4 has-text-centered">My Food Inventory</div>

    <div class="sort-container">
      <div class="dropdown" id="sortAZ">
        <div class="dropdown-trigger" onclick="toggleDrop('#sortAZ')">
          <button
            class="button"
            aria-haspopup="true"
            aria-controls="dropdown-menu"
          >
            <span>Sort By</span>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
          <div class="dropdown-content">
            <div class="dropdown-item">
              <label class="checkbox">
                A-Z
                <input type="checkbox" id="ascend-alpha" />
              </label>
            </div>
            <div class="dropdown-item">
              <label class="checkbox">
                Z-A
                <input type="checkbox" id="descend-alpha" />
              </label>
            </div>
            <div class="dropdown-item">
              <label class="checkbox">
                Nearest - Furthest
                <input type="checkbox" id="nearest-date" />
              </label>
            </div>
            <div class="dropdown-item">
              <label class="checkbox">
                Furthest - Nearest
                <input type="checkbox" id="furthest-date" />
              </label>
            </div>
            <div class="dropdown-item">
              <label class="checkbox">
                Most recently added
                <input type="checkbox" id="recently-added" />
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="dropdown" id="typeChkboxes">
        <div class="dropdown-trigger" onclick="toggleDrop('#typeChkboxes')">
          <button
            class="button"
            aria-haspopup="true"
            aria-controls="dropdown-menu"
          >
            <span>Filter By Type</span>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
          <div class="dropdown-content">
            <?php getCatForSort($dbConn); ?>
          </div>
        </div>
      </div>

      <div class="dropdown" id="storageChkboxes">
        <div class="dropdown-trigger" onclick="toggleDrop('#storageChkboxes')">
          <button
            class="button"
            aria-haspopup="true"
            aria-controls="dropdown-menu"
          >
            <span>Filter By Storage method</span>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
          <div class="dropdown-content">
            <?php getStorageForSort($dbConn); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="search-bar">
      <input
        class="input"
        type="text"
        id="myInput"
        onkeyup="searchByNameFunc()"
        placeholder="Search for food items"
      />
      <button class="button">
        <i class="fas fa-filter"></i>
      </button>
    </div>

    <table class="inventory-table">
      <thead>
        <tr>
          <th>Food Item</th>
          <th>Expiry Date</th>
          <th>Storage Method</th>
          <th>Item Type</th>
          <th>Date Added</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($isLoggedIn) {
          $userID = $_SESSION["userID"];
          echo setFoodInventoryTable($dbConn, $userID);
        } else {
          echo '<tr><td colspan="5">Please log in to view your inventory.</td></tr>';
        }
        ?>
      </tbody>
    </table>

    <div class="footer-buttons">
      <button>View Inventory</button>
      <button>Add to Inventory</button>
      <button>View Recipes</button>
    </div>

    <script src="toggleScript.js"></script>
  </body>
</html>
