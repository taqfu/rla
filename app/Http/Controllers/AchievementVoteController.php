<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\AchievementVote;
use App\Achievement;
class AchievementVoteController extends Controller
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
            'achievementID' => 'required|integer|min:1',
            'voteUp' => 'required|boolean',
        ]);
        $has_user_voted_already=count(AchievementVote::where('user_id', Auth::user()->id)->where('achievement_id', $request->achievementID)->get())>0;
        if ($has_user_voted_already){
            return back()->withErrors("You've already voted on this.");
        }
        $achievement_vote = new AchievementVote;
        $achievement_vote->user_id = Auth::user()->id;
        $achievement_vote->achievement_id = $request->achievementID;
        $achievement_vote->vote_up = $request->voteUp;
        $achievement_vote->save();
        $achievement = Achievement::find($request->achievementID);
        (boolean)$request->voteUp ? $achievement->score++ : $achievement->score--;
        $achievement->save();
        // Not going to include votes as part of the timeline unless people request it.
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
        //
    }
}
