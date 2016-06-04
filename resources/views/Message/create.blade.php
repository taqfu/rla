@extends('layouts.app')
@section('content')
<div>
@if ($errors->any())
    @foreach($errors->all() as $error)
        {{$error}}
    @endforeach
@endif
</div>
<form method="POST" action="{{route('message.store')}}" class='message'>
    {{csrf_field()}}
    <p>
        To:<a href="{{route('user.show', ['id'=>$profile->id])}}" id='message_receiver'>{{$profile->username}}</a>
    </p>
    <input type='hidden' name='receiver' value='{{$profile->id}}' />
    <textarea name='message' class='message' maxlength='21844'>{{old('message')}}</textarea>
    <input type='submit' value='Message' class='message'/> 
</form>
@endsection
