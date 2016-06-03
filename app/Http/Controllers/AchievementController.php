<?php
namespace App\Http\Controllers;

define('MIN_TIME_TO_POST', 60 * 10);
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Proof;
use App\Vote;

use Auth;
use DB;
use View;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        if (Auth::user()){
            checkProofs();
            return View::make('Achievement.index', [
                "achievements"=>Achievement::orderBy('name','asc')->get(), //If you change orderBy, change it for next line
                "last_achievement"=>Achievement::orderBy('name', 'desc')->first(),
            ]);
/*
        } else {
            return View::make('guest');
        }
*/
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
            'name' => 'required|unique:achievements|max:100',
            'proofURL' => 'required|url|max:255',
        ], ['url'=>'Invalid URL. (Try copy and pasting instead.)']);
        $last_achievement = Achievement::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if($last_achievement!=null && time()-strtotime($last_achievement->created_at) < MIN_TIME_TO_POST){
            $num_of_seconds = time()-strtotime($last_achievement->created_at); 
            return back()->withErrors("You are doing this too often. Please wait $num_of_seconds seconds.")->withInput();
        }
        $achievement = new Achievement;
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
        return redirect()->route('achievement.show', [$achievement->id]);
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
        $proofs = Proof::where('achievement_id', $id)->orderBy('created_at', 'desc')->get();
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
        //var_dump($proof->achievement_id, time()-strtotime($last_vote->created_at), time()-strtotime($proof->created_at));
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

    
