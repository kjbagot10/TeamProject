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
 function getCatForAdd($dbConn)
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
                <input type='checkbox' id='{$rowObj->category_id}' value='{$rowObj->category_name}'/>
            </label>
        </div>
        ";
    }
 }

 function setFoodInventoryTable($dbConn): array
 {
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
				WHERE GROUP_inventory_items.user = {$userID}
						"; // need to find where the session data is stored
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>