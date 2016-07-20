<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\Claim;
use App\Goal;
use App\Proof;
use App\Timeline;


class AchievementTimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tally = 0;
        $achievements = Achievement::get();
        foreach($achievements as $achievement){
            $timeline = Timeline::where('achievement_id', $achievement->id)
              ->where('event', 'new achievement')->first();
            if ($timeline==null){
                $timeline = new Timeline;
                $timeline->achievement_id = $achievement->id;
                $timeline->created_at = $achievement->created_at;
                $timeline->updated_at = $achievement->updated_at;
                $timeline->user_id = $achievement->user_id;
                $timeline->event = 'new achievement';
                //$timeline->save();
                //$tally++;
            }
        }
        var_dump($tally);
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
