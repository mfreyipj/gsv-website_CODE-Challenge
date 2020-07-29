
    function showAnswerForm(){
      var popUpWindow = document.getElementById("answerForm");
      console.log("POPUP!");
      popUpWindow.classList.toggle("showMessage");
    }

    /*function that enables the interactive use of the dropdown-button*/
    function dropDownHamburger(){
        var dropdownbtn = document.getElementById("hamburgerButton");
        // Toggle class "is-active"
       dropdownbtn.classList.toggle("is-active");

        /* When the user clicks on the button, toggle between hiding and showing the dropdown content */
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // function that is used to show or hide the dropdown at the user-icon
    function dropDownUser(){
      document.getElementById("userMenuDropDown").classList.toggle("show");
    }

//Smooth Scrolling

// Select all links with hashes
$('a[href*="#"]')
 // Remove links that don't actually link to anything
 .not('[href="#"]')
 .not('[href="#0"]')
 .click(function(event) {
   // On-page links
   if (
     location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
     &&
     location.hostname == this.hostname
   ) {
     // Figure out element to scroll to
     var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
     // Does a scroll target exist?
     if (target.length) {
       // Only prevent default if animation is actually gonna happen
       event.preventDefault();
       $('html, body').animate({
         scrollTop: target.offset().top
       }, 1000, function() {
         // Callback after animation
         // Must change focus!
         var $target = $(target);
         $target.focus();
         if ($target.is(":focus")) { // Checking if the target was focused
           return false;
         } else {
           $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
           $target.focus(); // Set focus again
         };
       });
     }
   }
 });


 /*-----------Javascript-Skripte-----------*/


 // var nav = document.querySelector('.nav');
 // var position = 0;
 //
 // window.addEventListener('scroll', function(){
 //   if(position < window.pageYOffset) {
 //     //console.log('down')
 //     nav.classList += ' up';
 //     position = window.pageYOffset;
 //   } else {
 //     //console.log('up');
 //     nav.classList = 'nav'
 //     position = window.pageYOffset;
 // }
 //
 //
