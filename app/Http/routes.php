<?php
use App\User;
use App\Proof;
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

Route::get('/', 'AchievementController@index');
Route::get('/user/{id}', ['as'=>'user.show', function($id){
    if ((int)$id<1){
        return View('User.fail');
    
    }
    return View('User.show', [
        "username"=>User::where('id', $id)->first()->name, 
        "proofs"=>Proof::where('user_id', $id)->where('status', 1)->orderBy('created_at', 'desc')->get(),
    ]);
}]);
Route::auth();

Route::get('/home', 'AchievementController@index');//'HomeController@index');

Route::resource('achievement', 'AchievementController');
Route::resource('proof', 'ProofController');
Route::resource('vote', 'VoteController');
