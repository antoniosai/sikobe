@extends('layouts.app')

@section('content')
@if (empty($data->id))
<form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/ctrl/areas') }}" class="form">
@else
<form role="form" method="POST" enctype="multipart/form-data" action="{{ sprintf(url('/ctrl/areas/%d'), $data->id) }}" class="form">
@endif
    {!! csrf_field() !!}

    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/ctrl/necessary') }}"><span>Daftar Kebutuhan</span></a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ (empty($data->id)) ? 'Tambah' : $data->title }}</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div class="btn-group pull-right">
                @if ( ! empty($data->id))
                    <a href="{{ sprintf(url('/ctrl/areas/%d/delete'), $data->id) }}" class="btn btn-danger" data-toggle="confirmation" data-popout="true" data-placement="top" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!"><i class="fa fa-close"></i> Hapus</a>
                @endif
                <button type="submit" name="save" value="1" class="btn green-meadow">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title">{{ (empty($data->id)) ? 'Tambah Data Kebutuhan ' : $data->title }}</h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <div class="row margin-top-20">
        <div class="col-md-12">
            @if(Session::has('success'))
            <div class="alert alert-success margin-top-10">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger margin-top-10">{{ Session::get('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-md-line-input{{ $errors->has('title') ? ' has-error' : '' }}">
                        <select id="area_id" name="area_id" class="form-control">
                            @if ( ! $areas->isEmpty())
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ ($area->id == $data->area_id) ? ' selected=selected' : '' }} >
                                {{ $area->title }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <label for="areas">Area Dampak</label>
                        @if ($errors->has('areas'))
                        <span class="help-block help-block-error">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('title') ? ' has-error' : '' }}">
                        <select id="posko_id" name="posko_id" class="form-control">
                           <option value="0">POSKO 1</option>
                        </select>
                        <label for="posko_id"></label>
                       
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('description') ? ' has-error' : '' }}">
                        <textarea id="description" name="description" class="form-control" rows="5" placeholder="Input keterangan lengkap di sini">{{ old('description', $data->description) }}</textarea>
                        <label for="description">Keterangan</label>
                        
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('status') ? ' has-error' : '' }}">
                        <select id="status" name="status" class="form-control">
                            <option value="in_progress"{{ ('in_progress' == $data->status) ? ' selected=selected' : '' }}>
                                Sedang di proses
                            </option>
                            <option value="completed"{{ ('completed' == $data->status) ? ' selected=selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                        <label for="village">Status</label>
                        @if ($errors->has('status'))
                        <span class="help-block help-block-error">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    
                </div>
                
            </div>
        </div>
    </div>


</form>
@endsection
