
$(document.body).ready(function () {
    var searchAndCreateAchievementTimer;
    var doneTypingInterval=100;
    var searchAndCreateInputTextCaption = "Create or search here.";
    var oldRank;
    var newRank;

    $(document).on('dragstart', '.bucket-list-item', function(event){
        oldRank = event.target.id.substr(16);
        this.style.opacity='.5';
        
    });
    $(document).on('dragleave', '.bucket-list-item', function(event){
    });
    $(document).on('dragend', '.bucket-list-item', function(event){
        moveRank(oldRank, newRank);
        oldRank=null;
        newRank=null;
    });
    $(document).on('dragenter', 'div.bucket-list-item', function(event){
        if (event.target.id.length>0){ // to prevent blank classes
            newRank = event.target.id.substr(16);
        }
    });
    $(document).on('submit', 'form.create-proof', function(event){
        if ($('#create-proof-url').val().substring(0, 7)!="http://"){
            $('#create-proof-url').val("http://" + $("#create-proof-url").val());
        }
    });
    $(document).on("change", "#follow-menu input", function (event) {
        $("#follow-menu form").submit();
    });
    $(document).on("focusin", "#create-achievement", function (event) {
        $("#create-achievement").css('color', 'black');    
        if ($("#create-achievement").val()==searchAndCreateInputTextCaption){
            $("#create-achievement").val("");
        }
        
    });
    $(document).on("focusout", "#create-achievement", function (event) {
        if ($("#create-achievement").val().trim()==""){
            $("#create-achievement").val(searchAndCreateInputTextCaption);
            $("#create-achievement").css('color', 'grey');    
        }
    });
    $(document).on('keydown', "#create-achievement", function (event) {
        clearTimeout(searchAndCreateAchievementTimer);
    }); 
    $(document).on("keyup", "#create-achievement", function (event) {
        clearTimeout(searchAndCreateAchievementTimer);
        if (event.key=="Enter"){
           console.log($("#default_result").is("input"), $("#default_result").is("form")); 
            if($("#default_result").is("input")){
                window.location.replace($("#default_result").val());
            } else if ($("#default_result").is("form")){
                $("#default_result").submit();
            }
        } else {
            if ($("#create-achievement").val().length>0){
                searchAndCreateAchievementTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        }
    });
    $(document).on("change", ".filter", function (event) {
        $("#achievement-filters").submit(); 
    });
    $(document).on('change', "#all-filters", function(event){
        console.log($("#all-filters").prop('checked'));
        $("input.filter").prop('checked', $("#all-filters").prop('checked')); 
    });
    $(document).on('focusin', "#create-proof-url", function(event){
        if ($("#create-proof-url").val()=="Paste URL here."){
            $("#create-proof-url").val("");
            $("#create-proof-url").css("color", "black");
        }    });
    $(document).on('focusout', "#create-proof-url", function(event){
        if ($("#create-proof-url").val()==""){
            $("#create-proof-url").val("Paste URL here.");
            $("#create-proof-url").css("color", "lightgrey");
        }
    });
    $(document).on("click", ".hide_comments", function (event) {
        var id_num = event.target.id.substr(13, event.target.id.length-13);
        $("#show-comments" + id_num).show();
        $("#show-comments" + id_num).removeClass('hidden');
        $("#hide_comments" + id_num).hide();
        $("#comments"+id_num).hide();
    });
    $(document).on("click", ".hide_new_comment", function (event) {
        var id_num = event.target.id.substr(16, event.target.id.length-16);
        $("#show-new-comment" + id_num).removeClass('hidden');
        $("#new_comment"+id_num).addClass('hidden');
    });
    $(document).on('click', '.proof-yes-vote', function(event) {
        var proofID = event.target.id.substr(14, event.target.id.length-14);
        submitVote(Number(proofID), 1);
    });
    $(document).on('click', '.proof-no-vote', function(event) {
        var proofID = event.target.id.substr(13, event.target.id.length-13);
        submitVote(Number(proofID), 0);
    });
    $(document).on("click", ".show-comments", function (event) {
        var id_num = event.target.id.substr(13, event.target.id.length-13);
        console.log("SHOW " + id_num);
        $("#show-comments" + id_num).hide();
        $("#hide_comments" + id_num).show();
        $("#comments"+id_num).show();
        $("#comments" + id_num).removeClass('hidden');
    });
    $(document).on("click", ".show-new-comment", function (event) {
        var id_num = event.target.id.substr(16, event.target.id.length-16);
        $("#show-new-comment" + id_num).addClass('hidden');
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
        data:{searchQuery:$("#create-achievement").val()}
    })  
        .done(function (result){
            $("#achievement-results").html(result);
        }); 
}
function moveRank(oldRank, newRank){
    console.log(oldRank, newRank);
    var siteRoot =  window.location.hostname=="taqfu.com" ? "/dev-env/rla/public" : "";
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },  
        method: "POST",
        url: siteRoot + "/goal/rank/" + oldRank + "/to/" + newRank,
        data:{oldRank:oldRank, newRank:newRank}
    })  
        .done(function (result){
            $("#bucket-list").html(result);
        }); 
}
function submitVote(proofID, voteFor){
    var siteRoot =  window.location.hostname=="taqfu.com" ? "/dev-env/rla/public" : "";
    var achievementID = Number($("#proof-vote-achievement-id"+proofID).val());
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },  
        method: "POST",
        url: siteRoot + "/vote",
        data:{proofID:proofID, achievementID:achievementID, voteFor:voteFor}
    })  
        .done(function (result){
            $("#vote-on-proof"+proofID).html(result);
        }); 
}
