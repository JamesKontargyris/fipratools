@extends('layouts.login')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3 style="color:white;">Reset your Password</h3>
        </div>
    </div>
    @include ('layouts.partials.messages')

            {{ Form::open(['url' => '/password/reset', 'method' => 'POST']) }}
            <div class="formfield">
                {{ Form::label('email', 'Please enter your registered email address:') }}
                {{ Form::text('email', Input::old('email')) }}
            </div>

            <p>A temporary password will be emailed to you. You will be prompted to change your password when you login with your temporary password.</p>

            <div class="formfield">
                {{ Form::submit('Reset', ['class' => 'secondary']) }} <a href="/" class="secondary">Cancel</a>
            </div>
            {{ Form::close() }}
@stop