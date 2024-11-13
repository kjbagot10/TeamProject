<?php




// need to test this but I think it should work. 
function preDefListDyn($dbConn, $catIDToCompare)
{ 
    try {
        // sql query
        $sqlCatDescQuery = "SELECT item_id, user_id, expiry_date, item_name, date_added, storage_type FROM inventory_items"; 
        $sqlResults = $dbConn->query($sqlCatDescQuery);    
        echo "<ul class='menu' id='listOfItems'>";
        while ($item = $sqlResults->fetchObject()) 
        {
            
            echo "<li class='menu-item'>
                    <span class='item_name'>{$item->item_name}</span>
                    <span class='category'>{$item->category}</span>
                    <span class='expiry_date'>{$item->expiry_date}</span>
                  </li>\n";
        }
        echo "</ul>";   

    } catch (Exception $e)
    {
        throw new Exception("Error creating".$e.getMessage(), 0, $e);
    }
}

// this could be used for the predefined list
// could remove the query from this and add it to the sortTable Func. 
function dynTable($dbConn)
{
    
    try {
        $sqlCatDescQuery = "SELECT item_id, user_id, expiry_date, item_name, date_added, storage_type FROM inventory_items"; 
        $sqlResults = $dbConn->query($sqlCatDescQuery);
        // the column names for the user. 
        echo "
        <thead>
            <tr>
            <th><abbr title='Item Name'>Name</abbr></th>
                <th>Team</th>
                <th><abbr title='Expiry Date'>Exp Date</abbr></th>
                <th><abbr title='Storage Method'>Strg Meth</abbr></th>
                <th><abbr title='Type'>Typ</abbr></th>
            
            </tr>
        </thead>
        <tbody>
        ";
        // will dynamically create the table cells
        while ($item = $sqlResults->fetchObject())
        {
        echo 
        "
        <tr>
            <td>{$item->item_name}</td>
            <td>{$item->expiry_date}</td>
            <td>{$item->storage_type}</td>
            <td>{$item->category}</td>
        </tr>  
            
        ";
        }
        
         

    }
    catch (Exception $e)
    {
        throw new Exception("Error creating".$e.getMessage(), 0, $e);
    }
}
//-- use this is basically the outline of the finished function
function sortTableFunc($dbConn)
{
    // $value = val of button pressed. Need to figure how I wll do this.
    // Need to figure how to add to the end of the string. 
    $sqlCatDescQuery = "SELECT item_id, user_id, expiry_date, item_name, date_added, storage_type FROM inventory_items ORDER BY {$value}"; 

}
?>