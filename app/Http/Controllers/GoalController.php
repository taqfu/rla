<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\AchievementTimeline;
use App\Goal;

use Auth;
class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()){
            return View('Goal.fail');
        } else if (Auth::user()){
            return View('Goal.index', [
                'goals'=>Goal::where('user_id', Auth::user()->id)->get(),
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
        $goal->save();
        
        $achievement_timeline = new AchievementTimeline;
        $achievement_timeline->achievement_id = $goal->achievement_id;
        $achievement_timeline->goal_id = $goal->id;
        $achievement_timeline->save();
        
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
        Goal::find($id)->delete();
        return back();    
    }
}
