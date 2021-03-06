<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Follow;
use App\Proof;
use App\Timeline;
use App\Vote;

use Auth;
use View;
class ProofController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('Proof.index', [

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'proofURL' => 'required|url',
            'achievementID' =>'required|integer',
        ], ['url'=>'Invalid URL. (Try copy and pasting instead.)']);
        if (!Achievement::can_user_submit_proof($request->achievementID)){
            $timestamp = date('m/d/y h:i:s');
            return back()->withErrors("'ERROR: You cannot submit a proof for this achievement. $timestamp User ID:" . Auth::user()->id)->withInput();
        }

        $achievement = Achievement::find($request->achievementID);
        if ($achievement->status==0 || $achievement->status>2){
            $achievement->status=2;
            $achievement->save();
        }
        $proof = new Proof;
        $proof->user_id = Auth::user()->id;
        $proof->achievement_id = $request->achievementID;
        $proof->url = $request->proofURL;
        $proof->status = 2;
        $proof->save();
        if (count(Follow::where('achievement_id', $request->achievementID)->where('user_id', Auth::user()->id)->get())==0){
            $follow = new Follow;
            $follow->achievement_id = $request->achievementID;
            $follow->user_id = Auth::user()->id;
            $follow->save();
        }
        $vote = new Vote;
        $vote->user_id = Auth::user()->id;
        $vote->achievement_id = $request->achievementID;
        $vote->proof_id = $proof->id;
        $vote->vote_for = true;
        $vote->save();
        $achievement = Achievement::find($request->achievementID);
        if ($achievement->status==0 || $achievement->status==3){
            $achievement->status=2;
            $achievement->save();
            $timeline = new Timeline;
            $timeline->user_id = $achievement->user_id;
            $timeline->event = "change achievement status to 2";
            $timeline->achievement_id = $achievement->id;
            $timeline->save();
        }

        $timeline = new Timeline;
        $timeline->user_id = $proof->user_id;
        $timeline->achievement_id=$proof->achievement_id;
        $timeline->proof_id = $proof->id;
        $timeline->event = "new proof";
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
        $proof_exists = count(Proof::find($id))>0;
        if ($proof_exists){
        return View::make('Proof.show', [
            "proof"=>Proof::where('id', $id)->first(),
            "votes"=>Vote::where('proof_id', $id)->get(),
            "num_of_for_votes"=>count(Vote::where('proof_id', $id)->where('vote_for', true)->get()),
            "num_of_against_votes"=>count(Vote::where('proof_id', $id)->where('vote_for', false)->get()),
            "passing"=>Proof::passing_approval($id),
        ]);
        } else {
        return View::make('Proof.fail');
        }
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

        $proof = Proof::find($id);
        $proof->status = 4;
        $proof->save();

        $timeline = new Timeline;
        $timeline->user_id = Auth::user()->id;
        $timeline->proof_id = $id;
        $timeline->event = "cancel proof";
        $timeline->save();

        $achievement = Achievement::find($proof->achievement_id);
        if ($achievement->status==2){
            $achievement->status=4;
        }
        $achievement->save();
        return back();
    }
}
