<?php
require "DatabaseFunctions.php";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Add Inventory</title>
    <style>
        .info-tooltip {
            position: relative;
            display: inline-block;
        }

        .info-icon {
            color: #3273dc;
            cursor: pointer;
            margin-left: 10px;
            font-size: 1.2rem;
        }

        .info-content {
            visibility: hidden;
            position: absolute;
            z-index: 1;
            width: 300px;
            background-color: white;
            border-radius: 6px;
            padding: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            left: 30px;
            top: -10px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .info-tooltip:hover .info-content {
            visibility: visible;
            opacity: 1;
        }

        .product-info-item {
            margin: 8px 0;
            display: flex;
            align-items: flex-start;
        }

        .product-info-label {
            font-weight: bold;
            min-width: 140px;
            color: #363636;
        }

        .product-info-value {
            color: #4a4a4a;
        }
		/* autocomplete items by geoo */
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        .predefined-items-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .predefined-items-list div {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .predefined-items-list div:hover {
            background-color: #f5f5f5;
        }

        .modal {
            display: none;
        }

        .modal.is-active {
            display: flex;
        }
    </style>		
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
    </header>

    <div class="container has-text-centered">
        <div class="title is-4">Add Food to Inventory</div>

        <div class="box">
            <form action="addFood.php" method="POST">
                <div class="field">
                    <label class="label" for="barcode">Barcode</label>
                    <div class="control" style="display: flex; align-items: center;">
                        <input class="input" id="barcode" type="text" placeholder="Scan or enter barcode">
                        <button type="button" class="button is-info ml-2" onclick="fetchProductDetails()">Fetch Product</button>
                        <div class="info-tooltip">
                            <i class="fas fa-info-circle info-icon"></i>
                            <div class="info-content" id="productInfo">
                                <div class="product-info-item">
                                    <span class="product-info-label">Barcode:</span>
                                    <span class="product-info-value" id="info-barcode">-</span>
                                </div>
                                <div class="product-info-item">
                                    <span class="product-info-label">Quantity:</span>
                                    <span class="product-info-value" id="info-quantity">-</span>
                                </div>
                                <div class="product-info-item">
                                    <span class="product-info-label">Packaging:</span>
                                    <span class="product-info-value" id="info-packaging">-</span>
                                </div>
                                <div class="product-info-item">
                                    <span class="product-info-label">Brands:</span>
                                    <span class="product-info-value" id="info-brands">-</span>
                                </div>
                                <div class="product-info-item">
                                    <span class="product-info-label">Categories:</span>
                                    <span class="product-info-value" id="info-categories">-</span>
                                </div>
                                <div class="product-info-item">
                                    <span class="product-info-label">Stores:</span>
                                    <span class="product-info-value" id="info-stores">-</span>
                                </div>
                                <div class="product-info-item">
                                    <span class="product-info-label">Countries:</span>
                                    <span class="product-info-value" id="info-countries">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="item_name">Name</label>
                    <div class="control">
                        <div class="field has-addons"> <!-- by geoo -->
                            <div class="control is-expanded">
                                <input class="input" id="item_name" name="item" type="text" 
                                       placeholder="Food Name" required 
                                       oninput="handleAutoComplete(this.value)"> <!-- handle autocomplete -->
                                <div id="autocomplete-list" class="autocomplete-items"></div>
                            </div>
                            <div class="control">
                                <button type="button" class="button is-info" 
                                        onclick="showPredefinedItems()"> <!-- show common items -->
                                    Show Common Items
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="foodType">Food Type</label>
                    <div class="control">
                        <div class="select">
                            <select id="foodType" name="category_name" required>
                                <option value="">Select Food Type</option>
                                <?php echo getCatForAdd($dbConn); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="storageType">Storage Type</label>
                    <div class="control">
                        <div class="select">
                            <select id="storageType" name="storage_type_name" required>
                                <option value="">Select Storage Type</option>
                                <?php echo getStorageForAdd($dbConn); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="expiryDate">Expiry Date</label>
                    <div class="control">
                        <input class="input" id="expiryDate" name="expiry_date" type="date" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Add to Inventory</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="predefinedItemsModal" class="modal"> <!-- by geoo -->
        <div class="modal-background"></div>
        <div class="modal-card"> 
            <header class="modal-card-head">
                <p class="modal-card-title">Common Food Items</p>
                <button class="delete" aria-label="close" onclick="closePredefinedModal()"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <input type="text" class="input" id="predefinedSearchInput" 
                           placeholder="Search items..." oninput="filterPredefinedItems(this.value)">
                </div>
                <div id="predefinedItemsList" class="predefined-items-list">
                    <!-- Items will be populated here -->
                </div>
            </section>
        </div>
    </div>

    <script src="toggleScript.js"></script>
    <script>
    async function fetchProductDetails() {
        const barcode = document.getElementById('barcode').value;
        const url = `https://world.openfoodfacts.net/api/v2/product/${barcode}`;
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Product not found');
            const data = await response.json();
            const product = data.product;
            
            // Update the name field
            document.getElementById('item_name').value = product.product_name || '';
            
            // Update info tooltip content
            document.getElementById('info-barcode').textContent = product.code || '-';
            document.getElementById('info-quantity').textContent = product.quantity || '-';
            document.getElementById('info-packaging').textContent = product.packaging || '-';
            document.getElementById('info-brands').textContent = product.brands || '-';
            document.getElementById('info-categories').textContent = product.categories || '-';
            document.getElementById('info-stores').textContent = product.stores || '-';
            document.getElementById('info-countries').textContent = product.countries || '-';
            
        } catch (error) {
            alert('Error fetching product details: ' + error.message);
        }
    }

    function toggleMenu() {
        var menuContent = document.getElementById("menuContent");
        menuContent.style.display = menuContent.style.display === "block" ? "none" : "block";
    }
    </script>
    <script>
    // Common food items cache
    let commonFoodItems = [];

    // Fetch items from both OpenFoodFacts and local database
    async function fetchCommonFoodItems() {
        try {
            // Fetch from OpenFoodFacts
            const openFoodResponse = await fetch('https://world.openfoodfacts.org/api/v2/search?fields=product_name,code,brands,categories&page_size=100');
            const openFoodData = await openFoodResponse.json();
            const openFoodItems = openFoodData.products.filter(p => p.product_name).map(p => ({ // map the open food data to the common food items
                name: p.product_name,
                barcode: p.code,
                brand: p.brands,
                category: p.categories,
                source: 'openfoodfacts'
            }));

            // Fetch from local database
            const localResponse = await fetch('getCommonItems.php');
            const localItems = await localResponse.json();
            const localMappedItems = localItems.map(item => ({
                name: item.item_name,
                barcode: item.barcode,
                brand: item.brands,
                category: item.categories,
                source: 'local'
            }));

            // Combine both sources
            commonFoodItems = [...localMappedItems, ...openFoodItems];
        } catch (error) {
            console.error('Error fetching common items:', error);
        }
    }

    // When adding a new item, also save to common items
    async function saveToCommonItems(itemData) {
        try {
            const response = await fetch('saveCommonItem.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(itemData)
            });
            const result = await response.json();
            if (result.success) {
                console.log('Item saved to common items');
            }
        } catch (error) {
            console.error('Error saving to common items:', error);
        }
    }

    // Autocomplete function
    function handleAutoComplete(query) {
        const autocompleteList = document.getElementById('autocomplete-list');
        autocompleteList.innerHTML = '';
        
        if (!query) {
            autocompleteList.style.display = 'none';
            return;
        }

        // First show local matches, then OpenFoodFacts matches
        const localMatches = commonFoodItems
            .filter(item => 
                item.source === 'local' && 
                item.name.toLowerCase().includes(query.toLowerCase())
            );
        
        const openFoodMatches = commonFoodItems
            .filter(item => 
                item.source === 'openfoodfacts' && 
                item.name.toLowerCase().includes(query.toLowerCase())
            );

        const matches = [...localMatches, ...openFoodMatches].slice(0, 5);

        if (matches.length > 0) { // if there are matches, show the autocomplete list
            autocompleteList.style.display = 'block';
            matches.forEach(item => {
                const div = document.createElement('div');
                div.innerHTML = `${item.name} ${item.source === 'local' ? '(Local)' : ''}`;
                div.onclick = function() {
                    document.getElementById('item_name').value = item.name;
                    document.getElementById('barcode').value = item.barcode;
                    autocompleteList.style.display = 'none';
                    fetchProductDetails();
                };
                autocompleteList.appendChild(div);
            });
        } else {
            autocompleteList.style.display = 'none';
        }
    }

    // save to common items when user adds a new item geoo
    document.querySelector('form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const itemData = {
            name: document.getElementById('item_name').value,
            barcode: document.getElementById('barcode').value,
            brands: document.getElementById('info-brands').textContent,
            categories: document.getElementById('info-categories').textContent
        };

        // Save to common items
        await saveToCommonItems(itemData);
        
        // Submit the form
        this.submit();
    });

    // Show predefined items
    function showPredefinedItems() {
        const modal = document.getElementById('predefinedItemsModal');
        const itemsList = document.getElementById('predefinedItemsList');
        
        itemsList.innerHTML = '';
        commonFoodItems.forEach(item => {
            const div = document.createElement('div');
            div.innerHTML = `${item.name} ${item.brand ? `(${item.brand})` : ''}`;
            div.onclick = function() {
                document.getElementById('item_name').value = item.name;
                document.getElementById('barcode').value = item.barcode;
                closePredefinedModal();
                fetchProductDetails();
            };
            itemsList.appendChild(div);
        });
        
        modal.classList.add('is-active');
    }

    // Close predefined items modal
    function closePredefinedModal() {
        document.getElementById('predefinedItemsModal').classList.remove('is-active');
    }

    // Filter predefined items
    function filterPredefinedItems(query) {
        const itemsList = document.getElementById('predefinedItemsList');
        itemsList.innerHTML = '';
        
        const filteredItems = commonFoodItems.filter(item =>
            item.name.toLowerCase().includes(query.toLowerCase())
        );
        
        filteredItems.forEach(item => {
            const div = document.createElement('div');
            div.innerHTML = `${item.name} ${item.brand ? `(${item.brand})` : ''}`;
            div.onclick = function() {
                document.getElementById('item_name').value = item.name;
                document.getElementById('barcode').value = item.barcode;
                closePredefinedModal();
                fetchProductDetails();
            };
            itemsList.appendChild(div);
        });
    }

    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.matches('#item_name')) {
            document.getElementById('autocomplete-list').style.display = 'none';
        }
    });

    // Fetch common items when page loads
    document.addEventListener('DOMContentLoaded', fetchCommonFoodItems);
    </script>
</body>
</html>