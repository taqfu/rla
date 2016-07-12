<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Claim;
use App\Timeline;
use App\User;
use Auth;
class ClaimController extends Controller
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
        if (Auth::guest()){
            return back()->withErrors('Please log in before doing this.');
        }
        $this->validate($request, [
            'achievementID' => 'required|integer',
        ]);
        $achievement = Achievement::find($request->achievementID);
        $user = User::find(Auth::user()->id);
        $followers = Achievement::fetch_followers($request->achievementID);

        $claim = new Claim;
        $claim->user_id = Auth::user()->id;
        $claim->achievement_id = $request->achievementID;
        $claim->points = $achievement->score;
        $claim->save();

        $user->claim_score += $claim->points;
        $user->save();

        $timeline = new Timeline;
        $timeline->achievement_id = $claim->achievement_id;
        $timeline->claim_id = $claim->id;
        $timeline->event = "new claim";
        $timeline->save();

        return back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Claim::find($id)->delete();
        return  back();
    }

}
