<?php
require_once "DatabaseFunctions.php";
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


$htmlToDisplay = "
<!DOCTYPE html>
<html lang=\"en\">
  
  <head>
  
    <meta charset=\"UTF-8\" />
    <!-- Sets the character encoding for the document -->
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    <!-- Ensures responsiveness on mobile devices -->
    <link
      rel=\"stylesheet\"
      href=\"https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css\"
    />
    <!-- Bulma CSS framework for styling -->
    <link
      rel=\"stylesheet\"
      href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css\"
    />
    <link rel=\"stylesheet\" href=\"foodInventorystyle.css\">
    
    <title>Food Inventory</title>
    <!-- Title of the webpage -->
  </head>
  <body>
  <header>
      <div class=\"logo\">Logo</div>
      <nav>
        <a href=\"HomePage.php\">Home</a>
        <a href=\"#\">Something</a>
        <a href=\"foodInventory.php\">Food Inventory</a>
        <a href=\"wasteManagment.php\">Waste Management</a>
        <a href=\"#\">About Us</a>
      </nav>
      <div class=\"profile-icon\" onclick=\"toggleMenu()\">
        <?php echo \$isLoggedIn ? strtoupper(substr(\$userName, 0, 1)) : 'G'; ?>
      </div>
      <div class=\"dropdown-menu\" id=\"menuContent\">
        <?php if (\$isLoggedIn): ?>
          <a href=\"logOut.php\">Logout</a>
        <?php else: ?>
          <a href=\"loginForm.php\">Login</a>
        <?php endif; ?>
      </div>
      <script>
        function toggleMenu() {
          var menuContent = document.getElementById(\"menuContent\");
          menuContent.style.display = menuContent.style.display === \"block\" ? \"none\" : \"block\";
        }
      </script>
    </header>

";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form inputs
  $item_name = htmlspecialchars($_POST['item']);
  $category_name = htmlspecialchars($_POST['category_name']);
  $expiry_date = htmlspecialchars($_POST['expiry_date']);
  $storage_type_name = htmlspecialchars($_POST['storage_type_name']);
  $quantity = NULL;  // You need to get quantity from the form
  $current_date = date('Y-m-d');
  $barcode_num = NULL;  // You can set this to NULL if you're not using barcode numbers
  
  // Prepare the SQL statement
  $stmt = $dbConn->prepare("INSERT INTO GROUP_inventory_items (user_id, barcode_number, item_name, quantity, expiry_date, date_added, storage_type, category) 
                            VALUES (:user_id, :barcode_number, :item_name, :quantity, :expiry_date, :date_added, :storage_type, :category)");
  
  // Bind parameters
  $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
  $stmt->bindParam(':barcode_number', $barcode_num, PDO::PARAM_STR);  // Use NULL or a string for barcode
  $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
  $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
  $stmt->bindParam(':expiry_date', $expiry_date, PDO::PARAM_STR);
  $stmt->bindParam(':date_added', $current_date, PDO::PARAM_STR);
  $stmt->bindParam(':storage_type', $storage_type_name, PDO::PARAM_STR);
  $stmt->bindParam(':category', $category_name, PDO::PARAM_STR);
  
  // Execute the statement
  if ($stmt->execute()) {
    echo $htmlToDisplay;
    echo "
    <p>Item successfully added</p>
    <a href='foodInventory.php'>Go to food inventory</a>
    ";
    
  } else {
      echo "Error: " . $stmt->errorInfo()[2];
  }
  
} else {
  // Handle cases where the script is accessed directly
  echo "<h3>Error: Please submit the form correctly.</h3>";
}




?>