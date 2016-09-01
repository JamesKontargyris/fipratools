@extends('layouts.login')

@section('content')

    @include ('layouts.partials.messages')

    <div class="row">

        <div>
            {{ Form::open(['files' => false, 'url' => '/password/change', 'method' => 'POST']) }}

            <section class="col-6" style="margin-bottom:0;">
                <h4>Change your password</h4>

                @if($user->changed_password == 0)
                    <div>
                        <p>Please update your temporary password to something more memorable to you. This is a security measure that ensures only you have access to your Portal account.</p>
                    </div>
                @else
                    <br>
                @endif

                <div class="formfield">
                    {{ Form::label('current_password', 'Your current password:', ['class' => 'required']) }}
                    {{ Form::password('current_password') }}
                </div>

                <div class="formfield">
                    {{ Form::label('new_password', 'Your new password:', ['class' => 'required']) }}
                    {{ Form::password('new_password') }}
                </div>

                <div class="formfield">
                    {{ Form::label('new_password_confirmation', 'Confirm your new password:', ['class' => 'required']) }}
                    {{ Form::password('new_password_confirmation') }}
                </div>

                <div>
                    {{ Form::hidden('your_temporary_password', $pass) }}
                    {{ Form::submit('Change', ['class' => 'primary']) }}<br>
                    <a href="/" class="secondary">Cancel</a><br><br>
                    <p style="font-style: italic">If you cancel this step and are yet to update your temporary supplied password, you put your account at risk (you will also be asked to change your password every time you login).</p>
                </div>
            </section>


            {{ Form::close() }}
        </div>
    </div>



@stop
