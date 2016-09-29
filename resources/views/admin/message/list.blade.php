@inject('str', 'App\Support\Str')
@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span>Pesan</span></li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Daftar Pesan</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

<div class="row">
    <div class="col-md-12">
        <div class="form">
            <form role="form" method="GET">
                <div class="form-body">
                    <div class="form-group form-md-line-input has-info form-md-floating-label">
                        <div class="input-group">
                            <div class="input-group-control">
                                <input type="text" id="search" name="search" class="form-control" value="{{ $filter['search'] }}">
                                <label for="search">Pencarian</label>
                            </div>
                            <span class="input-group-btn btn-right">
                                <button type="submit" class="btn blue-madison" type="button">Cari</button>
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
                        <th>Tanggal</th>
                        <th>Kontak</th>
                        <th>Pesan</th>
                    </tr>
                </thead>
                <tbody>
                @if ( ! $list->isEmpty())
                    @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="#view-{{ $item->id }}-modal" data-toggle="modal" class="btn green-meadow btn-sm">
                                <i class="icon-eye"></i> Buka pesan
                            </a>
                            {{ $item->sender }} | {{ $item->phone }} | {{ $item->email }}
                        </td>
                        <td>
                            {{ $str->words($item->content, 10, '...') }}

                            <div id="view-{{ $item->id }}-modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">{{ $item->sender }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="ticket-cust">
                                                        <span class="bold">Kontak:</span> {{ $item->phone }} | {{ $item->email }}</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="ticket-date"><span class="bold">Pada:</span> {{ $item->created_at }} </div>
                                                </div>
                                            </div>
                                            <div class="row margin-top-10">
                                                <div class="col-xs-12">
                                                    <div class="ticket-msg">
                                                        {!! nl2br($item->content) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
