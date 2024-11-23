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
    
    //
    
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
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }

}


function foodTypeSort() {
  // Get all checkboxes
  const checkboxes = document.querySelectorAll('#typeChkboxes input[type="checkbox"]');

  // Collect the values of checked checkboxes
  const selectedTypes = Array.from(checkboxes)
      .filter(checkbox => checkbox.checked) // Only checked boxes
      .map(checkbox => checkbox.value); // Get their values

  // Get the table rows
  const table = document.getElementById("inventoryTable");
  const rows = table.getElementsByTagName("tr");

  // If no checkboxes are selected, show all rows
  if (selectedTypes.length === 0) {
      for (let i = 1; i < rows.length; i++) {
          rows[i].style.display = ""; // Reset to visible
      }
      return; // Exit the function
  }
  console.log("Selected Types:", selectedTypes);

  // Loop through table rows and show/hide based on selection
  for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header
      const typeCol = rows[i].getElementsByTagName("td")[3]; // Type column (index 3)
      if (typeCol) {
          const cellValue = typeCol.innerText.trim();
          // Show row if type matches selectedTypes; otherwise, hide it
          rows[i].style.display = selectedTypes.includes(cellValue) ? "" : "none";
      }
  }
}

  




