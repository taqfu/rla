@extends ('layouts.app')

@section('content')
<p>
    <i>This is where you'll be able to see the changes I've made.</i> <a href="{{route('feedback')}}">Head here for any feedback.</a>
</p>
<h4>06/10/16</h4>
<ul>
    <li>Hopefully made the filters a little clearer by changing the caption names and also adding a (?) tooltip to it.</li>
    <li>Achievement score now visible to guests. Achievements listed by score in descending order.</li>
    <li>Achievement score is now added to user's score on completion. (This means negative scores will be deducted from your score.)</li>
</ul>
<h4>06/09/16</h4>
<ul>
    <li>Added voting to achievements. Thanks <a href="https://www.reddit.com/user/bobyd">/u/bobyd</a>!</li>
    <li>Inactive and denied achievements are now not visible by default.</li>
    <li>Achievement filter menu on achievement listings page is hopefully a little clearer now.</li>
</ul>
@endsection
