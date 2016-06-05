<?php
use App\Achievement;
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
Route::get('/about', ['as'=>'about', function(){
    return View('about');
}]);
Route::get('/feedback', ['as'=>'feedback', function(){
    return View('feedback');
}]);
Route::get('/inbox', ['as'=>'inbox', function(){
    if (Auth::guest()){
        return View('Message.fail');
    } else if (Auth::user()){
        return View('Message.inbox', [
            'messages'=>Message::where('to_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]);
Route::get('/outbox', ['as'=>'outbox', function(){
    if (Auth::guest()){
        return View('Message.fail');
    } else if (Auth::user()){
        return View('Message.outbox', [
            'messages'=>Message::where('from_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]);
Route::get('/settings', ['as'=>'settings', function(){
    if (Auth::guest()){
        return View('Message.fail');
    } else if (Auth::user()){
        return View('User.settings');
    }
}]);
Route::get('/achievement/{achievement_id}/discussion', ['as'=>'discussion', function($achievement_id){
    return View('Achievement.discussion', [
        'main'=>Achievement::where('id', $achievement_id)->first(),
    ]);
}]);

Route::get('/', ['as'=>'home', function (){
    if (Auth::guest()){
        return View('public');
    } else if (Auth::user()){
        return View('home', [
            "timeline_items"=>Timeline::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]); 

Route::get('/user/{id}', ['as'=>'user.show', 'uses'=>'UserController@showProfile']);

Route::get('/user/{id}/message', ['as'=>'new_message', function($id){
    return View('Message.create', [
        'profile'=> User::where('id', $id)->first(),
    ]);

}]);

Route::put('/settings/email', ['as'=>'settings.email', 'uses'=>'UserController@updateEmail']);
Route::put('/settings/password', ['as'=>'settings.password', 'uses'=>'UserController@updatePassword']);
Route::put('/settings/timezone', ['as'=>'settings.timezone', 'uses'=>'UserController@updateTimeZone']);


Route::resource('achievement', 'AchievementController');
Route::resource('comment', 'CommentController');
Route::resource('message', 'MessageController');
Route::resource('proof', 'ProofController');
Route::resource('vote', 'VoteController');
