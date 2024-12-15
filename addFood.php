<?php
require_once "DatabaseFunctions.php";
$dbConn = getConnection();
require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
$userID = $_SESSION["userID"];
$userName = getUserNameByID(userID: $userID);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form inputs
  $item_name = htmlspecialchars($_POST['item_name']);
  $category_name = htmlspecialchars($_POST['category_name']);
  $expiry_date = htmlspecialchars($_POST['expiry_date']);
  $storage_type_name = htmlspecialchars($_POST['storage_type_name']);
  $quantity = htmlspecialchars($_POST['quantity']);  // You need to get quantity from the form
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
      echo "<p>Your food has been added into your inventory successfully!<p>";
  } else {
      echo "Error: " . $stmt->errorInfo()[2];
  }
  
} else {
  // Handle cases where the script is accessed directly
  echo "<h3>Error: Please submit the form correctly.</h3>";
}

?>