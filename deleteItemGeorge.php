<?php
require 'DatabaseFunctions.php';
require_once "LoginFunctions.php"; //connect user login
startSession();

if (!checkLogin()) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $data);
    $itemId = $data['id'];
    $userID = $_SESSION["userID"]; // get user id

    try {
        $dbConn = getConnection();
        $stmt = $dbConn->prepare('DELETE FROM GROUP_inventory_items WHERE item_id = :id AND user_id = :user_id'); // delete item from inventory with user id
        $stmt->bindParam(':id', $itemId, PDO::PARAM_INT); // bind  ids
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT); 
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else { //error handling
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>