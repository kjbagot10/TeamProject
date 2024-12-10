<?php

function getConnection()
{
    try {
        $connection = new PDO(
            "mysql:host=nuwebspace_db; dbname=w21018460",
            "w21018460",
            "bpRAtdZ8",
        );
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        throw new Exception("Connection error " . $e->getMessage(), 0, $e);
    }
}

function setPredefTable($dbConn)
{
    $predefinedTable = "";
    //Querry For foodInventory Table
    $sqlQuery = "
        SELECT 
            p.item_name,
            DATE_ADD(CURDATE(), INTERVAL p.average_expiry DAY) AS expiry_date,
            s.storage_type_name,
            c.category_name
        FROM 
            GROUP_predefined_items p
        JOIN 
            GROUP_storage_types s ON p.default_storage_type = s.storage_type_id
        JOIN 
            GROUP_categories c ON p.category = c.category_id;
";
    $queryResult = $dbConn->query($sqlQuery);

    while ($rowObj = $queryResult->fetchObject()) {
        $predefinedTable .= "<tr>
        <td>{$rowObj->item_name}</td>
        <td>{$rowObj->expiry_date}</td> 
        <td>{$rowObj->storage_type_name}</td>
        <td>{$rowObj->category_name}</td>
        </tr> \n";
    }

    return $predefinedTable;
}

 function getCatForSort($dbConn)
  {
    $sqlQuery = "
    SELECT 
        category_id, category_name
    FROM 
        GROUP_categories;
    ";
    $queryResult = $dbConn->query($sqlQuery);
    while ($rowObj = $queryResult->fetchObject())
    {
        echo "
        <div class='dropdown-item'>
            <label class='checkbox'>
                {$rowObj->category_name}
                <input type='checkbox' id='{$rowObj->category_id}' onclick='foodTypeSort()' value='{$rowObj->category_name}'/>
            </label>
        </div>
        ";
    }
 }


 function getCatForAdd($dbConn) {
    $sqlQuery = "
    SELECT 
        category_id, category_name
    FROM 
        GROUP_categories;
    ";
    $queryResult = $dbConn->query($sqlQuery);
    while ($rowObj = $queryResult->fetchObject()) {
        echo "<option value='{$rowObj->category_id}'>" . htmlspecialchars($rowObj->category_name, ENT_QUOTES, 'UTF-8') . "</option>";
    }
}

 function setFoodInventoryTable($dbConn, $userID): string
 {
    $inventoryTable = "";
  
    $sql = "SELECT GROUP_inventory_items.item_name, GROUP_inventory_items.expiry_date, GROUP_categories.category_name, GROUP_storage_types.storage_type_name, DATE(GROUP_inventory_items.date_added) as date_added FROM    GROUP_inventory_items INNER JOIN GROUP_categories ON GROUP_inventory_items.category = GROUP_categories.category_id INNER JOIN GROUP_storage_types ON GROUP_inventory_items.storage_type = GROUP_storage_types.storage_type_id WHERE GROUP_inventory_items.user_id = {$userID};";

    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $inventoryTable .= "<tr>
            <td>{$row['item_name']}</td>
            <td>{$row['expiry_date']}</td> 
            <td>{$row['storage_type_name']}</td>
            <td>{$row['category_name']}</td>
            <td>{$row['date_added']}</td>
            </tr> \n";
    }
    return $inventoryTable;   
}

function getStorageForSort($dbConn)
{
    $sql = "SELECT * FROM GROUP_storage_types;";
    $queryResult = $dbConn->query($sql);
    while ($rowObj = $queryResult->fetchObject())
    {
        echo "
        <div class='dropdown-item'>
            <label class='checkbox'>
                {$rowObj->storage_type_name}
                <input type='checkbox' id='{$rowObj->storage_type_id}' value='{$rowObj->storage_type_name}'/>
            </label>
        </div>
        ";
    }

}

function getUserNameByID($userID)
{
    $dbConn = getConnection();
    $sqlQuery = "SELECT username FROM GROUP_users WHERE user_id = :userID";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute(["userID" => $userID]);
    $userName = $stmt->fetchColumn();
    return $userName;
}
?>