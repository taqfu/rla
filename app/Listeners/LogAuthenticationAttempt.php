<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use DB;
use Request;
class LogAuthenticationAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        DB::insert('insert into logins(created_at, updated_at, login, ip) values (now(), now(), ?, ?)', 
          [$event->credentials['username'], Request::ip()]);
    
    }
}
