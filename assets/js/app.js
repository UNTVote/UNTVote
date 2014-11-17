// This file contains global scripts that will be executed on all the pages

$(window).load(function() {
  // Add fade animation
  $('.fade-on-load').fadeIn(500); 
  
  // Initialize tooltips and popovers
  $(function () { 
    $("[data-toggle='tooltip']").tooltip();
    $("[data-toggle='popover']").popover();
  });
  
});