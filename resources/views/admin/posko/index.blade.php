@inject('str', 'App\Support\Str')
@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span>Posko</span></li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a data-toggle="modal" href="{{ url('/ctrl/posko/create') }}" class="btn blue btn-sm">
                <i class="fa fa-plus"></i> Tambah Posko
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Posko</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

<div class="row">
  <div class="col-md-12">
    @if(Session::has('success'))
    <div class="alert alert-success margin-top-10">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger margin-top-10">{{ Session::get('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nama Posko</th>
                    <th>Area</th>
                    <th>Alamat</th>
                    <th>Penganggung Jawab</th>
                    <th>Telepon</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if ( ! $lists->isEmpty())
                @foreach ($lists as $list)
                <tr>
                    <td>{{ $list->title }}</td>
                    <td>{{ $list->area->title }}</td>
                    <td>{!! $list->address.'<br /> '.$list->village->name.', '.$list->village->district->name.', '.$list->village->district->regency->name.', '.$list->village->district->regency->province->name  !!}</td>
                    <td>{{ $list->leader }}</td>
                    <td>{{ $list->phone }}</td>
                    <td width="70">
                      <a class="btn green-meadow btn-sm" href="{{ url('ctrl/posko/'.$list->id.'/edit') }}"><span class="icon-pencil"></span></a>
                      <form action="{{ url('ctrl/posko/'.$list->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="confirmation" data-popout="true" data-placement="left" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                            <span class="icon-trash"></span>
                        </button>
                      </form>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="6">Posko Belum Tersedia</td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
  </div>
</div>
@stop
