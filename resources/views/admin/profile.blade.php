@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span>Hi {{ $user->display_name }}</span></li>
    </ul>
</div>

<div class="profile padding-t-20">
    @if(Session::has('success'))
    <div class="alert alert-success margin-top-10">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger margin-top-10">{{ Session::get('error') }}</div>
    @endif

    <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#info-pane" data-toggle="tab" aria-expanded="false"> Informasi </a>
            </li>
            <li class="">
                <a href="#password-pane" data-toggle="tab" aria-expanded="false"> Ganti Password </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="info-pane" class="tab-pane active">
                <form method="POST" role="form" class="form">
                    {!! csrf_field() !!}
                    <div class="form-group form-md-line-input{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" />
                        <label for="email">Email *</label>
                        @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" id="name" name="name" value="{{ $user->display_name }}" class="form-control" />
                        <label for="name">Nama Lengkap *</label>
                        @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="form-control" />
                        <label for="phone">Nomor Telpon *</label>
                        @if ($errors->has('phone'))
                        <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="margiv-top-10">
                        <button type="submit" class="btn green">Simpan</button>
                    </div>
                </form>
            </div>
            <div id="password-pane" class="tab-pane">
                <form method="POST" role="form" class="form">
                    {!! csrf_field() !!}
                    <div class="form-group form-md-line-input{{ $errors->has('current_password') ? ' has-error' : '' }}">
                        <input type="password" id="current_password" name="current_password" value="" class="form-control" />
                        <label for="email">Password Sekarang *</label>
                        @if ($errors->has('current_password'))
                        <span class="help-block">{{ $errors->first('current_password') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" id="password" name="password" value="" class="form-control" />
                        <label for="email">Password Baru *</label>
                        @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control" />
                        <label for="email">Konfirmasi Password Baru *</label>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                    <div class="margiv-top-10">
                        <button type="submit" name="update_password" value="1" class="btn green">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
