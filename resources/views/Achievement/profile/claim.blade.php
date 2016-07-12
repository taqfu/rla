<?php
use \App\Achievement;
use \App\Claim;
use \App\User;
if (Auth::guest()){
    $timestamp = date(Config::get('rla.timestamp_format') . ' e', strtotime($claim->created_at));
} else if (Auth::user()){
    $timestamp = date(Config::get('rla.timestamp_format'),
      User::local_time(Auth::user()->timezone, strtotime($claim->created_at)));
}
?>
    <a name='claim{{$claim->id}}'></a>
    <div class='panel panel-default'>
    <div title='{{$timestamp}}' class='achievement-claim panel-body'>
        <div class='claim-timestamp text-center panel-heading'>{{interval($claim->created_at, 'now')}} ago</div>
        <div class='text-center'><a href="{{route('user.show', ['id'=>$claim->user->id])}}">{{$claim->user->username}}</a>
            submitted <a href="{{route('claim.show', ['id'=>$claim->id])}}">claim</a> of completion.
            (<a target='_blank' href="{{$claim->url}}">{{$claim->url}}</a>)
        </div>
        <div class='text-center'>
        </div>
        <div>
            &nbsp;
            @if ( Claim::can_user_comment($claim->id))
            <button id='show-new-comment{{$claim->id}}' class='show-new-comment btn-link'>[ Comment ]</button>
            @endif

            @if (count($claim->comments)>0)
                <input type='button' id='show-comments{{$claim->id}}' class='show-comments btn-link'
                  value='[ Show Comments ({{count($claim->comments)}}) ]' />
            @endif
            @if (Proof::can_user_comment($claim->id))
                @include ('Comment.create', ['table'=>'claim', 'table_id'=>$claim->id, 'show'=>false])

            @endif
        </div>
        @if (count($claim->comments)>0)
        <div id='comments{{$claim->id}}' class='achievement-claim-comments container hidden'>
            <input type='button' id='hide_comments{{$claim->id}}' class='hide_comments btn-link btn-lg' value='[ - ]' />
            <div id='comments{{$claim->id}}' class=''>
                @foreach ($claim->comments as $comment)
                    @include ('Comment.show', ['comment'=>$comment])
                @endforeach
            </div>
        </div>
        @endif
    </div>
    </div>
