<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Proof;
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
        //
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
            return;
        }
        $this->validate($request, [
            'proofURL' => 'required|url|max:255',
            'achievementID' =>'required|integer',
        ]);
        //CHECK IF PROOF IS ALREADY PENDING OR APPROVED FIRST
        $proof = new Proof;
        $proof->user_id = Auth::user()->id; 
        $proof->achievement_id = $request->achievementID;
        $proof->url = $request->proofURL;
        $proof->status = 2;
        $proof->save();
    }
        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('Proof.show', [
            "proof"=>Proof::where('id', $id)->first(),
            "votes"=>Vote::where('proof_id', $id)->get(),
            "num_of_for_votes"=>count(Vote::where('proof_id', $id)->where('vote_for', true)->get()),
            "num_of_against_votes"=>count(Vote::where('proof_id', $id)->where('vote_for', false)->get()),
            "passing"=>Proof::passing_approval($id),
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
