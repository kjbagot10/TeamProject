<?php
require_once "DatabaseFunctions.php";

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $dbConn = getConnection();
    
    $sql = "INSERT INTO GROUP_predefined_items 
            (item_name, category, default_storage_type) 
            VALUES (:name, :category, :storage)
            ON DUPLICATE KEY UPDATE 
            category = :category,
            default_storage_type = :storage";
    
    $stmt = $dbConn->prepare($sql);
    $result = $stmt->execute([
        ':name' => $data['name'],
        ':category' => $data['category'],
        ':storage' => $data['storage']
    ]);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 