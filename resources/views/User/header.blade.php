
@if (Auth::user() && Auth::user()->id != $profile->id)
    <div class='inline margin-left' style='margin-top:0px;' >
        {{$profile->score}} {{$point_caption}}
    </div>
   	- Registered {{date('M d, Y', strtotime($profile->created_at))}}
     
    <a  class='margin-left' style='display:block;' href="{{route('new_message', ['id'=>$profile->id])}}">Send Message</a>
@else
    <div class='inline margin-left'>{{$profile->score}} {{$point_caption}}</div>
    <div class='inline right margin-right'> Registered {{date('M d, Y', strtotime($profile->created_at))}}</div>
@endif
