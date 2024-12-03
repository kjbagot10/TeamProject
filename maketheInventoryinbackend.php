<?php
require 'DatabaseFunctions.php';

try {
    // SQL query to fetch inventory items with joined categories and storage types
    $sql = "
        SELECT 
            GROUP_inventory_items.item_id,
            GROUP_inventory_items.user_id,
            GROUP_inventory_items.barcode_number,
            GROUP_inventory_items.item_name,
            GROUP_inventory_items.quantity,
            GROUP_inventory_items.expiry_date,
            GROUP_inventory_items.date_added,
            GROUP_storage_types.storage_type_name AS storage_type,
            GROUP_categories.category_name AS category
        FROM 
            GROUP_inventory_items
        INNER JOIN 
            GROUP_categories ON GROUP_inventory_items.category = GROUP_categories.category_name
        INNER JOIN 
            GROUP_storage_types ON GROUP_inventory_items.storage_type = GROUP_storage_types.storage_type_name
    ";

    // Define a function to fetch inventory data
    function setFoodInventoryTable($pdo): array {
        $sql = "
            SELECT 
                GROUP_inventory_items.item_name,
                GROUP_inventory_items.expiry_date,
                GROUP_categories.category_name,
                GROUP_storage_types.storage_type_name
            FROM 
                GROUP_inventory_items
            INNER JOIN 
                GROUP_categories ON GROUP_inventory_items.category = GROUP_categories.category_name
            INNER JOIN 
                GROUP_storage_types ON GROUP_inventory_items.storage_type = GROUP_storage_types.storage_type_name
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch the inventory data
    $inventory = setFoodInventoryTable($pdo);

    // Debug output (optional, for testing)
    foreach ($inventory as $item) {
        echo "Item Name: " . $item['item_name'] . "<br>";
        echo "Expiry Date: " . $item['expiry_date'] . "<br>";
        echo "Category: " . $item['category_name'] . "<br>";
        echo "Storage Type: " . $item['storage_type_name'] . "<br><br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
