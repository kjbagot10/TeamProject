// --- all the navHTML is in the navHTML.html file
const navhtml = 
`
    <!-- navbar brand -->
    <div class="navbar-brand">
      <a href="homepage.html" class="navbar-item">LOGO</a>
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
        <a href="homepage.html" class="navbar-item">Home</a>
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
  });


