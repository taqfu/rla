@extends ('layouts.app')

@section('content')
<p>
    <i>This is where you'll be able to see the changes I've made.</i> 
    Head <a href="{{route('feedback')}}">here</a> to give feedback.
</p>
<h4>07/19/16</h4>
<ul>
    <li>
        Fixed a bug where new proofs weren't being properly displayed.
    </li>
</ul>
<h4>07/18/16</h4>
<ul>
    <li>
        Achievement listing is now more persistent with filtering and sorting. So if you change the listings filter and sort, then go to a profile and come back, it will still be the same sort and filter.
    </li>
    <li>
        Subscriptions are now visible on the timeline homepage.
    </li>
</ul>
<h4>07/14/16</h4>
<ul>
    <li>
        There's now a menu on each achievement listing row to subscribe to achievements, add them to your bucket list or submit a claim of completion. 
    </li>
    <li>
        User profiles now referenced by username and not by id number.
    </li>
</ul>
<h4>07/13/16</h4>
<ul>
    <li>
        Timeline is now more efficiently structured and is part of the achievement profile as well as homepage. Subscriptions have been disabled until they can be integrated into this new system.
    </li>
    <li>
        Users can now see other user's bucket lists in their profiles.
    </li>
</ul>
<h4>07/06/16</h4>
<ul>
    <li>
        Addressed a bug that shut down access to the achievement listing for about six hours. If you ever notice an issue like this, please contact me <a href="mailto:admin@doitproveit.com">here</a>.
    </li>
</ul>
<h4>07/05/16</h4>
<ul>
    <li>
        Achievements on the listings page have been paginated.
    </li>
    <li>
        Claimed achievements now have a light checkmark next to them.
    </li>
</ul>
<h4>07/04/16</h4>
<ul>
    <li>
        When claiming to have completed an achievement, it no longer updates timeline. (Changes to timeline coming.)
    </li>
    <li>
        You will not receive points for completing an achievement for a second time.
    </li>
    <li>
        User will now receive a message when they are unable to vote on an achievement because they have not completed it yet.
    </li>

</ul>
<h4>07/03/16</h4>
<ul>
    <li>
        Achievement profile URLs are now referenced by name and not by ID number.
    </li>
    <li>
        Voting no longer requires the page to reload.
    </li>
</ul>
<h4>06/30/16</h4>
<ul>
    <li>
        Users can now create multiple proofs for completing an achievement multiple times.
    </li>
    <li>
        Users no longer need to include "http://" when submitting a URL proof. 
    </li>
</ul>
<h4>06/29/16</h4>
<ul>
    <li>
        Created a bucket list. Now you can add achievements you'd like to accomplish.
    </li>
    <li>
        Added list of people who have claimed to have completed an achievement to the achievement profile.
    </li>
</ul>
<h4>06/28/16</h4>
<ul>
    <li>You can now claim to have completed achievements without proof. </li>
    <li>Following is now subscribing and it's just one button.</li>
</ul>
<h4>06/27/16</h4>
<ul>
    <li>Added information to achievement header</li>
    <li>Fixed bug where canceling proof would leave achievements permanently pending approval.</li>
</ul>
<h4>06/26/16</h4>
<ul>
    <li>Added a proofs table to achievement profile page.</li>
    <li>Replaced "Inbox" with corresponding glyphicon. (<a href="http://glyphicons.com/">Glyphicons are awesome.</a>)
    </li>
</ul>
<h4>06/24/16</h4>
<ul>
    <li>Redesigned the proof page. Cleaner design now.</li>

</ul>
<h4>06/23/16</h4>
<ul>
    <li>Fleshed out the landing page.</li>
    <li>About Us is now Guidelines</li>
</ul>
<h4>06/22/16</h4>
<ul>
    <li>Redesigned site again. This time making a more responsive site by integrating Bootstrap. </li>
</ul>
<h4>06/20/16</h4>
<ul>
    <li>Redesigned the site layout.</li>
    <li>Redid sorting and filtering of achievements.</li>
    <li>Removed Inventory.</li>
</ul>
<h4>06/17/16</h4>
<ul>
    <li>Creating achievements has now been integrated into a single search/create text bar.</li>
    <li>Going to a profile page for an achievement that has been deleted will now not cause an error. (Achievements that are deleted are mainly test achievements. We are not trying to avoid censorship.</li>
</ul>
<h4>06/15/16</h4>
<ul>
    <li>Comments now visible in user's profile.</li>
</ul>
<h4>06/14/16</h4>
<ul>
    <li>Inventory achievements can also be sorted.</li>
</ul>
<h4>06/13/16</h4>
<ul>
    <li>User profiles have been extended to include completed achievements, followed achievements and when user signed up.</li>
    <li>
        <del>Achievement unlocked CSS icon removed from public front page due to compatiblity issue with lower resolutions.</del>
        <ins>Resolved. (Still not on mobile.)</ins>
    </li>
    <li>Achievement listings can now be sorted.</li>
</ul>
<h4>06/12/16</h4>
<ul>
    <li>Inventory created. Users can manage now achievements that they are following or completed.</li>
</ul>
<h4>06/11/16</h4>
<ul>
    <li>Fixed a bug with submitting proof to already created achievements. Proof was submitting but the follows, votes and timeline were not being implemented.</li>
    <li>Fixed footer not displaying properly in mobile.</li>
    <li>When user's points are updated, this information will be added to their timelines.</li>
    <li>Proof submission can be cancelled if it is still pending approval.</li>
</ul>
<h4>06/10/16</h4>
<ul>
    <li>Hopefully made the filters a little clearer by changing the caption names and also adding a (?) tooltip to it.</li>
    <li>Achievement score now visible to guests. Achievements listed by score in descending order.</li>
    <li>Achievement score is now added to user's score on completion. (This means negative scores will be deducted from your score.)</li>
    <li>When someone completes your achievement, you receive a point.</li>
</ul>
<h4>06/09/16</h4>
<ul>
    <li>Added voting to achievements. Thanks <a href="https://www.reddit.com/user/bobyd">/u/bobyd</a>!</li>
    <li>Inactive and denied achievements are now not visible by default.</li>
    <li>Achievement filter menu on achievement listings page is hopefully a little clearer now.</li>
</ul>
@endsection
