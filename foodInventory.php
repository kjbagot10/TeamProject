<?php
require_once "DatabaseFunctions.php";
$dbConn = getConnection();
require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
$userID = checkUserId();
$userName = getUserNameByID($userID);
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
  <body>
    <nav class="navbar" role="navigation" aria-label="main navigation"></nav>
    <div class="title is-4">My Food Inventory</div>
    <!-- Title for the inventory -->

    <input
      type="text"
      id="myInput"
      onkeyup="searchByNameFunc()"
      placeholder="Search for names.."
      title="Type in a name"
    />
    <!-- beginning of the sortbyAz  -->
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
              <input type="checkbox" id="ascend-alpha"/>
            </label>
          </div>
          <div class="dropdown-item">
            <label class="checkbox">
              Z-A
              <input type="checkbox" id="descend-alpha"/>
            </label>
          </div>
          <div class="dropdown-item">
            <label class="checkbox">
              Nearest - Furthest
              <input type="checkbox" id="nearest-date"/>
            </label>
          </div>
          <div class="dropdown-item">
            <label class="checkbox">
              Furthest - Nearest
              <input type="checkbox" id="furthest-date"/>
            </label>
          </div>
          <div class="dropdown-item">
            <label class="checkbox">
              Most recently added
              <input type="checkbox" id="recently-added">
            </label>
          </div>
        </div>
      </div>
    </div>
    <!-- beginnning of type filter dropdonw  -->
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
          <?php getCatForSort($dbConn) ?>
        </div>
      </div>
    </div>

    <!-- beginning of category filter type -->
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
          <?php getStorageForSort($dbConn)?>
        </div>
      </div>
    </div>
    
    <table id="inventoryTable" class="table">
      <thead>
        <tr>
          <th><abbr title="Item Name">Name</abbr></th>
          <th><abbr title="Expiry Date">Expiry Date</abbr></th>
          <th><abbr title="Storage Method">Storage Method</abbr></th>
          <th><abbr title="Type">Item Type</abbr></th>
          <th><abbr title="Date added">Date Added</abbr></th>
        </tr>
      </thead>
      <tbody>
        <!-- need to change this -->
        <?php echo setFoodInventoryTable($dbConn, $userID=7) ?> 
      </tbody>
    </table>

    <script src="toggleScript.js"></script>
  </body>
</html>
