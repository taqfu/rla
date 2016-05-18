    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
<form class='form-horizontal' method="POST" action="{{ route('achievement.store') }}">
    {{ csrf_field() }}
        <label>
            Achievement Name: 
        </label>
        <input type='text' name='name' /> 
    <label style='margin-left:16px;'>
        URL Of Proof:
    </label>
    <input type='text' name='proofURL' />
    <input type='submit' value='Submit Approval' style='margin-left:16px;'> 
</form>
