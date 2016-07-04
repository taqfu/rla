<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Follow;
use Auth;
class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guest()){
            return back()->withErrors("You need to be logged into to do this.");
        }
        $this->validate($request, [
            'following' => 'required|boolean',
        ]);
        $num_of_follows = count(Follow::where('achievement_id', $id)->where('user_id', Auth::user()->id)->get());
        if ($num_of_follows>1){
            //ERROR - following too many
            return back()->withErrors("You have too many follows.");
        }

        if ((boolean)$request->following){
            if ($num_of_follows>0){
                // ERROR - should not be able to follow when it's already following.
                return back()->withErrors("You can't follow. You're already following.");
            } else {
                $follow = new Follow;
                $follow->user_id = Auth::user()->id;
                $follow->achievement_id = $id;
                $follow->save();
            }
        } else {
            if ($num_of_follows>0){
                $follows = Follow::where('achievement_id', $id)->where('user_id', Auth::user()->id)->get();
                foreach ($follows as $follow){
                    $follow->delete();
                }
            } else {
                // ERROR - unfollowing when it's not following.
                return back()->withErrors("You can't unfollow. You've already unfollowed.");

            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
