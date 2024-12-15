<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
  <title>Food Inventory</title>
</head>
<body>
  <!-- Header Section -->
  <header>
    <div class="logo">Logo</div>
    <nav>
        <a href="HomePage.php">Home</a>
        <a href="#">Something</a>
        <a href="foodInventory.php">Food Inventory</a>
        <a href="wasteManagment.php">Waste Management</a>
        <a href="#">About Us</a>
    </nav>
    <div class="profile-icon">⚙️</div>
  </header>

  <!-- Greeting Section -->
  <section class="greeting">
    <p>Hey [Username]!</p>
  </section>

  <!-- Statistics Section -->
  <section class="stats-container">
    <div class="stat-card">
      <h2>Food Saved</h2>
      <p>10 kg saved this month</p>
    </div>
    <div class="stat-card">
      <h2>Waste Reduced</h2>
      <p>5 kg reduced</p>
    </div>
    <div class="stat-card">
      <h2>Sort My Waste</h2>
      <div class="upload-icon">⬆️</div>
      <p>Upload Image</p>
    </div>
  </section>

  <!-- Table Section -->
  <section class="table-container">
    <h3>Foods Expiring Soon</h3>
    <input
      type="text"
      id="myInput"
      onkeyup="searchByNameFunc()"
      placeholder="Search food items"
      class="input"
    />
    <table class="table" id="inventoryTable">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Food Item</th>
          <th>Expiring In</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Carrot</td>
          <td>2 days</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Beetroots</td>
          <td>1 day</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Milk</td>
          <td>1 day</td>
        </tr>
      </tbody>
    </table>
  </section>
</body>
</html>