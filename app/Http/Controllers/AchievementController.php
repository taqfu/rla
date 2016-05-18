<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Proof;
use App\Vote;

use Auth;
use View;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        checkProofs();
        return View::make('Achievement.index', [
            "achievements"=>Achievement::orderBy('name', 'asc')->get(),
        ]);
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
            return;
        }
        $this->validate($request, [
            'name' => 'required|unique:achievements|max:140',
            'proofURL' => 'required|max:255'
        ]);
        $achievement = new Achievement;
        var_dump("CHECK");
        $achievement->name = $request->name;
        $achievement->created_by = Auth::user()->id;
        $achievement->status = 2;
        $achievement->save();
        $proof = new Proof;
        $proof->user_id = Auth::user()->id;
        $proof->achievement_id = $achievement->id;
        $proof->url = $request->proofURL;
        $proof->status = 2;
        $proof->save();
        $vote = new Vote;
        $vote->user_id = Auth::user()->id;
        $vote->achievement_id = $achievement->id;
        $vote->proof_id = $proof->id;
        $vote->vote_for = true;
        $vote->save();
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
        $main = Achievement::where('id', $id)->first();
        $proofs = Proof::where('achievement_id', $id)->orderBy('created_at', 'asc')->get();
        if (Auth::user()){
            $votes = Vote::where('achievement_id', $id)->where('user_id', Auth::user()->id)->get();
        } else if (Auth::guest()){
            $votes = null;
        }
        return View::make('Achievement.show', [
            "main"=>$main,
            "proofs"=>$proofs,
            "votes"=>$votes,
        ]);
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


function checkProofs(){
    $max_time_to_vote = 604800;
    $max_time_to_not_vote = 86400;
    $proofs_needing_to_be_checked = Proof::where("status", 2)->orderBy("created_at", "asc")->get();    
    foreach($proofs_needing_to_be_checked as $proof){
        $last_vote = Vote::where('proof_id', $proof->id)->orderBy('created_at', 'desc')->first();
        //var_dump($proof->achievement_id, time()-strtotime($last_vote->created_at)-$max_time_to_not_vote, time()-strtotime($proof->created_at)-$max_time_to_vote);
        if (time()-strtotime($last_vote->created_at)>=$max_time_to_not_vote 
          || time()-strtotime($proof->created_at)>=$max_time_to_vote){
            changeStatus($proof->id, Proof::passing_approval($proof->id));
        }
    }
}


function changeStatus($proof_id, $status){
    $proof = Proof::find($proof_id);
    $proof->status = $status;
    $proof->save();
    $achievement = Achievement::find($proof->achievement_id);
    if ($achievement->status==2){
        $achievement->status = $status; 
        $achievement->save();
    }
}

    
