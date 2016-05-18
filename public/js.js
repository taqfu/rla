
$(document.body).ready(function () {
    $("input.filter").prop('checked', true);
    $(document).on("change", ".filter", function (event) {
        $("#"+event.target.id).prop('checked') 
          ? $("."+event.target.id+"_achievement").show() 
          : $("."+event.target.id+"_achievement").hide();
    });
});
