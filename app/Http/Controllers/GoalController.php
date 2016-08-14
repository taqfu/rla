<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Goal;
use App\Timeline;
use Auth;
use View;
class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rerank=0;
        if ($rerank){
            $this::reorderRank(true);    
        }
        if (Auth::guest()){
            return View('Goal.fail');
        } else if (Auth::user()){
            return View('Goal.index', [
                'goals'=>Goal::whereNull('canceled_at')->where('user_id', Auth::user()->id)
                  ->orderBy('rank', 'asc')->get(),
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
            'achievementID' => 'required|integer',
        ]);
        
        $goal = new Goal;
        $goal->achievement_id = $request->achievementID;
        $goal->user_id = Auth::user()->id;
        $goal->rank = count(Goal::whereNull('canceled_at')->where('user_id', Auth::user()->id)
          ->get()) + 1;
        $goal->save();

        $timeline = new Timeline;
        $timeline->achievement_id = $goal->achievement_id;
        $timeline->user_id = $goal->user_id;
        $timeline->goal_id = $goal->id;
        $timeline->event = "new goal";
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
        $goal = Goal::find($id);
        $goal->canceled_at = date("Y-m-d H:i:s");
        $goal->save();
        $this::reorderRank(false);
        return back();
    }

    public function changeRank($old_rank, $new_rank){
        $start = $old_rank > $new_rank 
          ? $new_rank
          : $old_rank;
        $end = $old_rank == $start 
          ? $new_rank 
          : $old_rank;
        $goal = Goal::where('rank', $old_rank)->first();
        $goal->rank = $new_rank;
        $goal->save();
        
        foreach (Goal::whereNull('canceled_at')->where('id', '!=', $goal->id)
          ->where('rank', '>=', $start)->where('rank', '<=', $end)->orderBy('rank','asc')->get()
           as $goal){
            $old_rank < $new_rank ? $goal->rank-- : $goal->rank++;
            $goal->save();
        }
        if (Auth::guest()){
            echo "Somehow, your account was logged out. Log in and try again please.";
        } else if (Auth::user()){
            return View('Goal.index-bare', [
                'goals'=>Goal::whereNull('canceled_at')->where('user_id', Auth::user()->id)
                  ->orderBy('rank', 'asc')->get(),
            ]);
        }
       
    }
    public function reorderRank($byDate){
            $rank=1;
            $goals = $byDate 
              ? Goal::where('user_id', Auth::user()->id)->whereNull('canceled_at')->get() 
              : Goal::where('user_id', Auth::user()->id)->whereNull('canceled_at')->orderBy('rank', 'asc')->get();
            foreach($goals as $goal){
                $goal->rank=$rank++;
                $goal->save();
            }

    }
}


