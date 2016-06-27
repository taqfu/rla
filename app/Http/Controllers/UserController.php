<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Comment;
use App\Follow;
use App\Proof;
use App\User;
use Auth;
use DateTimeZone;
use Hash;
use View;

class UserController extends Controller
{
    public function showProfile($id){
        if ((int)$id<1){
          return View('User.fail');
    
        }
        $proofs = Proof::join('achievements', 'achievement_id', '=', 'achievements.id')->where('proofs.user_id', $id)->orderBy('achievements.name', 'asc')->get();
        $follows = Follow::join ('achievements', 'achievement_id', '=', 'achievements.id')->where('follows.user_id', $id)->orderBy('achievements.name','asc')->get();
    
        return View::make('User.show', [
            "proofs"=>$proofs,
            "profile"=>User::where('id', $id)->first(), 
            "achievements"=>Achievement::where('user_id', $id)->orderBy('name', 'asc')->get(),
            "follows"=>$follows,
        ]);
    }
    public function showComments($id){
        return View('User.comments', [
          "profile"=>User::where('id', $id)->first(), 
          "comments"=>Comment::where('user_id', $id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
    public function updateEmail(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:users',
        ]);
        $user = User::find(Auth::user()->id);
        $user->email=$request->email;
        $user->save();
        return back();
    }

    public function updatePassword(Request $request){
        $this->validate($request, [
            'old'=>'required|min:8',
            'new'=>'required|min:8|confirmed',
        ]);
        if(Hash::check($request->old, Auth::user()->password)){
            $user = Auth::user();
            $user->password = Hash::make($request->new);
            $user->save(); 
            return back()->withErrors(['success'=>'Password changed!']);
        } else {
            return back()->withErrors(['old'=>'Old password invalid.']);
        }
    }
    public function updateTimeZone(Request $request){
        $this->validate($request, [
            'timezone'=>'required|string'
        ]);
        $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $clear=false;
        foreach ($tzlist as $timezone){
            if ($timezone==$request->timezone){
                $clear=true;
            }
        }
        if($clear){
            $user = User::find(Auth::user()->id);
            $user->timezone = $request->timezone;
            $user->save();
            return back();
        } else {
            return back()->withErrors(["timezone"=>'This time zone does not exist.']);
        }
    }
}
