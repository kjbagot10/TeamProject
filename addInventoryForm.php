<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensures responsiveness on mobile devices -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"> <!-- Bulma CSS framework for styling -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->

<title>Add Inventory</title> <!-- Title of the webpage -->

</head>
<body>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation"></nav>


<div class="container has-text-centered"> <!-- Main container centered on the page -->
		<div class="title is-4">My Food Inventory</div> <!-- Title for the inventory -->

		<div class="fixed-grid has-3-cols"> <!-- Custom grid layout with 3 columns -->
				<div class="grid">
						<div class="cell is-col-span-3 is-primary"> <!-- Primary colored cell spanning 3 columns -->
								<div class="box"> <!-- Box element for styling -->
										<div class="grid">
												<div class="cell">
														<div class="title is-6">Add Barcode</div>
														<div class="icon is-small">
																<i class="fas fa-plus"></i>
														</div>
												</div>

												<div class="cell is-col-start-2">
														<label for="label">Product Name</label>
														<input class="input" type="text" placeholder="Product Name" /> <!-- Text input field -->
												</div>
												<div class="cell is-row-start-2 is-col-start-2">
														<label for="label">Expiry Date</label>
														<input class="input" type="date" placeholder="Expiry Date" /> <!-- Text input field -->
												</div>
												<div class="cell is-row-start-3 is-col-start-2">
														<label for="label">Type</label>
														<input class="input" type="date" placeholder="Expiry Date" /> <!-- Text input field -->
												</div>

										</div>
										

								</div>
						</div>
						<div class="cell is-row-start-2"> <!-- Second row cell for buttons -->
								<div class="button">View Recipes</div> <!-- Button to view recipes -->
						</div>
						<div class="cell is-row-start-2"> <!-- Second row cell for buttons -->
								<a href="addInventoryForm.html" class="button">Add To Inventory</a> <!-- Button to add items to inventory -->
						</div>
						<div class="cell is-row-start-2"> <!-- Second row cell for buttons -->
								<a href="foodInventory.php" class="button">View Inventory</a> <!-- Button to view inventory -->
						</div>
				</div>
		</div>
</div>

<script src="toggleScript.js"></script>

</body>
</html>

</body>
</html>