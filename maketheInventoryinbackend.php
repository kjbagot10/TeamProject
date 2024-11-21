<?php
require 'DatabaseFunctions.php';

function setFoodInventoryTable($pdo) {
    $stmt = $pdo->prepare("SELECT p.item_name, espiry_date, c.category_name, s.storage_type_name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$inventory = getInventory($pdo)
?>