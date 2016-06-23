
        <div class="fb-share-button" data-href="{{route('timeline.show', ['id'=>$timeline_item->id])}}" data-layout="button" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdoitproveit.com%2F&amp;src=sdkpreparse">Share</a></div>
        <div class='inline align-middle'>
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="{{route('timeline.show', ['id'=>$timeline_item->id])}}" data-via="doit_proveit">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        </div>
