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
  <title>Food Inventory Form</title>
</head>
<body>
  <div class="container has-text-centered">
    <div class="title is-4">Add Food to Inventory</div>

    <div class="box">
      <form action="addFood.php" method="POST">
        <div class="field">
          <label class="label" for="name">Name</label>
          <div class="control">
            <input class="input" id="name" name="name" type="text" placeholder="Food Name" required>
          </div>
        </div>

        <div class="field">
          <label class="label" for="foodType">Food Type</label>
          <div class="control">
            <select id="foodType" name="foodType" required>
            <option value="">Select Food Type</option>
            <? echo getCatForAdd($dbConn); ?>
            </select>
          </div>
        </div>

        <div class="field">
          <label class="label" for="storageType">Storage Type</label>
          <div class="control">
            <div class="select">
              <select id="storageType" name="storageType" required>
                <option value="">Select Storage Type</option>
                <option value="Refrigerated">Refrigerated</option>
                <option value="Frozen">Frozen</option>
                <option value="Shelf">Shelf</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label" for="expiryDate">Expiry Date</label>
          <div class="control">
            <input class="input" id="expiryDate" name="expiryDate" type="date" required>
          </div>
        </div>

        <div class="field">
          <div class="control">
            <button type="submit" class="button is-primary">Add to Inventory</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
