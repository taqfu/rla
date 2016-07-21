<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Follow;
use App\Timeline;
use Auth;

use View;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (session('timeline_filters')==null){
            $timeline_filters = [
              'new_proof'=>true,
              'change_proof_status'=>true,
              'cancel_proof'=>true,
              'swing_vote'=>true,
              'new_achievement'=>true,
              'change_achievement_status'=>true,
              'new_goal'=>true,
              'new_claim'=>true,
              'new_comment'=>true,
            ];
            $request->session()->put('timeline_filters', $timeline_filters);
        }
        if (Auth::guest()){
            return View('Timeline.index', [
                'timeline_items'=>Timeline::orderBy('created_at', 'desc')->get(),
            ]);
        }
        
        $subscribed_achievements=[];
        foreach (Follow::where('user_id', Auth::user()->id)->get() as $follow){
            $subscribed_achievements[]=$follow->achievement_id;
        }
        $timeline_items = Timeline::orWhere('user_id', Auth::user()->id)
          ->orWhereIn('achievement_id', $subscribed_achievements)
          ->orderBy('created_at', 'desc')->get();
        $timeline_items = Timeline::filter_timeline($timeline_items);
        return View('Timeline.index', [
            "timeline_items"=>$timeline_items,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View::make('Timeline.show', [
            'timeline_item'=>Timeline::find($id),
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
    
    public function updateFilter(Request $request){
        $timeline_filters = [
          'new_proof'=>$request->newProof,
          'change_proof_status'=>$request->changeProofStatus,
          'cancel_proof'=>$request->cancelProof,
          'swing_vote'=>$request->swingVote,
          'new_achievement'=>$request->newAchievement,
          'change_achievement_status'=>$request->changeAchievementStatus,
          'new_goal'=>$request->newGoal,
          'new_claim'=>$request->newClaim,
          'new_comment'=>$request->newComment
        ];
        $request->session()->put('timeline_filters', $timeline_filters);
        return redirect(route('timeline.index'));
    }
}
