@inject('str', 'App\Support\Str')
@extends('layouts.app')

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

@if (empty($data->id))
    @include('admin.area.form')
@else
    <ul class="nav nav-tabs">
        <li{{ ($tab == 'status') ? ' class=active' : '' }}>
            <a href="#area-status" data-toggle="tab" aria-expanded="true">Status</a>
        </li>
        <li{{ ($tab == 'info') ? ' class=active' : '' }}>
            <a href="#area-info" data-toggle="tab" aria-expanded="false">Perbaharui Informasi</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="area-status" class="tab-pane fade{{ ($tab == 'status') ? ' active in' : '' }}">
            @if ( ! is_null($status))
            @include('admin.area.status-form')
            @else
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-group pull-right">
                        <a href="{{ url('/ctrl/areas') }}" class="btn dark">
                            <i class="icon-logout"></i> Kembali
                        </a>
                        <a data-toggle="modal" href="{{ sprintf(url('/ctrl/areas/%d/statuses'), $data->id) }}" class="btn blue">
                            <i class="fa fa-plus"></i> Tambah Status
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal + Jam</th>
                            <th>Skala</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ( ! $statuses->isEmpty())
                        @foreach ($statuses as $item)
                        <tr>
                            <td>
                                <a href="{{ sprintf(url('/ctrl/areas/%d/statuses/%d'), $item->area_id, $item->id) }}" class="btn green-meadow btn-sm">
                                    <i class="icon-pencil"></i> Perbaharui
                                </a>
                                <a href="{{ sprintf(url('/ctrl/areas/%d/statuses/%d'), $item->area_id, $item->id) }}">{{ $item->datetime }}</a>
                            </td>
                            <td width="50">{{ $item->scale }}</td>
                            <td>{{ $str->words($item->description, 10, '...') }}</td>
                            <td width="70">
                                <a href="{{ URL::current() }}/statuses/{{ $item->id }}/delete" class="btn btn-danger btn-sm" data-toggle="confirmation" data-popout="true" data-placement="left" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                                    <span class="icon-trash"></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="4">Belum ada status terbaru, silahkan tambahkan jika di perlukan.</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-sm-6">&nbsp;</div>
                <div class="col-sm-6">
                    <?php echo $statuses->render(); ?>
                </div>
            </div>
            @endif
        </div>
        <div id="area-info" class="tab-pane fade{{ ($tab == 'info') ? ' active in' : '' }}">
            @include('admin.area.form')
        </div>
    </div>
@endif
@endsection
