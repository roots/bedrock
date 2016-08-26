if ($(".atoms-code-example")[0]){
    $(".js-hideTitle").on('click', function(event) {
      if($('.compTitle').css('opacity') == '0'){ 
         $(this).css('color','#fff');
         $(".compTitle").velocity({
            opacity: "1",
         }, {
            duration: 200
         });
      } else { 
         $(this).css('color','#247695');
         $(".compTitle").velocity({
            opacity: "0",
         }, {
            duration: 200
         });
      }
    });
}