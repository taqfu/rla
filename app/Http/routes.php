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


Route::auth();

Route::get('/', ['as'=>'home', function (){
    if (Auth::guest()){
        return redirect(route('achievement.index',['approved'=>'on',
          'pending'=>'on']));
    } else if (Auth::user()){
        return View('Timeline.index', [
            "timeline_items"=>Timeline::where('user_id', Auth::user()->id)
              ->orderBy('created_at', 'desc')->get(),
        ]);
    }
}]);

Route::get('/achievement/{url}/claims', ['as'=>'achievement.showClaims',
  'uses'=>'AchievementController@showClaims']);
Route::get('/achievement/{url}/discussion', ['as'=>'achievement.discussion',
  'uses'=>'AchievementController@showDiscussion']);
Route::get('/achievement/{url}/proofs', ['as'=>'achievement.showProofs',
  'uses'=>'AchievementController@showProofs']);

Route::get('/changes', ['as'=>'changes', function(){
    return View('changes');
}]);

Route::get('/feedback', ['as'=>'feedback', function(){
    return View('feedback');
}]);

Route::get('/guidelines', ['as'=>'guidelines', function(){
    return View('guidelines');
}]);

Route::get('/inbox', ['as'=>'inbox', 'uses'=>'MessageController@showInbox']);
Route::get('/outbox', ['as'=>'outbox', 'uses'=>'MessageController@showOutbox']);

Route::get('/settings', ['as'=>'settings',
'uses'=>'UserController@showSettings']);

Route::get('/user/{username}', ['as'=>'user.show',
  'uses'=>'UserController@showProfile']);

Route::get('/user/{username}/achievements/claimed',
  ['as'=>'user.achievements.claimed',
  'uses'=>'UserController@showAchievementsClaimed']);
Route::get('/user/{username}/achievements/completed',
  ['as'=>'user.achievements.completed',
  'uses'=>'UserController@showAchievementsCompleted']);
Route::get('/user/{username}/achievements/created',
  ['as'=>'user.achievements.created',
  'uses'=>'UserController@showAchievementsCreated']);
Route::get('/user/{username}/achievements/goals',
  ['as'=>'user.achievements.goals',
  'uses'=>'UserController@showAchievementsGoals']);
Route::get('/user/{username}/achievements/subscriptions',
  ['as'=>'user.achievements.subscriptions',
  'uses'=>'UserController@showAchievementsSubscriptions']);

Route::get('/user/{username}/comments', ['as'=>'user.comments',
  'uses'=>'UserController@showComments']);
Route::get('/user/{username}/message', ['as'=>'new_message',
  'uses'=>'MessageController@create']);


Route::post('/query', ['as'=>'query', 'uses'=>'AchievementController@query']);


Route::put('/settings/email', ['as'=>'settings.email',
  'uses'=>'UserController@updateEmail']);
Route::put('/settings/password', ['as'=>'settings.password',
  'uses'=>'UserController@updatePassword']);
Route::put('/settings/timezone', ['as'=>'settings.timezone',
  'uses'=>'UserController@updateTimeZone']);


Route::resource('AchievementVote', 'AchievementVoteController');
Route::resource('achievement', 'AchievementController');
Route::resource('AchievementTimeline', 'AchievementTimelineController');
Route::resource('claim', 'ClaimController');
Route::resource('comment', 'CommentController');
Route::resource('follow', 'FollowController');
RoutE::resource('goal', 'GoalController');
Route::resource('message', 'MessageController');
Route::resource('proof', 'ProofController');
Route::resource('timeline', 'TimelineController');
Route::resource('vote', 'VoteController');
