
$(document.body).ready(function () {
    $("input.filter").prop('checked', true);
    $(document).on("change", ".filter", function (event) {
        $("#"+event.target.id).prop('checked') 
          ? $("."+event.target.id+"_achievement").show() 
          : $("."+event.target.id+"_achievement").hide();
    });
    $(document).on("click", ".show_new_comment", function (event) {
        var id_num = event.target.id.substr(16, event.target.id.length-16);
        console.log(id_num);
        $("#show_new_comment" + id_num).hide();
        $("#new_comment"+id_num).show();
    });
    $(document).on("click", ".hide_new_comment", function (event) {
        var id_num = event.target.id.substr(16, event.target.id.length-16);
       
        $("#show_new_comment" + id_num).show();
        $("#new_comment"+id_num).hide();
    });
    $(document).on("click", ".show_comments", function (event) {
        var id_num = event.target.id.substr(13, event.target.id.length-13);
        $("#show_comments" + id_num).hide();
        $("#hide_comments" + id_num).show();
        $("#comments"+id_num).show();
    });
    $(document).on("click", ".hide_comments", function (event) {
        var id_num = event.target.id.substr(13, event.target.id.length-13);
        $("#show_comments" + id_num).show();
        $("#hide_comments" + id_num).hide();
        $("#comments"+id_num).hide();
    });
});
