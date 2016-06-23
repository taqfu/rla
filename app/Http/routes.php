<?php
use Illuminate\Http\Request;
use App\Achievement;
use App\Follow;
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
    } else if (Auth::user()){
        $following=count(Follow::where('user_id', Auth::user()->id)
          ->where('achievement_id', $achievement_id)
          ->get())>0;
    }
    return View('Achievement.discussion', [
        'main'=>$main,
        "following"=>$following,
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
Route::resource('comment', 'CommentController');
Route::resource('follow', 'FollowController');
Route::resource('message', 'MessageController');
Route::resource('proof', 'ProofController');
Route::resource('vote', 'VoteController');
