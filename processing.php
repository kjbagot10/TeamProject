<?php
require 'connecting_databaseforinventory.php'; // Ensure this contains a valid PDO connection in $pdo

try {
    // Function to fetch inventory data
    function fetchInventoryData($pdo): array {
        $sql = "
            SELECT 
                GROUP_inventory_items.item_name,
                GROUP_inventory_items.expiry_date,
                GROUP_categories.category_name AS category_name,
                GROUP_storage_types.storage_type_name AS storage_type_name
            FROM 
                GROUP_inventory_items
            INNER JOIN 
                GROUP_categories ON GROUP_inventory_items.category = GROUP_categories.category_id
            INNER JOIN 
                GROUP_storage_types ON GROUP_inventory_items.storage_type = GROUP_storage_types.storage_type_id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as an associative array
    }

    // Fetch inventory data
    $inventory = fetchInventoryData($pdo);

    // Display the inventory data
    foreach ($inventory as $item) {
        echo "Item Name: " . htmlspecialchars($item['item_name']) . "<br>";
        echo "Expiry Date: " . htmlspecialchars($item['expiry_date']) . "<br>";
        echo "Category: " . htmlspecialchars($item['category_name']) . "<br>";
        echo "Storage Type: " . htmlspecialchars($item['storage_type_name']) . "<br><br>";
    }

} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . htmlspecialchars($e->getMessage());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $item_name = htmlspecialchars($_POST['item_name']);
    $category_name = htmlspecialchars($_POST['category_name']);
    $expiry_date = htmlspecialchars($_POST['expiry_date']);
    $storage_type_name = htmlspecialchars($_POST['storage_type_name']);
    echo "<h3>Your food has been added into your inventory successfully!</h3>";
} else {
    // Handle cases where the script is accessed directly
    echo "<h3>Error: Please submit the form correctly.</h3>";
}
?>
