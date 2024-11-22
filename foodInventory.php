<?php
require "DatabaseFunctions.php";
$dbConn = getConnection();
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

    <div class="dropdown">
      <div class="dropdown-trigger">
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
              <input type="checkbox" onclick="sortTable('asc')" />
            </label>
          </div>
          <div class="dropdown-item">
            <label class="checkbox">
              Z-A
              <input type="checkbox" onclick="sortTable('desc')" />
            </label>
          </div>

          <a class="dropdown-item"> Other dropdown item </a>
          <a href="#" class="dropdown-item"> Active dropdown item </a>
          <a href="#" class="dropdown-item"> Other dropdown item </a>
          <hr class="dropdown-divider" />
          <a href="#" class="dropdown-item"> With a divider </a>
        </div>
      </div>
    </div>

    <table id="inventoryTable" class="table">
      <thead>
        <tr>
          <th><abbr title="Item Name">Food item</abbr></th>
          <th><abbr title="Expiry Date">Expiry Date</abbr></th>
          <th><abbr title="Storage Method">Storage Method</abbr></th>
          <th><abbr title="Type">Type</abbr></th>
        </tr>
      </thead>
      <tbody>
        <?php echo setFoodInventoryTable($dbConn) ?>
      </tbody>
    </table>
    <script src="toggleScript.js"></script>
  </body>
</html>
