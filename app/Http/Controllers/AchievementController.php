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
        $status = [];
        $filters = ["status"=>[$request->denied, $request->approved,  $request->pending, $request->canceled, $request->inactive]];
        foreach ($filters["status"] as $key=>$val){
            if ($val=="on"){
                $status[]=$key;
            }
        }
        
        $achievements = Achievement::whereIn('status', $status)->get();
        $achievements = Achievement::sort($achievements, $request->Input('sort'));
        Proof::check();
        return View::make('Achievement.index', [
          "achievements"=>$achievements,
          "sort"=>$request->input('sort'),
          "filters"=>$filters,
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
    public function query(Request $request){
        return View::make('Achievement.query', [
            "achievements"=>Achievement::where('name', 'LIKE', '%'.$request->searchQuery . '%')->orderBy('score', 'desc')->take(10)->get(),            
            "achievementDoesNotExist"=>count(Achievement::where('name', $request->searchQuery)->get())==0,            
            "searchQuery"=>$request->searchQuery,        
        ]);



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
        ]);
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
        $achievement->status = 3;
        $achievement->save();

        $follow = new Follow;
        $follow->user_id = Auth::user()->id;
        $follow->achievement_id = $achievement->id;
        $follow->save();

        $timeline = new Timeline;
        $timeline->user_id = Auth::user()->id;
        $timeline->event = "new achievement";
        $timeline->achievement_id = $achievement->id;
        $timeline->save();

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
        $achievement =Achievement::where('id', $id)->first(); 
        if ($achievement==NULL){
            return View::make('Achievement.fail');
        } else if ($achievement!=NULL){
            return View::make('Achievement.show', [
                "main"=>$achievement,
                "proofs"=>$proofs,
                "votes"=>$votes,
                "following"=>$following,
            ]);
        }
    }
    public function showProofs(Request $request, $id)
    {
        switch ($request->input('sort')){
            case "created_at asc":
                $column="created_at";
                $direction="asc";
                break;
            case "created_at desc":
                $column="created_at";
                $direction="desc";
                break;
            case "id asc":
                $column="id";
                $direction="asc";
                break;
            case "id desc":
                $column="id";
                $direction="desc";
                break;
            case "url asc":
                $column="url";
                $direction="asc";
                break;
            case "url desc":
                $column="url";
                $direction="desc";
                break;
            case "status asc":
                $column="status";
                $direction="asc";
                break;
            case "status desc":
                $column="status";
                $direction="desc";
                break;
            default:
                $column="created_at";
                $direction="desc";
                break;
        }
        $proofs = Proof::where('achievement_id', $id)->orderBy($column, $direction)->get();
        if (Auth::guest()){
            $following =0;
        } else if (Auth::user()){
            $following=count(Follow::where('user_id', Auth::user()->id)
              ->where('achievement_id', $id)
              ->get())>0;
        }
        if (Auth::user()){
            $votes = Vote::where('achievement_id', $id)->where('user_id', Auth::user()->id)->get();
        } else if (Auth::guest()){
            $votes = null;
        }
        $achievement =Achievement::where('id', $id)->first(); 
        if ($achievement==NULL){
            return View::make('Achievement.fail');
        } else if ($achievement!=NULL){
            return View::make('Achievement.proofs', [
                "main"=>$achievement,
                "proofs"=>$proofs,
                "votes"=>$votes,
                "following"=>$following,
                "sort"=>$request->input('sort'),
            ]);
        }
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
