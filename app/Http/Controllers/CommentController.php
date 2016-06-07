<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Comment;
use App\Proof;
use App\Timeline;
use App\Vote;
use Auth;
use Config;
class CommentController extends Controller
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
        if (Auth::guest()){
            return back()->withErrors('Please log in before doing this.');
        }
        $this->validate($request, [
            'replyTo'=>'required|integer|min:0|max:0',
            'table'=>'required|string',
            'tableID'=>'required|integer|min:1',
            'comment'=>'required|string|max:21844'
        ]);
        $last_comment = Comment::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if(($last_comment!=null && time()-strtotime($last_comment->created_at) < Config::get('rla.min_time_to_comment'))){
            $num_of_seconds = Config::get('rla.min_time_to_comment') - (time()-strtotime($last_comment->created_at));
            return back()->withErrors("You are doing this too often. Please wait $num_of_seconds seconds.")->withInput();
        }
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        if ($request->table=='achievement'){
            $comment->achievement_id = $request->tableID;
        }else if ($request->table=='proof'){
            $comment->proof_id = $request->tableID;
        } else if ($request->table=='vote'){
            $comment->vote_id = $request->tableID;
        }
        $comment->save();
        if ($request->table=='achievement'){
            $followers_of_achievement = Achievement::fetch_followers($request->tableID);
            foreach ($followers_of_achievement as $follower){
                $timeline = new Timeline;
                $timeline->user_id = $follower;
                $timeline->event = "new comment";
                $timeline->comment_id = $comment->id;
                $timeline->save();
            }
        }else if ($request->table=='proof'){
            $proof = Proof::where('id', $request->tableID)->first();
            $timeline = new Timeline;
            $timeline->user_id = $proof->user_id;
            $timeline->event = "new comment";
            $timeline->comment_id = $comment->id;
            $timeline->save();

        } else if ($request->table=='vote'){
            $vote = Vote::where('id', $request->tableID)->first();
            $proof = Proof::where('id', $vote->proof_id)->first();
            $timeline = new Timeline;
            $timeline->user_id = $vote->user_id;
            $timeline->event = "new comment";
            $timeline->comment_id = $comment->id;
            $timeline->save();
            if ($vote->user_id!=$proof->user_id){
            $timeline = new Timeline;
            $timeline->user_id = $proof->user_id;
            $timeline->event = "new proof vote comment";
            $timeline->comment_id = $comment->id;
            $timeline->save();
            }
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
