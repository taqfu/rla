<div id="new-story-{{$table_name}}{{$id_num}}" class='new-story 
  @if ($hidden)
      hidden
  @endif
  '>
    <form method="POST" action="{{route('story.store')}}" class='inline'>
        {{csrf_field()}}
        <input type='hidden' name='tableName' value="{{$table_name}}" />
        <input type='hidden' name='idNum' value="{{$id_num}}" />
        <textarea class='form-control' name='story'></textarea>
        <button>
            Add Story
        </button>
    </form>
    <button class='hide-new-story'>
        Cancel
    </button>
</div>
