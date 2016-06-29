<?php
use Illuminate\Http\Request;
use App\Achievement;
use App\Claim;
use App\Follow;
use App\Goal;
use App\Message;
use App\Proof;
use App\Timeline;
use App\User;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::auth();
Route::get('/achievement/{id}/claims', ['as'=>'achievement.showClaims', 'uses'=>'AchievementController@showClaims']);
Route::get('/achievement/{id}/proofs', ['as'=>'achievement.showProofs', 'uses'=>'AchievementController@showProofs']);
Route::get('/guidelines', ['as'=>'guidelines', function(){
    return View('guidelines');
}]);
Route::get('/changes', ['as'=>'changes', function(){
    return View('changes');
}]);
Route::get('/feedback', ['as'=>'feedback', function(){
    return View('feedback');
}]);
Route::get('/inbox', ['as'=>'inbox', function(){
    if (Auth::guest()){
        return View('Message.fail');
    } else if (Auth::user()){
        return View('Message.inbox', [
            'profile'=>User::where('id', Auth::user()->id)->first(),
            'messages'=>Message::where('to_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]);
Route::get('/inventory', ['as'=>'inventory', function(Request $request){
    if (Auth::user()){
        $achievements = Achievement::fetch_appropriate_sort_source($request->input('sort'));
        return View('Achievement.inventory', [
            "achievements"=>$achievements,
            "sort"=>$request->input('sort'),
        ]);
    } else {
        return View('fail');
    }
}]);
Route::get('/outbox', ['as'=>'outbox', function(){
    if (Auth::guest()){
        return View('Message.fail');
    } else if (Auth::user()){
        return View('Message.outbox', [
            'profile'=>User::where('id', Auth::user()->id)->first(),
            'messages'=>Message::where('from_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]);
Route::get('/settings', ['as'=>'settings', function(){
    if (Auth::guest()){
        return View('Message.fail');
    } else if (Auth::user()){
        return View('User.settings', [
            'profile'=>User::where('id', Auth::user()->id)->first(),
        ]);
    }
}]);
Route::get('/achievement/{achievement_id}/discussion', ['as'=>'discussion', function($achievement_id){
    $main = Achievement::where('id', $achievement_id)->first();
    if (Auth::guest()){
        $following=0;
        $user_claim = null;
        $user_goal = null;
        $user_proof = null;
    } else if (Auth::user()){
        $following=count(Follow::where('user_id', Auth::user()->id)
          ->where('achievement_id', $achievement_id)
          ->get())>0;
        $user_claim = Claim::where('user_id', Auth::user()->id)
          ->where('achievement_id', $achievement_id)->first();
        $user_goal = Goal::where('user_id', Auth::user()->id)
              ->where('achievement_id', $id)->first();
        $user_proof = Proof::where('user_id', Auth::user()->id)->where('status', '1')
          ->where('achievement_id', $achievement_id)->first();
    }
    return View('Achievement.discussion', [
        'main'=>$main,
        "following"=>$following,
        "user_claim"=>$user_claim,
        "user_goal"=>$user_goal,
        "user_proof"=>$user_proof,
    ]);
}]);

Route::get('/', ['as'=>'home', function (){
    if (Auth::guest()){
        return View('public');
    } else if (Auth::user()){
        return View('Timeline.index', [
            "timeline_items"=>Timeline::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]);

Route::get('/user/{id}', ['as'=>'user.show', 'uses'=>'UserController@showProfile']);
Route::get('/user/{id}/achievements/completed', ['as'=>'user.achievements.completed', function($id){
    $proofs = Proof::join('achievements', 'achievement_id', '=', 'achievements.id')->where('proofs.user_id', $id)->where('proofs.status', 1)->orderBy('achievements.name', 'asc')->get();
    return View('User.achievements.completed', [
        "proofs"=>$proofs,
        "profile"=>User::where('id', $id)->first(), 
    ]);    
}]);
Route::get('/user/{id}/achievements/claimed', ['as'=>'user.achievements.claimed', function($id){
    $claims = Claim::join('achievements', 'achievement_id', '=', 'achievements.id')->where('claims.user_id', $id)->whereNull('claims.canceled_at')->orderBy('achievements.name', 'asc')->get();
    return View('User.achievements.claimed', [
        "claims"=>$claims,
        "profile"=>User::where('id', $id)->first(), 
    ]);    
}]);
Route::get('/user/{id}/achievements/created', ['as'=>'user.achievements.created', function($id){
    return View('User.achievements.created', [
        "achievements"=>Achievement::where('user_id', $id)->orderBy('name', 'asc')->get(),
        "profile"=>User::where('id', $id)->first(), 
    ]);    
}]);
Route::get('/user/{id}/achievements/subscriptions', ['as'=>'user.achievements.subscriptions', function($id){
    $follows = Follow::join ('achievements', 'achievement_id', '=', 'achievements.id')->where('follows.user_id', $id)->orderBy('achievements.name','asc')->get();
    return View('User.achievements.subscriptions', [
        "profile"=>User::where('id', $id)->first(), 
        "follows"=>$follows,
    ]);    
}]);
Route::get('/user/{id}/comments', ['as'=>'user.comments', 'uses'=>'UserController@showComments']);
Route::get('/user/{id}/message', ['as'=>'new_message', function($id){
    return View('Message.create', [
        'profile'=> User::where('id', $id)->first(),
    ]);

}]);

Route::post('/query', ['as'=>'query', 'uses'=>'AchievementController@query']);
Route::put('/settings/email', ['as'=>'settings.email', 'uses'=>'UserController@updateEmail']);
Route::put('/settings/password', ['as'=>'settings.password', 'uses'=>'UserController@updatePassword']);
Route::put('/settings/timezone', ['as'=>'settings.timezone', 'uses'=>'UserController@updateTimeZone']);


Route::resource('AchievementVote', 'AchievementVoteController');
Route::resource('achievement', 'AchievementController');
Route::resource('claim', 'ClaimController');
Route::resource('comment', 'CommentController');
Route::resource('follow', 'FollowController');
RoutE::resource('goal', 'GoalController');
Route::resource('message', 'MessageController');
Route::resource('proof', 'ProofController');
Route::resource('timeline', 'TimelineController');
Route::resource('vote', 'VoteController');
