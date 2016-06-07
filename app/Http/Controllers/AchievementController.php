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
use Config;
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
            checkProofs();
            return View::make('Achievement.index', [
              "achievements"=>Achievement::orderBy('name','asc')->get(), //If you change orderBy, change it for next line
              "last_achievement"=>Achievement::orderBy('name', 'desc')->first(),
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
            return back()->withErrors('Please log in before doing this.');
        }
        $this->validate($request, [
            'name' => 'required|unique:achievements|max:100',
            'proofURL' => 'url|max:255',
        ], ['url'=>'Invalid URL. (Try copy and pasting instead.)']);
        $last_achievement = Achievement::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if($last_achievement!=null && time()-strtotime($last_achievement->created_at) < Config::get('rla.min_time_to_post')){
            $num_of_seconds = Config::get('rla.min_time_to_post') - (time()-strtotime($last_achievement->created_at)); 
            $num_of_minutes = floor($num_of_seconds/60);
            $num_of_seconds = $num_of_seconds % 60;
            $error_msg = "You are doing this too often. Please wait ";
            if ($num_of_minutes>0){
                $error_msg = $error_msg . $num_of_minutes . " minutes";
            }
            if ($num_of_minutes>0 && $num_of_seconds>0){
                $error_msg = $error_msg . " and ";
            }
            if ($num_of_seconds>0){
                $error_msg = $error_msg . $num_of_seconds . " seconds";
            }
            $error_msg = $error_msg . " before trying again.";
            return back()->withErrors($error_msg)->withInput();
        }
        $achievement = new Achievement;
        $achievement->name = $request->name;
        $achievement->created_by = Auth::user()->id;
        $achievement->status = strlen($request->proofURL)>0 ? 2 : 3;
        $achievement->save();

        $follow = new Follow;
        $follow->user_id = Auth::user()->id;
        $follow->achievement_id = $achievement->id;
        $follow->save();

        $timeline = new Timeline;
        $timeline->user_id = Auth::user()->id; 
        $timeline->event = strlen($request->proofURL)>0 ? "new achievement" : "new achievement no proof";
        $timeline->achievement_id = $achievement->id;
        $timeline->save();
        
        if (strlen($request->proofURL)>0){
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
        }
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
            "following"=>count(Follow::where('user_id', Auth::user()->id)->where('achievement_id', $main->id)->get())>0,
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
        $last_no_vote = Vote::where('proof_id', $proof->id)->where('vote_for', false)->orderBy('created_at', 'desc')->first();
        if (($last_no_vote==null && time()-strtotime($proof->created_at)>=$max_time_to_not_vote)
          || ($last_no_vote!=null && time()-strtotime($last_no_vote->created_at)>=$max_time_to_not_vote)
          || time()-strtotime($proof->created_at)>=$max_time_to_vote){
            changeStatus($proof->id, Proof::passing_approval($proof->id));
        }
    }
}


function changeStatus($proof_id, $status){
    $proof = Proof::find($proof_id);
    $proof->status = $status;
    $proof->save();
    $owners_of_achievement = Achievement::fetch_owners($proof->achievement_id);
    foreach ($owners_of_achievement as $owner){
        $timeline = new Timeline;
        $timeline->user_id = $owner;
        $timeline->event = "change proof status " . $proof->status . " to " . (int)$status;
        $timeline->proof_id = $proof->id;  
        $timeline->save();
    }
    $achievement = Achievement::find($proof->achievement_id);

    if ($achievement->status==2){
        $timeline = new Timeline;
        $timeline->user_id = $achievement->created_by;
        $timeline->event = "change achievement status " . $achievement->status . " to " . (int)$status;
        $timeline->achievement_id = $achievement->id;  
        $timeline->save();
        $achievement->status = $status; 
        $achievement->save();
    }
}

    
