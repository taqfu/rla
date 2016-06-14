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
            $achievements = Achievement::fetch_appropriate_sort_source($request->input('sort'));
            Proof::check();
            return View::make('Achievement.index', [
              "achievements"=>$achievements,
              "sort"=>$request->input('sort'),
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
        $last_achievement = Achievement::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
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
        $achievement->user_id = Auth::user()->id;
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
        if (Auth::guest()){
            $following =0;
        } else if (Auth::user()){
            $following=count(Follow::where('user_id', Auth::user()->id)
              ->where('achievement_id', $id)
              ->get())>0;
        }
        $proofs = Proof::where('achievement_id', $id)->orderBy('created_at', 'desc')->get();
        if (Auth::user()){
            $votes = Vote::where('achievement_id', $id)->where('user_id', Auth::user()->id)->get();
        } else if (Auth::guest()){
            $votes = null;
        }
        return View::make('Achievement.show', [
            "main"=>Achievement::where('id', $id)->first(),
            "proofs"=>$proofs,
            "votes"=>$votes,
            "following"=>$following,
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
