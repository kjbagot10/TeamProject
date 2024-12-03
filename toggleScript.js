// --- all the navHTML is in the navHTML.html file
const navhtml = 
`
    <!-- navbar brand -->
    <div class="navbar-brand">
      <a href="#" class="navbar-item">LOGO</a>
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
        <a href="#" class="navbar-item">Home</a>
        <a href="#" class="navbar-item">Food Inventory</a>
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
function toggleDrop(dropdownId)
{
  const maindropdownMenu = document.querySelector(dropdownId);
  maindropdownMenu.classList.toggle("is-active");

}


const ascAlphaChk = document.getElementById("ascend-alpha");
const descAlphChk = document.getElementById("descend-alpha");

ascAlphaChk.addEventListener("click", function () {
  if (ascAlphaChk.checked) {
    descAlphChk.checked = false; // Uncheck Z-A
    sortTableAlpha("asc"); // Apply A-Z sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking A-Z
  }
});

descAlphChk.addEventListener("click", function () {
  if (descAlphChk.checked) {
    ascAlphaChk.checked = false; // Uncheck A-Z
    sortTableAlpha("desc"); // Apply Z-A sort
  } else {
    console.log("Sorting cleared."); // Optional: handle unchecking Z-A
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


const nfCheckbox = document.getElementById("nearest-date");
const fnCheckbox = document.getElementById("furthest-date");

nfCheckbox.addEventListener("click", function () {
  if (nfCheckbox.checked)
  {
    fnCheckbox.checked = false;
    sortTableByDate(true);
  }
})

fnCheckbox.addEventListener("click", function () {
  if (fnCheckbox.checked)
  {
    nfCheckbox.checked = false;
    sortTableByDate(false);
  }
})

function sortTableByDate(isAscending) {
  const table = document.getElementById("inventoryTable");
  const rows = Array.from(table.getElementsByTagName("tr")).slice(1); // Skip the header row

  rows.sort((rowA, rowB) => {
    const dateA = new Date(rowA.getElementsByTagName("td")[1].innerText.trim());
    const dateB = new Date(rowB.getElementsByTagName("td")[1].innerText.trim());

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

