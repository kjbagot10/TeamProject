<?php
// need to test this but I think it should work. 
function dynListDesc($dbConn, $catIDToCompare)
{ 
    try {
        // sql query
        $sqlCatDescQuery = "SELECT item_id, user_id, expiry_date, item_name, date_added, storage_type FROM inventory_items"; 
        $sqlResults = $dbConn->query($sqlCatDescQuery);    

        while ($item = $sqlResults->fetchObject()) {
            
            echo "\t<div class='item'>
                    <span class='item_name'>{$item->item_name}</span>
                    <span class='category'>{$item->category}</span>
                    <span class='expiry_date'>{$item->expiry_date}</span>
                    <span class='date_added'>{$item->date_added}</span>
                    <span class='storage_type'>{$item->storage_type}</span>
                    </div>\n";
            }
        

    } catch (Exception $e)
    {
        throw new Exception("Error creating".$e.getMessage(), 0, $e);
    }
}



?>