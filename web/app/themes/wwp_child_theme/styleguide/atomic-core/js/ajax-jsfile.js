$(document).ready(function(){
    $(".form-create-jsfile").on("change", "input:checkbox", function(){
        $(this).parent(".form-create-jsfile").submit();
    });
});
