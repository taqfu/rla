<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Claim;
use App\Goal;
use App\Proof;
use App\Story;
use App\Timeline;
use Auth;


class StoryController extends Controller
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
        $this->validate($request, [
            'tableName'=>'required|string|max:8',
            'idNum'=>'required|integer',
            'story'=>'required|string|max:20000' 
        ]);
        $story = new Story;
        $story->user_id = Auth::user()->id;
        $story->story = $request->story;
        switch ($request->tableName){
            case "proof":
                $story->proof_id = $request->idNum;
                break;
            case "claim":
                $story->claim_id = $request->idNum;
                break;
            case "goal":
                $story->goal_id = $request->idNum;
                break;
        }
        $story->save();
        $timeline = new Timeline;
        $timeline->event = "new story";
        $timeline->user_id = Auth::user()->id;
        $timeline->story_id = $story->id;
        switch ($request->tableName){
            case "proof":
                $timeline->proof_id = $request->idNum;
                $proof = Proof::find($request->idNum);
                $timeline->achievement_id = $proof->achievement_id;
                break;
            case "claim":
                $timeline->claim_id = $request->idNum;
                $claim = Claim::find($request->idNum);
                $timeline->achievement_id = $claim->achievement_id;
                break;
            case "goal":
                $timeline->goal_id = $request->idNum;
                $goal = Goal::find($request->idNum);
                $timeline->achievement_id = $goal->achievement_id;
                break;
        }
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
        $this->validate($request, [
            "story"=>"required|string|max:20000",
        ]);
        $story = Story::find($id);
        $story->story = $request->story;
        $story->save();
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
