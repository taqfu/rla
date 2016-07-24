<?php

namespace App\Http\Controllers;
use Auth;


use App\Http\Requests;

use App\Invite;
use App\User;

use Illuminate\Http\Request;

use Mail;
class InviteController extends Controller
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
            'email' => 'required|email|unique:invites',
        ],['unique'=>'An invite has already been sent to this email address.']);
        $email = $request->email;
        Mail::send('emails.invite', ['email'=>$request->email, 
          'username'=>Auth::user()->username], function ($m) use ($email) {
            $m->to($email)->from('invite@doitproveit.com', 'Do It! Prove It! Invitation')
              ->subject(Auth::user()->username . " has invited you to Do It! Prove It!");
        });
        
        $user = User::find(Auth::user()->id);
        $user->community_score++;
        $user->save();

        $invite = new Invite;
        $invite->email = $request->email;
        $invite->user_id = Auth::user()->id;
        $invite->save();

        return back()->withErrors('E-mail sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        return View('auth.register', ['registered_email'=>$email]); 
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
    public function update(Request $request, $email)
    {
        
        $invite = Invite::where('email', $email)->first();
        if ($invite->unsubscribed){
            echo "You've already been unsubscribed.";
        }
        $invite->unsubscribed=true;
        $invite->save();
        echo "You have been unsubscribed. We're very sorry for any inconvenience we may have caused.";
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    public function unsubscribe($email){
        return View('Invite.unsubscribe', [
          'invite'=>Invite::where('email', $email)->first(),
          'email'=>$email,
        ]);
    }
}
