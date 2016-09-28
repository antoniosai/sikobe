@inject('str', 'App\Support\Str')
@extends('layouts.app')

@section('content')

@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<form role="form" method="POST" enctype="multipart/form-data" action="{{ $data->id ? url('/ctrl/posko/'.$data->id) : url('/ctrl/posko') }}" class="form">
@if($data->id)
{{ method_field('PUT') }}
@endif
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/ctrl/areas') }}"><span>Posko</span></a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{ $data->id ? 'Perbarui' : 'Tambah' }}</span>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ url('/ctrl/posko') }}" class="btn dark">
                <i class="icon-logout"></i> Kembali
            </a>
            <button type="submit"class="btn green-meadow">
                <i class="fa fa-save"></i> {{ $data->id ? 'Perbarui' : 'Simpan' }}
            </button>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Tambah Posko</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
  @include('admin.posko.form', ['data'=>$data])
</form>
@stop
