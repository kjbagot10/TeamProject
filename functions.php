function dynListDesc($dbConn, $catIDToCompare)
{ 
    try {
        $sqlCatDescQuery = "SELECT catID, catDesc FROM EGN_categories";
        $sqlCatDescResults = $dbConn->query($sqlCatDescQuery);
        echo "<label>Category</label><br>
        <select name='catID'>";
        while ($categoryRecord = $sqlCatDescResults->fetchObject()) {
        //-- comparing the categoryID that we already have  in $rowObj with the categories in the sqlcatQuery ---
        if ($categoryRecord->catID == $catIDToCompare)
        {
            echo "<option value='{$categoryRecord->catID}' selected>{$categoryRecord->catDesc}</option>";	
        }
        else {
            echo "<option value='{$categoryRecord->catID}'>{$categoryRecord->catDesc}</option>";
        }
    }
    echo "</select>";
    } catch (Exception $e) {
        throw new Exception("Error creating".$e.getMessage(), 0, $e);
   
    } 
}