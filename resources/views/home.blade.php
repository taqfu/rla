<?php use App\User; ?>
@extends('layouts.app')

@section('content')
<div id='homepage'>
<?php 

$old_date = 0; 
$old_time =0; 
?>
@forelse ($timeline_items as $timeline_item)
    <?php
    if (Auth::guest()){
    $timestamp = date('m/d/y h:i:sA e', strtotime($timeline->created_at));
    } else if (Auth::user()){
      $timestamp = date('m/d/y h:i:sA', User::local_time(Auth::user()->timezone, strtotime($timeline_item->created_at)));
    }
    ?>
    <div class='timeline_container'>
    @if ($timeline_item->event=="new comment" || $timeline_item->event=="new proof vote comment")
        @include ("Timeline.comment")
    @elseif ($timeline_item->event=='new proof')
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'> 
            <p>
            @if ($timeline_item->proof->user_id==Auth::user()->id)
                You
            @else
                <a href="{{route('user.show', ['id'=>$timeline_item->proof->user_id])}}">{{$timeline_item->proof->user->username}}</a>
            @endif
              submitted a <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">new proof</a> for your achievement.
            </p>
            <p>
                (<a href="{{route('achievement.show', ['id'=>$timeline_item->proof->achievement_id])}}#proof{{$timeline_item->proof_id}}">{{$timeline_item->proof->achievement->name}}</a>)
            </p>
        </div>
    @elseif (substr($timeline_item->event,0, 10)=="swing vote")
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div> 
        <div class='notification margin-left'>
            {{$timeline_item->vote->user->username}} voted
            @if ($timeline_item->vote->vote_for)
                for
            @else
                against
            @endif
            <a href="{{route('proof.show', ['id'=>$timeline_item->vote->proof_id])}}">your proof</a>
            for <a href="{{route('achievement.show', ['id'=>$timeline_item->vote->achievement_id])}}">"{{$timeline_item->vote->achievement->name}}"</a>.

            It is now
            @if ($timeline_item->event=='swing vote - approved')
              passing
            @elseif ($timeline_item->event=='swing vote - denied')
              failing
            @endif
            .
        </div>
    @elseif (substr($timeline_item->event, 0, 19 )=="change proof status")
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
            @if ($timeline_item->proof->user_id==Auth::user()->id)
            <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">Your proof</a>
            @else
                @if (substr($timeline_item->proof->user->username, -1, 1)=="s")
                <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">{{$timeline_item->proof->user->username}}' proof</a>
                @else
                <a href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}">{{$timeline_item->proof->user->username}}'s proof</a>
                @endif 
            @endif
             for
            <a href="{{route('achievement.show', ['id'=>$timeline_item->proof->achievement_id])}}">"{{$timeline_item->proof->achievement->name}}"</a> has been
            @if (substr($timeline_item->event, -1, 1) == "1")
              approved
            @elseif (substr($timeline_item->event, -1, 1) == "0")
              denied
            @endif
            .
            
            @if (substr($timeline_item->event, -1, 1) == "1")
            <p class='social'>                
                <div class="fb-share-button" data-href="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}" data-layout="button" data-mobile-iframe="true"></div>            
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="{{route('proof.show', ['id'=>$timeline_item->proof_id])}}" 
                  data-text="I just completed an achievement! '{{substr($timeline_item->proof->achievement->name, 0, 32)}}'
                  @if (strlen($timeline_item->proof->achievement->name)>32)
                  ...
                  @endif'" 
                  data-via="doit_proveit">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </p>
            @endif
        </div>
    @elseif (substr($timeline_item->event, 0, 15)=="new achievement")
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>
        <div class='notification margin-left'>
            <p>
            You created a new achievement. 
            </p>
            <p>
                <div class="fb-share-button" data-href="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}" data-layout="button" data-mobile-iframe="true"></div>            
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}" 
                  data-text="I just created a new achievement! '{{substr($timeline_item->achievement->name, 0, 32)}}'
                  @if (strlen($timeline_item->achievement->name)>32)
                  ...
                  @endif'" 
                  data-via="doit_proveit">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    
            </p>
            @if($timeline_item->event=="new achievement no proof")
                <p>(Unfortunately, you provided no proof, so its inactive.)</p>
            @endif
            <p>
                (<a href="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}">{{$timeline_item->achievement->name}}</a>)
            </p>
        </div>
    @elseif (substr($timeline_item->event, 0, 25)=="change achievement status")
        <div class='notification' title='{{$timestamp}}'>{{interval($timeline_item->created_at, "now")}} ago</div>  
        <div class='notification margin-left'>
            The achievement you created
            <a href="{{route('achievement.show', ['id'=>$timeline_item->achievement_id])}}">"{{$timeline_item->achievement->name}}"</a>            
            @if (substr($timeline_item->event, -1, 1)=="0")
                has failed approval.
            @elseif (substr($timeline_item->event, -1, 1)=="1")
                is now approved.
            @elseif (substr($timeline_item->event, -1, 1)=="2")
                is currently under approval.
            @endif
        </div>
    @else
    <?php var_dump($timeline_item->event); ?>
    @endif
    </div>
@empty
<div class='center'>
Your timeline is empty. You need to create new achievements, comment or submit proof to existing achievements in order to fill your timeline.
</div>
@endforelse
</div>
@endsection
