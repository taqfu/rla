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
        CheckAchievements();
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


function CheckAchievements(){
    $max_time_to_vote = 604800;
    $max_time_to_not_vote = 86400;
    $achievements_needing_to_be_checked = Achievement::where("status", 2)->orderBy("created_at", "asc")->get();    
    foreach($achievements_needing_to_be_checked as $achievement){
        $proof = Proof::where('status', 2)->where('achievement_id', $achievement->id)->first();
        $last_vote = Vote::where('proof_id', $proof->id)->orderBy('created_at', 'desc')->first();
        if (time()-strtotime($last_vote->created_at)>=$max_time_to_not_vote 
          || time()-strtotime($achievement->created_at)>=$max_time_to_vote){
            AchievementChecked($achievement->id);
        }
    }
}

function AchievementChecked($id){
   if (count(Proof::where('achievement_id', $id)->where('status', 2)->get())>1){
        //ERROR TOO MANY PROOFS
        var_dump("TOO MANY");
   }
    $proof = Proof::where('achievement_id', $id)->where('status', 2)->first();
    $votes_for = count(Vote::where('proof_id', $proof->id)->where('vote_for', true)->get());
    $votes_against = count(Vote::where('proof_id', $proof->id)->where('vote_for', false)->get());
    var_dump($votes_for, $votes_against);
    if ($votes_for - $votes_against <= 0){
        changeStatus($id, $proof->id, 0);
    } else if ($votes_for - $votes_against > 0){
        changeStatus($id, $proof->id, 1);
    }
}

function changeStatus($achievement_id, $proof_id, $status){
    $achievement = Achievement::find($achievement_id);
    $achievement->status = $status; 
    $achievement->save();
    $proof = Proof::find($proof_id);
    $proof->status = $status;
    $proof->save();
}

    
