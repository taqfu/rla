<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\Message;
use App\User;

use Auth;
use Config;

class MessageController extends Controller
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
    public function create($username)
    {
        return View('Message.create', [
            'profile'=> User::where('username', $username)->first(),
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
            'receiver' => 'required|integer|min:1',
            'message' => 'required|string|max:21844'
        ]);
        $last_message = Message::where('from_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if(($last_message!=null && time()-strtotime($last_message->created_at) < Config::get('rla.min_time_to_msg'))){
            $num_of_seconds = Config::get('rla.min_time_to_msg') - (time()-strtotime($last_message->created_at));
            return back()->withErrors("You are doing this too often. Please wait $num_of_seconds seconds.")->withInput();
        }
        $message = new Message;
        $message->from_user_id = Auth::user()->id;
        $message->to_user_id = $request->receiver;
        $message->message = $request->message;
        $message->save();
        return back()->withErrors("Message sent!");
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

     public function showInbox(){
         if (Auth::guest()){
             return View('Message.fail');
         } else if (Auth::user()){
             return View('Message.inbox', [
                 'profile'=>User::find(Auth::user()->id),
                 'messages'=>Message::where('to_user_id', Auth::user()->id)
                   ->orderBy('created_at', 'desc')->get(),
             ]);
         }
    }
    public function showOutbox(){
        if (Auth::guest()){
            return View('Message.fail');
        } else {
            return View('Message.outbox', [
                'profile'=>User::find(Auth::user()->id),
                'messages'=>Message::where('from_user_id', Auth::user()->id)
                  ->orderBy('created_at', 'desc')->get(),
            ]);
        }
    }
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
            $message = Message::find($id);
            $message->read = $request->read == 'true';
            $message->save();
            return back();
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
