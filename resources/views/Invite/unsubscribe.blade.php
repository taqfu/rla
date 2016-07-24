@extends('layouts.app')
@section('content')
@if ($invite->unsubscribed)
You've already been unsubscribed. If you still receive messages after this point, please email us <a href="mailto:admin@doitproveit.com">here</a> and we will try to correct the issue. We apologize for any inconvenience.
@else
<form method="POST" action="{{route('invite.update', ['email'=>$email])}}">
{{csrf_field()}}
{{method_field('PUT')}}
<button type='submit'>
    Unsubscribe {{$email}}
</button>
</form>
@endif
@endsection
