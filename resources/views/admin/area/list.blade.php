@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span>Area Terdampak</span></li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a data-toggle="modal" href="{{ url('/ctrl/areas/0') }}" class="btn blue btn-sm">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Area Terdampak</h3>
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

        <div class="form">
            <form role="form" method="GET">
                <div class="form-body">
                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-group">
                            <div class="input-group-control">
                                <select id="filter-district" name="district" class="form-control">
                                    <option value="all"{{ (empty($filter['district'])) ? ' selected=selected' : '' }}>Semua</option>
                                    @if ( ! $districts->isEmpty())
                                    @foreach ($districts as $item)
                                    <option value="{{ $item->id }}"{{ ($item->id == $filter['district']) ? ' selected=selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="filter-district">Kecamatan</label>
                            </div>
                            <div class="input-group-control">
                                <select id="filter-village" name="village" class="form-control">
                                    <option value="all"{{ (empty($filter['village'])) ? ' selected=selected' : '' }}>Semua</option>
                                    @if ( ! $villages->isEmpty())
                                    @foreach ($villages as $item)
                                    <option value="{{ $item->id }}"{{ ($item->id == $filter['village']) ? ' selected=selected' : '' }}>
                                        {{ $item->name }} | {{ $item->district }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="filter-village">Kelurahan / Desa</label>
                            </div>
                            <div class="input-group-control">
                                <input type="text" id="title" name="title" class="form-control" value="{{ $filter['title'] }}">
                                <label for="title">Nama</label>
                            </div>
                            <span class="input-group-btn btn-right">
                                <button type="submit" class="btn blue-madison" type="button">Filter</button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if ( ! $list->isEmpty())
                    @foreach ($list as $item)
                    <tr>
                        <td>
                            <a href="{{ sprintf(url('/ctrl/areas/%d'), $item->id) }}" class="btn green-meadow btn-sm">
                                <i class="icon-pencil"></i> Perbaharui
                            </a>
                            <a href="{{ sprintf(url('/ctrl/areas/%d/statuses'), $item->id) }}" class="btn red-mint btn-sm">
                                <i class="icon-feed"></i> Tambah status
                            </a>
                            <a href="{{ sprintf(url('/ctrl/areas/%d'), $item->id) }}">{{ $item->title }}</a>
                        </td>
                        <td>{{ $item->address }}</td>
                        <td width="70">
                            <a href="{{ URL::current() }}/{{ $item->id }}/delete" class="btn btn-danger btn-sm" data-toggle="confirmation" data-popout="true" data-placement="left" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                                <span class="icon-trash"></span>
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

        <div class="row">
            <div class="col-sm-6">&nbsp;</div>
            <div class="col-sm-6">
                <?php echo $list->appends($filter)->render(); ?>
            </div>
        </div>
    </div>
</div>
@endsection
