@extends('layouts.app-auth')

@section('content')
<div class="login-content">
    <h1>SIKOBE</h1>
    <form class="login-form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-xs-6{{ $errors->has('email') ? ' has-error' : '' }}">
                <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('email') ? ' has-error' : '' }}" type="text" value="{{ old('email') }}" autocomplete="off" placeholder="Email" name="email" required/>
                @if ($errors->has('email'))
                <span class="help-block help-block-error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="col-xs-6{{ $errors->has('password') ? ' has-error' : '' }}">
                <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="Password" name="password" required/>
                @if ($errors->has('password'))
                <span class="help-block help-block-error">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-8 text-right">
                <button class="btn blue" type="submit">Sign In</button>
            </div>
        </div>
    </form>
</div>
@endsection
