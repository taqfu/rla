<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Proof;
use App\Timeline;
use App\Vote;

use Auth;
use View;
class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()){
            return View::make('Vote.guest');
        } else if (Auth::user()){
            return View::make('Vote.index', [
                "proofs"=>Proof::get(),
                "votes"=>Vote::where('user_id', Auth::user()->id)->get(),
            ]);
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
        if (Auth::guest()){
            return back()->withErrors('Please log in before doing this.');
        }
        $this->validate($request, [
            'proofID' => 'required|integer',
            'achievementID' =>'required|integer',
            'vote_for' => 'required|boolean|unique:votes,vote_for,NULL,id,user_id,'.Auth::user()->id.',proof_id,'.$request->proofID.',achievement_id,'.$request->achievementID,
        ]);
        $before = Proof::passing_approval($request->proofID);
        $vote = new Vote;
        $vote->vote_for = $request->vote_for;
        $vote->proof_id = $request->proofID;
        $vote->achievement_id = $request->achievementID;
        $vote->user_id = Auth::user()->id;
        $vote->save();
        $after = Proof::passing_approval($request->proofID);
        if ($before != $after){
            $proof = Proof::where('id', $request->proofID)->first();
            $timeline = new Timeline;
            $timeline->user_id = $proof->user_id;
            $caption = $after ? "approved" : "denied";
            $timeline->event = "swing vote - " . $caption;
            $timeline->vote_id = $vote->id;  
            $timeline->save();
        }
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


