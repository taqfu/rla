
@extends('layouts.app')
@section('title')
 - Settings
@endsection

@section('content')
@include ('User.header')
@include ('User.menu', ['active'=>'settings'])
<div id='settings' class='margin-left'>
        <div class='lead'><strong>
        @if ($errors->get('email'))
            @foreach ($errors->get('email') as $error)
            <div class='text-danger'>{{$error}}</div>
            @endforeach
        @endif
        </strong></div>
    <h4>Password</h4>
        @if ($errors->get('old') || $errors->get('new') || $errors->get('confirm') || $errors->get('success'))
            @foreach ($errors->get('confirm') as $error)
                <div>{{$error}}</div>
            @endforeach
            @foreach ($errors->get('old') as $error)
                <div>{{$error}}</div>
            @endforeach
            @foreach ($errors->get('new') as $error)
                <div>{{$error}}</div>
            @endforeach
            @foreach ($errors->get('success') as $error)
                <div>{{$error}}</div>
            @endforeach
        @endif
    <form method="POST" action="{{route('settings.password')}}" class='clearfix'>
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div id='change-password' class='margin-left'>
            <div class='form-group'>
                <div>
                    <label for='old_password'>Old Password:</label>
                </div>
                <div>
                    <input type='password' name='old' id='old_password' />
                </div>
            </div>
            <div class='form-group'>
                <div>
                    <label for='new_password'>New Password:</label>
                </div>
                <div>
                    <input type='password' name='new' id='new_password' />
                </div>
            </div>
            <div class='form-group'>
                <div>
                    <label for='new_password_confirm'>Confirm Password:</label>
                </div>
                <div>
                    <input type='password' name='new_confirmation' id='new_password_confirm' />
                </div>
            </div>
            <div>
                <input type='submit' value='Change Password' />
            </div>
        </div>
    </form>
    <h4 class='clearfix'>E-mail Address</h4>
    <p class='margin-left'>
        Your e-mail address is:
        @if (empty(Auth::user()->email))
        None
        @else
        {{Auth::user()->email}}
        @endif
    </p>
    <form method="POST" action="{{route('settings.email')}}" class='margin-left'>
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <input type='email' name='email' />
        <input type='submit' value='Change E-mail' />
    </form>
    <h4>Tme Zone</h4>
    <p class='margin-left'>
        Your time-zone is: {{Auth::user()->timezone}}
    </p>
    <form method="POST" action="{{route('settings.timezone')}}" class='margin-left'>
        <div>
        @if ($errors->get('timezone'))
            @foreach ($errors->get('timezone') as $error)
            <div class='text-danger'>{{ $error }}</div>
            @endforeach
        @endif
        </div>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <select name='timezone'>
        <?php
        $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        
            foreach($tzlist as $tz){
                echo "<option ";
                if ($tz == Auth::user()->timezone){
                    echo "selected";
                }
                echo ">$tz</option>";
            }
        ?>
        </select>
        <input type='submit' value='Change Time Zone' />
    </form>

<!--
    <h4>Invite Your Friends</h4>
    <form method="POST" action="{{route('invite.store')}}" class='margin-left'>
        @if(count($errors->all())>0)
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        @endif
        {{csrf_field()}}
        <div>
            What's their e-mail?
        </div>
            <input type='text' name='email' />
        <button type='submit' />
            Invite
        </button>
    -->  
</div>
@endsection
