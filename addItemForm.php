<?php
require "DatabaseFunctions.php";
$dbConn = getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Add Inventory</title>
</head>
<body>
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation"></nav>

  <div class="container has-text-centered">
    <div class="title is-4">My Food Inventory</div>

    <div class="fixed-grid has-3-cols">
      <div class="grid">
        <div class="cell is-col-span-3 is-primary">
          <div class="box">
            <div class="grid">
              <div class="cell is-row-start-1">
                <label for="productName">Product Name</label>
                <input class="input" id="productName" type="text" placeholder="Product Name" />
              </div>
              <div class="cell is-row-start-2">
                <label for="expiryDate">Expiry Date</label>
                <input class="input" id="expiryDate" type="date" placeholder="Expiry Date" />
              </div>
              <div class="cell is-row-start-3">
                <label for="type">Type</label>
                <div class="dropdown" id="formTypeChkboxes">
                  <div class="dropdown-trigger">
                    <button class="button" aria-controls="dropdown-menu" aria-haspopup="true" onclick="toggleDrop('#formTypeChkboxes')">
                      <span>Type</span>
                      <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                      </span>
                    </button>
                  </div>
                  <div class="dropdown-menu" id="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                      <?php echo getCatForAdd($dbConn); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="cell is-row-start-2">
          <a href="viewRecipes.html" class="button">View Recipes</a>
        </div>
        <div class="cell is-row-start-2">
          <a href="addInventoryForm.html" class="button">Add To Inventory</a>
        </div>
        <div class="cell is-row-start-2">
          <a href="foodInventory.html" class="button">View Inventory</a>
        </div>
      </div>
    </div>
  </div>

  <script src="toggleScript.js" defer></script>
</body>
</html>
