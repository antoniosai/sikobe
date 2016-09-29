@extends('layouts.app-front')

@section('content')
<div class="c-content-contact-1 c-opt-1">
    <div class="row">
        <div class="col-md-6">
            <div class="row" data-auto-height=".c-height">
                <div class="col-md-6">
                    <div id="map_canvas" class="hidden-xs" style="height: 420px;"></div>
                </div>
                <div class="col-md-6">
                    <div class="c-body" style="margin: 0px !important;">
                        <div class="c-section">
                            <h3>Posko Pusat</h3>
                        </div>
                        <div class="c-section">
                            <div class="c-content-label uppercase bg-blue">Alamat</div>
                            <p>Jl. Mayor Syamsu No. 1,
                                <br/>Jayaraga - Tarogong Kidul,
                                <br/>Garut - Jawa Barat</p>
                        </div>
                        <div class="c-section">
                            <div class="c-content-label uppercase bg-blue">Kontak</div>
                            <p>
                                <strong>T</strong> +62-262 123 0000
                                <br/>
                                <strong>F</strong> +62-262 123 8888</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="c-content-feedback-1 c-option-1">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="c-contact">
                            <div class="c-content-title-1">
                                <h3 class="uppercase">Hubungi kami</h3>
                                <div class="c-line-left bg-dark"></div>
                                <p class="c-font-lowercase">Silahkan sampaikan masalah atau saran yang Anda lihat penting untuk penanganan bencana ini. Kami akan menghubungi Anda kembali melalui No Telpon atau Email yang Anda sertakan di bawah.</p>
                                @if(Session::has('success'))
                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                                @endif
                                @if(Session::has('error'))
                                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                @endif
                            </div>
                            <form method="POST">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has($fields['sender']) ? ' has-error' : '' }}">
                                    <input type="text" name="{{ $fields['sender'] }}" placeholder="Nama Lengkap" value="{{ old($fields['sender']) }}" class="form-control input-md" />
                                    @if ($errors->has($fields['sender']))
                                    <span class="help-block help-block-error">{{ $errors->first($fields['sender']) }}</span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has($fields['phone']) ? ' has-error' : '' }}">
                                    <input type="text" name="{{ $fields['phone'] }}" placeholder="No Telpon" value="{{ old($fields['phone']) }}" class="form-control input-md" />
                                    @if ($errors->has($fields['phone']))
                                    <span class="help-block help-block-error">{{ $errors->first($fields['phone']) }}</span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has($fields['email']) ? ' has-error' : '' }}">
                                    <input type="text" name="{{ $fields['email'] }}" placeholder="Email (tidak wajib)" value="{{ old($fields['email']) }}" class="form-control input-md" />
                                    @if ($errors->has($fields['email']))
                                    <span class="help-block help-block-error">{{ $errors->first($fields['email']) }}</span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has($fields['content']) ? ' has-error' : '' }}">
                                    <textarea rows="8" name="{{ $fields['content'] }}" placeholder="Tulis pesan di sini ..." class="form-control input-md">{{ old($fields['content']) }}</textarea>
                                    @if ($errors->has($fields['content']))
                                    <span class="help-block help-block-error">{{ $errors->first($fields['content']) }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn grey">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
