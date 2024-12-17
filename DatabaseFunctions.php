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

// cat options of sorting
 function getCatForSort($dbConn): string
  {
    $stringTo = "";
    $sqlQuery = "
    SELECT 
        *
    FROM 
        GROUP_categories;
    ";
    $queryResult = $dbConn->query($sqlQuery);
    while ($rowObj = $queryResult->fetchObject())
    {
        $stringTo .= "
        <div class='dropdown-item'>
            <label class='checkbox'>
                {$rowObj->category_name}
                <input type='checkbox' id='{$rowObj->category_id}' value='{$rowObj->category_name}' onclick='foodTypeSort()'/>
            </label>
        </div>
        ";
    }
    return $stringTo;
 }

// cat options for adding
 function getCatForAdd($dbConn): string  {

    $sqlQuery = "
    SELECT 
        category_id, category_name
    FROM 
        GROUP_categories;
    ";
    $stringToShow = "";
    $queryResult = $dbConn->query($sqlQuery);
    while ($rowObj = $queryResult->fetchObject()) {
        $stringToShow .= "<option value='{$rowObj->category_id}'>{$rowObj->category_name}</option>";
    }
    return $stringToShow;
}

 

// getting storage to use for sort
function getStorageForSort($dbConn): string
{
    $stringTo = "";
    $sql = "SELECT * FROM GROUP_storage_types;";
    $queryResult = $dbConn->query($sql);
    while ($rowObj = $queryResult->fetchObject())
    {
        $stringTo .= "
        <div class='dropdown-item'>
            <label class='checkbox'>
                {$rowObj->storage_type_name}
                <input type='checkbox' id='{$rowObj->storage_type_id}' value='{$rowObj->storage_type_name}' onclick='foodTypeSort()'/>
            </label>
        </div>
        ";
    }
    return $stringTo;

}

// storage for adding
function getStorageForAdd($dbConn)
{
    $stringToShow = "";
    $sql = "SELECT * FROM GROUP_storage_types;";
    $queryResult = $dbConn->query($sql);
    while ($rowObj = $queryResult->fetchObject()) {
        $stringToShow .= "<option value='{$rowObj->storage_type_id}'>{$rowObj->storage_type_name}</option>";
    }
    return $stringToShow;

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

// sets the inventory table
function setFoodInventoryTable($dbConn, $userID): string
{
    $inventoryTable = "";
    $sql = "SELECT GROUP_inventory_items.item_id, GROUP_inventory_items.item_name, GROUP_inventory_items.expiry_date, GROUP_categories.category_name, 
        GROUP_storage_types.storage_type_name, DATE(GROUP_inventory_items.date_added) as date_added -- added id to post to the database 
    FROM  GROUP_inventory_items 
    INNER JOIN GROUP_categories ON GROUP_inventory_items.category = GROUP_categories.category_id
    INNER JOIN GROUP_storage_types ON GROUP_inventory_items.storage_type = GROUP_storage_types.storage_type_id 
    WHERE GROUP_inventory_items.user_id = :userID;";

    $stmt = $dbConn->prepare($sql);
    $stmt->execute(["userID" => $userID]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $inventoryTable .= "<tr>
            <td>{$row['item_name']}</td>
            <td>{$row['expiry_date']}</td> 
            <td>{$row['storage_type_name']}</td>
            <td>{$row['category_name']}</td>
            <td>{$row['date_added']}</td>
            <td><input type='checkbox' class='item-checkbox' data-item-id='{$row['item_id']}'></td> <!-- checkbox to select items -->   

            </tr> \n";
    }
    return $inventoryTable;   
}

// viewInventoryTable
function viewInventoryTable($dbConn, $userID)
{
    $htmlString = '
    <input
        type="text"
        id="myInput"
        onkeyup="searchByNameFunc()"
        placeholder="Search for names.."
        title="Type in a name"
    />
    <!-- beginning of the sortbyAz -->
    <div class="dropdown" id="sortAZ">
        <div class="dropdown-trigger" onclick="toggleDrop(\'#sortAZ\')">
            <button
                class="button is-link"
                aria-haspopup="true"
                aria-controls="dropdown-menu"
            >
                <span>Sort By</span>
                <span class="icon is-small">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
            <div class="dropdown-content">
                <div class="dropdown-item">
                    <label class="checkbox">
                        A-Z
                        <input type="checkbox" id="ascend-alpha"/>
                    </label>
                </div>
                <div class="dropdown-item">
                    <label class="checkbox">
                        Z-A
                        <input type="checkbox" id="descend-alpha"/>
                    </label>
                </div>
                <div class="dropdown-item">
                    <label class="checkbox">
                        Nearest - Furthest
                        <input type="checkbox" id="nearest-date"/>
                    </label>
                </div>
                <div class="dropdown-item">
                    <label class="checkbox">
                        Furthest - Nearest
                        <input type="checkbox" id="furthest-date"/>
                    </label>
                </div>
                <div class="dropdown-item">
                    <label class="checkbox">
                        Most recently added
                        <input type="checkbox" id="recently-added">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- beginning of type filter dropdown -->
    <div class="dropdown" id="typeChkboxes">
        <div class="dropdown-trigger" onclick="toggleDrop(\'#typeChkboxes\')">
            <button
                class="button is-link"
                aria-haspopup="true"
                aria-controls="dropdown-menu"
            >
                <span>Filter By Type</span>
                <span class="icon is-small">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
            <div class="dropdown-content">';
    $htmlString .= getCatForSort($dbConn); // Concatenate the output of getCatForSort
    $htmlString .= '</div>
        </div>
    </div>

    <!-- beginning of category filter type -->
    <div class="dropdown" id="storageChkboxes">
        <div class="dropdown-trigger" onclick="toggleDrop(\'#storageChkboxes\')">
            <button
                class="button is-link"
                aria-haspopup="true"
                aria-controls="dropdown-menu"
            >
                <span>Filter By Storage method</span>
                <span class="icon is-small">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
            <div class="dropdown-content">';
    $htmlString .= getStorageForSort($dbConn); // Concatenate the output of getStorageForSort
    $htmlString .= '</div>
        </div>
    </div>

    <table id="inventoryTable" class="table is-striped is-narrow is-fullwidth">
        <thead>
            <tr>
                <th><abbr title="Item Name">Name</abbr></th>
                <th><abbr title="Expiry Date">Expiry Date</abbr></th>
                <th><abbr title="Storage Method">Storage Method</abbr></th>
                <th><abbr title="Type">Item Type</abbr></th>
                <th><abbr title="Date added">Date Added</abbr></th>
                <th><abbr title="Select">Select</abbr></th>

            </tr>
        </thead>
        <tbody>';
    $htmlString .= setFoodInventoryTable($dbConn, $userID); // Add table rows
    $htmlString .= '
        </tbody>
    </table>
    ';

    echo $htmlString;
}
// get common items from predefined items table geoo
function getCommonItems($dbConn) {
    $sql = "SELECT item_name, category, default_storage_type FROM GROUP_predefined_items";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addToCommonItems($dbConn, $itemData) { // add to common items when user adds a new item  to predefined items table geoo
    try {
        $sql = "INSERT INTO GROUP_predefined_items (item_name, category, default_storage_type) 
                VALUES (:name, :category, :storage)
                ON DUPLICATE KEY UPDATE 
                category = :category,
                default_storage_type = :storage";
        
        $stmt = $dbConn->prepare($sql);
        $stmt->execute([
            ':name' => $itemData['name'],
            ':category' => $itemData['category'],
            ':storage' => $itemData['storage']
        ]);
        return true;
    } catch (Exception $e) {
        error_log("Error adding to common items: " . $e->getMessage());
        return false;
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
?>