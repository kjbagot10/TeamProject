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

function setFoodInventoryTable($dbConn)
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
        $predefinedTable .= "<tr><td>{$rowObj->item_name}</td>
                            <td>{$rowObj->expiry_date}</td> 
                            <td>{$rowObj->storage_type_name}</td>
                            <td>{$rowObj->category_name}</td></tr> \n";
    }

    return $predefinedTable;
}

?>