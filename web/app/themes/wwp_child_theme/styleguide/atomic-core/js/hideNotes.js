/*var notesClose = [
  { elements: $(".compNotes"), properties: {opacity: "0" }, options: { duration: 200, sequenceQueue: false } }, 
];*/



if ($(".compNotes").is(':empty')){

}
else {
  $(".js-hideNotes").on('click', function(event) {
    if($('.compNotes').css('opacity') == '0'){ 
       $(this).css('color','#fff');

       $(".compNotes").velocity({
          opacity: "1",
       }, {
          duration: 200
       });
    } else { 
       $(this).css('color','#247695');
       $(".compNotes").velocity({
          opacity: "0",
       }, {
          duration: 200
       });
    }
  });

}
