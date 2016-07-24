<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InviteController extends Controller
{
    public function store(Request $request){
        if (Auth::guest()){
            return back()->withErrors('Please log in before doing this.');
        }
        $this->validate($request, [
            'email' => 'required|email|unique:invites',
        ]);
        //Need a custom error message to inform users why their invite was denied. (Duplicate email)

        
    }
}
