<?php
require_once "DatabaseFunctions.php";

header('Content-Type: application/json');

try {
    $dbConn = getConnection();
    $sql = "SELECT p.item_name, p.category, p.default_storage_type,
            c.category_name, s.storage_type_name
            FROM GROUP_predefined_items p
            LEFT JOIN GROUP_categories c ON p.category = c.category_id
            LEFT JOIN GROUP_storage_types s ON p.default_storage_type = s.storage_type_id";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($items);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>