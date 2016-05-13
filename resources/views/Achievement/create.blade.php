<form class='form-horizontal' method="POST" action="{{ route('achievement.store') }}">
    {{ csrf_field() }}
    <label  class="col-md-4 control-label">
        Achievement Name: 
    </label>
    <div class='col-md-6'>
        <input type='text' 'name' /> 
    </div>
    <label  class="col-md-4 control-label">
        URL Of Proof:
    </label>
    <div class='col-md-6'>
        <input type='text' name='proofURL' />
    </div>
    <div class='col-md-6'>
        <input type='submit' value='Submit Approval' class="btn-primary"/>
    </div>
</form>
