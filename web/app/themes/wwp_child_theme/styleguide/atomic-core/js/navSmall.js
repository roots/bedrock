var navOpen = [
  { elements: $(".atoms-side"), properties: { top: "0" }, options: { duration: 200} }, 
];
var navClose = [
  { elements: $(".atoms-side"), properties: { top: "-100%" }, options: { duration: 200} }, 
];



$(".atoms-side_show-small").on('click', function(event) {
  
  
  if($('.atoms-side').css('top') == '0px'){ 
  
     $.Velocity.RunSequence(navClose); 
     
  } else { 
     
     $.Velocity.RunSequence(navOpen); 
     
  }

});









//var sideClose = [
//  { elements: $(".atoms-side"), properties: { translateX: "-100%" }, options: { duration: 200} }, 
//  { elements: $(".atoms-main"), properties: { paddingLeft:"40px"}, options: { duration: 200, sequenceQueue: false } },
//  { elements: $(".atoms-side_show"), properties: { left: "7px" }, options: { duration: 300} }
//];
//
//$(".atoms-side_show-small").on('click', function(event) {
//  $.Velocity.RunSequence(sideClose);
//});