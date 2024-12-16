<?php
require_once "DatabaseFunctions.php";
$dbConn = getConnection();
require_once "LoginFunctions.php";
startSession();
//Checks if the user is logged in
$isLoggedIn = checkLogin();
if ($isLoggedIn):
  $userID = $_SESSION["userID"];
  $userName = getUserNameByID($userID);
endif;
echo "<script>const isLoggedIn = '$isLoggedIn';</script>";
?>


<!DOCTYPE html>
<html lang="en">
  
  <head>
  
    <meta charset="UTF-8" />
    <!-- Sets the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Ensures responsiveness on mobile devices -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
    />
    <!-- Bulma CSS framework for styling -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="foodInventorystyle.css">
    <title>Food Inventory</title>
    <!-- Title of the webpage -->
  </head>
  <body>
  <header>
      <div class="logo">Logo</div>
      <nav>
        <a href="HomePage.php">Home</a>
        <a href="#">Something</a>
        <a href="foodInventory.php">Food Inventory</a>
        <a href="wasteManagment.php">Waste Management</a>
        <a href="#">About Us</a>
      </nav>
      <div class="profile-icon" onclick="toggleMenu()">
        <?php echo $isLoggedIn ? strtoupper(substr($userName, 0, 1)) : 'G'; ?>
      </div>
      <div class="dropdown-menu" id="menuContent">
        <?php if ($isLoggedIn): ?>
          <a href="logOut.php">Logout</a>
        <?php else: ?>
          <a href="loginForm.php">Login</a>
        <?php endif; ?>
      </div>
      <script>
        function toggleMenu() {
          var menuContent = document.getElementById("menuContent");
          menuContent.style.display = menuContent.style.display === "block" ? "none" : "block";
        }
      </script>
    </header>
    <div class="container has-text-centered">
       <!-- Title for the inventory -->
      <div class="title is-4">My Food Inventory</div>
      
      <!-- Add this delete button here -->
      <div class="delete-controls">
          <button id="deleteSelectedBtn" class="button is-danger" onclick="deleteSelectedItems()" disabled>
              Delete Selected Items
          </button>
      </div>

      <div class="container has-text-centered">
          <!-- need to change this -->
          <?php 
          if ($isLoggedIn)
          {
              $userID = $_SESSION["userID"];
              echo viewInventoryTable($dbConn, $userID);
          }
          else
          {
              echo '
              <p>Please sign in or create an account.</p>
              <p><a href="loginForm.php">Log in</a></p>
              <p><a href="registerForm.php">Register Form</a></p>
              ';
          }
          ?> 
      </div>
        <a href="addInventoryFormGeorge.php" class="button">Add To Inventory</a> <!-- Button to add items to inventory -->

    </div>
    
    <script src="toggleScript.js"></script>
    <script> //by George
    document.addEventListener('DOMContentLoaded', function() {
        // activate delete button when items are selected
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateDeleteButton);
        });
    });
// update delete button when items are selected
    function updateDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        const deleteButton = document.getElementById('deleteSelectedBtn');
        deleteButton.disabled = checkedBoxes.length === 0;
    }
// delete items when delete button is clicked
    async function deleteSelectedItems() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        const itemIds = Array.from(checkedBoxes).map(cb => cb.dataset.itemId);
        // confirm deletion
        if (!confirm('Are you sure you want to delete the selected items?')) {
            return;
        }
        // delete items
        for (const id of itemIds) {
            try {
                const response = await fetch('deleteItemGeorge.php', { 
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                });

                const result = await response.json();
                if (result.success) {
                    // remove from the table
                    const row = document.querySelector(`input[data-item-id="${id}"]`).closest('tr');
                    row.remove();
                } else {
                    alert('Error deleting item: ' + result.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error deleting item');
            }
        }
        
        updateDeleteButton();
    }
    </script>
  </body>
</html>
