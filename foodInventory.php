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

    <div class="dropdown" id="sortAZ">
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
              <input type="checkbox" id="ascend-alpha"/>
            </label>
          </div>
          <div class="dropdown-item">
            <label class="checkbox">
              Z-A
              <input type="checkbox" id="descend-alpha"/>
            </label>
          </div>
        </div>
      </div>
    </div>
  
    <table id="inventoryTable" class="table">
      <thead>
        <tr>
          <th><abbr title="Item Name">Name</abbr></th>
          <th><abbr title="Expiry Date">Exp Date</abbr></th>
          <th><abbr title="Storage Method">Strg Meth</abbr></th>
          <th><abbr title="Type">Typ</abbr></th>
        </tr>
      </thead>
      <tbody>
        <?php echo setFoodInventoryTable($dbConn) ?>
      </tbody>
    </table>
    <div class="field" id="typeChkboxes">
      <label class="checkbox">
        Meat
        <input type="checkbox" id="meat-check" onclick="foodTypeSort()" value="Meats"/>
      </label>
      <label class="checkbox">
        Grains
        <input type="checkbox" id="grains-check" onclick="foodTypeSort()" value="Grains"/>
      <label class="checkbox">
        Dairy
        <input type="checkbox" id="dairy-check" onclick="foodTypeSort()" value="Dairy"/>
      </label>
      <label class="checkbox">
        Produce
        <input type="checkbox" id="produce-check" onclick="foodTypeSort()" value="Produce"/>
      </label>
    </div>

    <script src="toggleScript.js"></script>
  </body>
</html>
