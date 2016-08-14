<div id="edit-story{{$story->id}}" class='edit-story 
  @if ($hidden)
      hidden
  @endif
  '>
    <form method="POST" action="{{route('story.update', ['id'=>$story->id])}}" class='inline'>
        {{csrf_field()}}
        {{method_field('PUT')}}
        <textarea class='form-control' name='story'>{{$story->story}}</textarea>
        <button>
            Save
        </button>
    </form>
    <button id='hide-edit-story{{$story->id}}' class='hide-edit-story'>
        Cancel
    </button>
</div>
