$(document.body).ready(function () {
    $("input.filter:not(.inactive-filter)").prop('checked', true);
    $(document).on("change", "#follow_menu input", function (event) {
        $("#follow_menu form").submit();
    });
    $(document).on("change", ".filter", function (event) {
        console.log($("#"+event.target.id).prop('checked'));
        if($("#"+event.target.id).prop('checked')){
            $("."+event.target.id+"_achievement").show();
            if ($("."+event.target.id+"_achievement").hasClass('hidden')){
                $("."+event.target.id+"_achievement").removeClass('hidden');
            }
        } else {
            $("."+event.target.id+"_achievement").hide();
        }
    });
    $(document).on('focusin', "#create_proof_url", function(event){
        if ($("#create_proof_url").val()=="Paste URL here."){
            $("#create_proof_url").val("");
            $("#create_proof_url").css("color", "black");
        }    });
    $(document).on('focusout', "#create_proof_url", function(event){
        if ($("#create_proof_url").val()==""){
            $("#create_proof_url").val("Paste URL here.");
            $("#create_proof_url").css("color", "lightgrey");
        }
    });
    $(document).on("click", ".hide_comments", function (event) {
        var id_num = event.target.id.substr(13, event.target.id.length-13);
        $("#show_comments" + id_num).show();
        $("#hide_comments" + id_num).hide();
        $("#comments"+id_num).hide();
    });
    $(document).on("click", ".hide_new_comment", function (event) {
        var id_num = event.target.id.substr(16, event.target.id.length-16);
        $("#show_new_comment" + id_num).removeClass('hidden');
        $("#new_comment"+id_num).addClass('hidden');
    });
    $(document).on("click", ".show_comments", function (event) {
        var id_num = event.target.id.substr(13, event.target.id.length-13);
        $("#show_comments" + id_num).hide();
        $("#hide_comments" + id_num).show();
        $("#comments"+id_num).show();
    });
    $(document).on("click", ".show_new_comment", function (event) {
        var id_num = event.target.id.substr(16, event.target.id.length-16);
        $("#show_new_comment" + id_num).addClass('hidden');
        $("#new_comment"+id_num).removeClass('hidden');
    });
});
