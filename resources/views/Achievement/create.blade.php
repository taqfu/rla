<div class='center'>
    <form method="POST" action="{{ route('achievement.store') }}" class='achievement'>
        @foreach ($errors->all() as $error)
            {{$error}}
        @endforeach
        {{ csrf_field() }}
        <div>
            <label>Achievement Name:</label>
            <input type='text' name='name' value="{{old('name')}}" maxlength='100'/> 
        </div>
        <div>
            <label>URL Of Proof:</label>
            <input type='url' name='proofURL' value="{{old('proofURL')}}" maxlength='256'/>
        </div>
        <div>
            <input type='submit' value='Create Achievement'>
        </div>
    </form>
</div>
