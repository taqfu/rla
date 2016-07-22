<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Achievement;
use App\AchievementVote;
use App\Claim;
use App\Follow;
use App\Goal;
use App\Proof;
use App\Timeline;
use App\User;
use App\Vote;

use Auth;
use Config;
use DB;
use Illuminate\Pagination\Paginator;
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
        Proof::check();
        $status = [];
        $status_arr_captions =["denied", "approved", "pending", "inactive", "canceled"];
        if (session('achievement_filters')==null){
            $achievement_filters = [
              "status"=>[
                'denied'=>false, 
                'approved'=>true, 
                'pending'=>true,
                'inactive'=>false,
                'canceled'=>false,
              ],
              "incomplete"=>true,
              "complete"=>false,
              "claimed"=>false,
              "followed"=>false,
            ];
            $request->session()->put('achievement_filters', $achievement_filters);
        }
        foreach (session('achievement_filters')["status"] as $key=>$val){
            if ($val){
                $status[]=array_search($key, $status_arr_captions);
            }
        }
        $request->session()->put('achievement_sort', $request->sort);
        $sort_by = "score";
        $order = "desc";
        if (session('achievement_sort')!=null && substr(session('achievement_sort'), -3)=="asc"){
            $sort_by = substr(session('achievement_sort'), 0, strlen(session('achievement_sort'))-4);
            $order = "asc";
        } else if (session('achievement_sort')!=null 
          && substr(session('achievement_sort'), -4)=="desc"){
            $sort_by = substr(session('achievement_sort'), 0, strlen(session('achievement_sort'))-5);
        } 
        switch($sort_by){
            case "date": 
                $sort_by="created_at";
                break;
            case "points":
                $sort_by="score";
                break;
        }
        $achievements = Achievement::whereIn('status', $status)->orderBy($sort_by, $order)
        ->get();
//          ->simplePaginate(25);
         $perPage = 10; // Item per page (change if needed) 
         $currentPage = ($request->input('page') == 0
           ? 1
           : $request->input('page')) -1; 
         if (session('achievement_filters')["complete"] || session('achievement_filters')["incomplete"] ||session('achievement_filters')["claimed"] || session('achievement_filters')["followed"]){
             $filteredAchievements = $achievements->filter(function($achievement){
             
                 if ((session('achievement_filters')["complete"] 
                     && Achievement::has_user_completed_achievement($achievement->id))
                   || (session('achievement_filters')["incomplete"] 
                     && !Achievement::has_user_completed_achievement($achievement->id))
                   || (session('achievement_filters')["claimed"] 
                     && Achievement::has_user_claimed_achievement($achievement->id)) 
                   || (session('achievement_filters')["followed"] 
                     && Achievement::has_user_followed_achievement($achievement->id))){
                             return $achievement;
                 }
             });
             $pagedData = $filteredAchievements ->slice($currentPage * $perPage, $perPage)->all(); 
             $achievements = new Paginator($pagedData, $perPage, $currentPage);
         } else {
             $pagedData = $achievements->slice($currentPage * $perPage, $perPage)->all(); 
             $achievements = new Paginator($pagedData, $perPage, $currentPage);
         }
        return View::make('Achievement.index', [
          "achievements"=>$achievements,
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
        $error=Achievement::did_they_just_create_an_achievement();
        if ($error!=false){
            return back()->withErrors($error)->withInput();
        }

        $achievement_url = preg_replace("/\s+/", "-", 
          trim(strtolower(preg_replace("/\p{P}/", " ", $request->name))));
        $num_of_records = 
          count(DB::select("select * from achievements where substring(url, 1, length(?))=?", 
          [$achievement_url, $achievement_url]));
        if ($num_of_records!=0){
            $achievement_url = $achievement_url . "-".++$num_of_records;
        }
        $new_achievement_id = Achievement::new_db_entry($request->name, $achievement_url);
        AchievementVote::new_db_entry($new_achievement_id);
        Follow::new_db_entry($new_achievement_id);

        $timeline = new Timeline;
        $timeline->user_id = Auth::user()->id;
        $timeline->event = "new achievement";
        $timeline->achievement_id = $new_achievement_id;
        $timeline->save();

        return redirect()->route('achievement.show', ['url'=>$achievement_url]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url){
        $achievement = Achievement::where("url", $url)->first();
        if ($achievement==null){
            return View::make('Achievement.fail');
        }
        $user_data = User::fetch_achievement_data($achievement->id);
        $achievement_id = $achievement->id; // use function for timelines doesn't work with obj ref
        return View::make('Achievement.show', [
            "main"=>$achievement,
            "timelines"=>Timeline::where(function($query) use ($achievement_id){
                  $query->where('achievement_id', $achievement_id)->where('event', 'new claim');
              })->orWhere(function($query) use ($achievement_id){
                  $query->where('achievement_id', $achievement_id)->where('event', 'new proof');
              })->orWhere(function($query) use ($achievement_id){
                  $query->where('achievement_id', $achievement_id)->where('event', 'new goal');
              })->orderBy('created_at', 'desc')->get(),
            "following"=>$user_data['subscribed'],
            "user_claim"=>$user_data['claim'],
            "user_goal"=>$user_data['goal'],
            "user_proof"=>$user_data['proof'],
        ]);
    }
    public function showClaims(Request $request, $url){
        $achievement =Achievement::where('url', $url)->first();
        if ($achievement==NULL){
            return View::make('Achievement.fail');
        }
        $claims = Claim::where('achievement_id', $achievement->id)->orderBy('created_at', 'desc')
          ->get();
        $user_data = User::fetch_achievement_data($achievement->id);
        return View::make('Achievement.claims', [
            "main"=>$achievement,
            "claims"=>$claims,
            "following"=>$user_data['subscribed'],
            "user_claim"=>$user_data['claim'],
            "user_goal"=>$user_data['goal'],
            "user_proof"=>$user_data['proof'],
        ]);
    }
    public function showDiscussion($url){
        $achievement = Achievement::where('url', $url)->first();
        if ($achievement==NULL){
            return View::make('Achievement.fail');
        }
        $user_data = User::fetch_achievement_data($achievement->id);
        return View('Achievement.discussion', [
            'main'=>$achievement,
            "following"=>$user_data['subscribed'],
            "user_claim"=>$user_data['claim'],
            "user_goal"=>$user_data['goal'],
            "user_proof"=>$user_data['proof'],
        ]);

    }
    public function showProofs(Request $request, $url){
        $achievement = Achievement::where('url', $url)->first();
        if ($achievement==NULL){
            return View::make('Achievement.fail');
        }
        $sort = Proof::fetch_sort($request->input('sort'));
        $proofs = Proof::where('achievement_id', $achievement->id)
          ->orderBy($sort['column'], $sort['direction'])->get();
        $user_data = User::fetch_achievement_data($achievement->id);
        return View::make('Achievement.proofs', [
            "main"=>$achievement,
            "proofs"=>$proofs,
            "sort"=>$request->input('sort'),
            "following"=>$user_data['subscribed'],
            "user_claim"=>$user_data['claim'],
            "user_goal"=>$user_data['goal'],
            "user_proof"=>$user_data['proof'],
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
        $achievement_filters = [
          "status"=>[
            'denied'=>$request->denied=="on", 
            'approved'=>$request->approved=="on", 
            'pending'=> $request->pending=="on", 
            'inactive'=>$request->inactive=="on", 
            'canceled'=>$request->canceled=="on"
          ],
          "incomplete"=>$request->incomplete=="on",
          "complete"=>$request->complete=="on",
          "claimed"=>$request->claimed=="on",
          "followed"=>$request->followed=="on"
        ];
        $request->session()->put('achievement_filters', $achievement_filters);
        return redirect(route('achievement.index'));
    }
}
