// --- all the navHTML is in the navHTML.html file
const navhtml = 
`
    <div class="navbar-brand">
      <a href="homepage.html" class="navbar-item">LOGO</a>
      
      <!-- nav burger -->
      <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>

    </div>

    <!-- navbar menu -->
    <div class="navbar-menu" id="navMenu">
      <div class="navbar-start">
        <a href="HomePage.php" class="navbar-item">Home</a>
        <a href="#" class="navbar-item">Information</a>
        <a href="foodInventory.php" class="navbar-item">Food Inventory</a>
        <a href="wasteManagment.php" class="navbar-item">Waste Management</a>
        <a href="#" class="navbar-item">About us</a>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">Icon</div>
      </div>
    </div>



  
`;


//-- getting the navbar item and changing the inner html - should be donse server but I dont know how.
const navbarComplete = document.querySelector('.navbar');
navbarComplete.innerHTML = navhtml;

// -- these line select the burger and the menu. Th
const burgerIcon = document.querySelector('.navbar-burger');
const navbarMenu = document.querySelector('#navMenu');


//--- all of below is for the burger menu function
burgerIcon.addEventListener('click', () =>
  {
    // Toggle the "is-active" class
    burgerIcon.classList.toggle("is-active");
    navbarMenu.classList.toggle("is-active");
  }
);

// toggle for the dropdowns
// function toggleDrop(dropdownId)
// {
//   const maindropdownMenu = document.querySelector(dropdownId);
//   maindropdownMenu.classList.toggle("is-active");

// }
function toggleDrop(dropdownId) {
  const maindropdownMenu = document.querySelector(dropdownId);

  // Toggle the dropdown menu visibility
  maindropdownMenu.classList.toggle("is-active");

  // Add a one-time event listener to the document to detect clicks outside
  function handleOutsideClick(event) {
    if (!maindropdownMenu.contains(event.target)) {
      maindropdownMenu.classList.remove("is-active");
      document.removeEventListener("click", handleOutsideClick);
    }
  }

  // Attach the event listener if the menu is now active
  if (maindropdownMenu.classList.contains("is-active")) {
    setTimeout(() => {
      document.addEventListener("click", handleOutsideClick);
    }, 0); // Timeout to prevent the click event that toggled the menu from immediately closing it
  }
}


const ascAlphaChk = document.getElementById("ascend-alpha");
const descAlphChk = document.getElementById("descend-alpha");
const nearestFurthest = document.getElementById("nearest-date");
const furthestNearest = document.getElementById("furthest-date");
const recentlyAdded = document.getElementById("recently-added");

ascAlphaChk.addEventListener("click", function () {
  if (ascAlphaChk.checked) {
    descAlphChk.checked = false; // Uncheck Z-A
    furthestNearest.checked = false; // uncheck furthest to nearest
    nearestFurthest.checked = false; // uncheck nearest to furthest
    recentlyAdded.checked = false;
    sortTableAlpha("asc"); // Apply A-Z sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking A-Z
  }
});

descAlphChk.addEventListener("click", function () {
  if (descAlphChk.checked) {
    ascAlphaChk.checked = false; // Uncheck A-Z
    furthestNearest.checked = false; // uncheck furthest to nearest
    nearestFurthest.checked = false; // uncheck nearest to furthest
    recentlyAdded.checked = false;
    sortTableAlpha("desc"); // Apply Z-A sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking Z-A
  }
});

nearestFurthest.addEventListener("click", function () {
  if (nearestFurthest.checked) {
    furthestNearest.checked = false; // Uncheck furthest to nearest
    ascAlphaChk.checked = false; // Uncheck A-Z
    descAlphChk.checked = false; // Uncheck Z-A
    recentlyAdded.checked = false;
    sortTableByDate(true); // Apply nearest to furthest sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking nearest to furthest
  }
});

furthestNearest.addEventListener("click", function () {
  if (furthestNearest.checked) {
    nearestFurthest.checked = false; // Uncheck nearest to furthest
    ascAlphaChk.checked = false; // Uncheck A-Z
    descAlphChk.checked = false; // Uncheck Z-A
    recentlyAdded.checked = false;
    sortTableByDate(false); // Apply furthest to nearest sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking furthest to nearest
  }
});

recentlyAdded.addEventListener("click", function () {
  if (recentlyAdded.checked) {
    nearestFurthest.checked = false; // Uncheck nearest to furthest
    ascAlphaChk.checked = false; // Uncheck A-Z
    descAlphChk.checked = false; // Uncheck Z-A
    furthestNearest.checked = false;
    sortTableByDate(false, col=4); // Apply furthest to nearest sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking furthest to nearest
  }
});


function sortTableAlpha(asc) 
{
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("inventoryTable");
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) 
  {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    
      /* Loop through all table rows (except the
    first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) 
      {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("td")[0];
        y = rows[i + 1].getElementsByTagName("td")[0];
         
        if (asc == "asc")
        {
          // Check if the next row is alphabetically lower than current
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) 
          {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
        // descending alphabetical
        else if (asc == "desc")
        {
          // check if the next row is alphabetically higher than current
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) 
            {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
        }
      }
      if (shouldSwitch) 
        {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
        }
  }

  
}

function searchByNameFunc() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("inventoryTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; // selects the name column 
    if (td) {
      txtValue = td.textContend || td.innerText;
      if (txtValue.toUpperCase().startsWith(filter)) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }

}

function foodTypeSort() {
  // Get all type checkboxes
  const typecheckboxes = document.querySelectorAll('#typeChkboxes input[type="checkbox"]');
  const selectedTypes = Array.from(typecheckboxes)
      .filter(checkbox => checkbox.checked)
      .map(checkbox => checkbox.value); // Get values of checked checkboxes
  
  console.log("selectedTypes:", selectedTypes);

  // Get all storage checkboxes
  const storagechkboxes = document.querySelectorAll('#storageChkboxes input[type="checkbox"]');
  const selectedStorage = Array.from(storagechkboxes)
      .filter(checkbox => checkbox.checked)
      .map(checkbox => checkbox.value); // Get values of checked checkboxes

  console.log("selectedStorage:", selectedStorage);

  // Get the table rows
  const table = document.getElementById("inventoryTable");
  const rows = table.getElementsByTagName("tr");

  // If no checkboxes are selected, show all rows
  if (selectedTypes.length === 0 && selectedStorage.length === 0) {
      for (let i = 1; i < rows.length; i++) {
          rows[i].style.display = ""; // Reset to visible
      }
      return;
  }

  // Loop through table rows and show/hide based on selection
  for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header
      const typeCol = rows[i].getElementsByTagName("td")[3]; // Type column
      const storageCol = rows[i].getElementsByTagName("td")[2]; // Storage column

      const typeMatches = selectedTypes.length === 0 || (typeCol && selectedTypes.includes(typeCol.innerText.trim()));
      const storageMatches = selectedStorage.length === 0 || (storageCol && selectedStorage.includes(storageCol.innerText.trim()));

      console.log("Row", i, "typeMatches:", typeMatches, "storageMatches:", storageMatches);
      console.log(storageCol.innerText);

      rows[i].style.display = (typeMatches && storageMatches) ? "" : "none"; // Both filters must match
  }
}

function sortTableByDate(isAscending, col=1) {
  const table = document.getElementById("inventoryTable");
  const rows = Array.from(table.getElementsByTagName("tr")).slice(1); // Skip the header row

  rows.sort((rowA, rowB) => {
    const dateA = new Date(rowA.getElementsByTagName("td")[col].innerText.trim());
    const dateB = new Date(rowB.getElementsByTagName("td")[col].innerText.trim());

    // Toggle sorting order
    if (isAscending) {
      return dateA - dateB; // Ascending
    } else {
      return dateB - dateA; // Descending
    }
  });

  // Reorder rows and toggle sorting order
  rows.forEach(row => table.getElementsByTagName("tbody")[0].appendChild(row));
  isAscending = !isAscending; // Toggle the sorting order for the next click
}

