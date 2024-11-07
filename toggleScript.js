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



const maindropdownTrigger = document.querySelector('#main-trigger');
const maindropdownMenu = document.querySelector('#big-dropdown');

maindropdownTrigger.addEventListener('click', (event) =>
  {
    event.stopPropagation();
    // Toggle the "is-active" class
    maindropdownMenu.classList.toggle("is-active");
  }
);

// useless for now. 
// const typeDropDownTrig = document.querySelector('#type-drop-trig');
// const typeMenu = document.querySelector('#type-dropdown');

// typeDropDownTrig.addEventListener('click', (event) =>
//   {
//     event.stopPropagation();
//     // Toggle the "is-active" class
//     // typeDropDownTrig.classList.toggle("is-active");
//     typeMenu.classList.toggle("is-active");
//   }
// );


// could dynamically create it





