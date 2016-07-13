<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Claim;
use App\Goal;
use App\Proof;
use App\Timeline;


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
             $timeline = new Timeline;
             $timeline->user_id = $claim->user_id;
             $timeline->event = "new claim";
             $timeline->achievement_id = $claim->achievement_id;
             $timeline->created_at = $claim->created_at;
             $timeline->updated_at = $claim->updated_at;
             $timeline->claim_id = $claim->id;
             $timeline->save();
         }
         foreach ($goals as $goal){
             $timeline = new Timeline;
             $timeline->event = "new goal";
             $timeline->user_id = $goal->user_id;
             $timeline->achievement_id = $goal->achievement_id;
             $timeline->created_at = $goal->created_at;
             $timeline->updated_at = $goal->updated_at;
             $timeline->goal_id = $goal->id;
             $timeline->save();
         }
         foreach ($proofs as $proof){
             $timeline = new Timeline;
             $timeline->event = "new proof";
             $timeline->user_id = $proof->user_id;
             $timeline->achievement_id = $proof->achievement_id;
             $timeline->created_at = $proof->created_at;
             $timeline->updated_at = $proof->updated_at;
             $timeline->proof_id = $proof->id;
             $timeline->save();
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
