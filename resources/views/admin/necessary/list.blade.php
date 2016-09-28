@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span >DAFTAR KEBUTUHAN</span></li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<br /> 
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

        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <span class="caption-subject font-dark bold uppercase">DAFTAR KEBUTUHAN BANTUAN</span>
                <div class="actions">
                    <a class="btn btn-outline green btn-sm btn-circle" href="{{ url('/ctrl/necessary/0') }}">Tambah</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><center>#ID</center></th>
                                <th><center>Deskripsi Kebutuhan</center></th>
                                <th><center>Posko</center></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if ( ! $list->isEmpty())
                                @foreach ($list as $item)
                                <tr>
                                    <td width="10%"><center>{{ $item->id }}</center></td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td width="70">
                                        <a href="{{ URL::current() }}/{{ $item->id }}/delete" class="btn btn-danger btn-sm" data-toggle="confirmation" data-popout="true" data-placement="left" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                                            <span class="fa fa-times"></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="3">No item found.</td>
                            </tr>
                            @endif
            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        
        
    </div>
</div>
@endsection
