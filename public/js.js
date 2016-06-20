
$(document.body).ready(function () {
    var searchAndCreateAchievementTimer;
    var doneTypingInterval=500;
    var searchAndCreateInputTextCaption = "Create or search here.";
    $(document).on("change", "#follow_menu input", function (event) {
        $("#follow_menu form").submit();
    });
    $(document).on("focusin", "#create_achievement", function (event) {
        $("#create_achievement").css('color', 'black');    
        if ($("#create_achievement").val()==searchAndCreateInputTextCaption){
            $("#create_achievement").val("");
        }
        
    });
    $(document).on("focusout", "#create_achievement", function (event) {
        if ($("#create_achievement").val().trim()==""){
            $("#create_achievement").val(searchAndCreateInputTextCaption);
            $("#create_achievement").css('color', 'grey');    
        }
    });
    $(document).on('keydown', "#create_achievement", function (event) {
        clearTimeout(searchAndCreateAchievementTimer);
    }); 
    $(document).on("keyup", "#create_achievement", function (event) {
        clearTimeout(searchAndCreateAchievementTimer);
        if (event.key=="Enter"){
           console.log($("#default_result").is("input"), $("#default_result").is("form")); 
            if($("#default_result").is("input")){
                window.location.replace($("#default_result").val());
            } else if ($("#default_result").is("form")){
                $("#default_result").submit();
            }
        } else {
            if ($("#create_achievement").val().length>0){
                searchAndCreateAchievementTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        }
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


function doneTyping(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },  
        method: "POST",
        url: "query",
        data:{searchQuery:$("#create_achievement").val()}
    })  
        .done(function (result){
            $("#achievement_results").html(result);
        }); 

}
