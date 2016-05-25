<?php

namespace App\Http\Controllers;

define ('MIN_TIME_TO_MSG', 60);

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Message;

use Auth;
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
            'receiver' => 'required|integer|min:1',
            'message' => 'required|string|max:21844'
        ]);
        $last_message = Message::where('from_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if(($last_message!=null && time()-strtotime($last_message->created_at) < MIN_TIME_TO_MSG)){
            $num_of_seconds = time()-strtotime($last_message->created_at); 
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
