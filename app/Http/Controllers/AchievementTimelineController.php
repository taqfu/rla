<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\AchievementTimeline;
use App\Claim;
use App\Goal;
use App\Proof;


class AchievementTimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $claims = Claim::get();
        $goals = Goal::get();
        $proofs = Proof::get();
        foreach ($claims as $claim){
            $achievement_timeline = new AchievementTimeline;
            $achievement_timeline->achievement_id = $claim->achievement_id;
            $achievement_timeline->created_at = $claim->created_at;
            $achievement_timeline->updated_at = $claim->updated_at;
            $achievement_timeline->claim_id = $claim->id;
            $achievement_timeline->save();
        }
        foreach ($goals as $goal){
            $achievement_timeline = new AchievementTimeline;
            $achievement_timeline->achievement_id = $goal->achievement_id;
            $achievement_timeline->created_at = $goal->created_at;
            $achievement_timeline->updated_at = $goal->updated_at;
            $achievement_timeline->goal_id = $goal->id;
            $achievement_timeline->save();
        }
        foreach ($proofs as $proof){
            $achievement_timeline = new AchievementTimeline;
            $achievement_timeline->achievement_id = $proof->achievement_id;
            $achievement_timeline->created_at = $proof->created_at;
            $achievement_timeline->updated_at = $proof->updated_at;
            $achievement_timeline->proof_id = $proof->id;
            $achievement_timeline->save();
        }
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
