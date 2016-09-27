@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span>Pengguna</span></li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a data-toggle="modal" href="#new-item" class="btn blue btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Pengguna</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

<div id="new-item" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST">
            {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah User</h4>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group form-md-line-input{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" id="new-email" name="email" class="form-control" value="{{ old('email') }}">
                            <label for="new-email">Email *</label>
                            @if ($errors->has('email'))
                            <span class="help-block help-block-error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group form-md-line-input{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" id="new-name" name="name" class="form-control" value="{{ old('name') }}">
                            <label for="new-name">Nama Lengkap *</label>
                            @if ($errors->has('name'))
                            <span class="help-block help-block-error">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group form-md-line-input{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input type="text" id="new-phone" name="phone" class="form-control" value="{{ old('phone') }}">
                            <label for="new-phone">Nomor Telpon</label>
                            @if ($errors->has('phone'))
                            <span class="help-block help-block-error">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input{{ $errors->has('activated') ? ' has-error' : '' }}">
                                    <select id="new-activated" class="form-control edited" name="activated">
                                        <option value="1"{{ (old('activated') == 1) ? ' selected=selected' : '' }}>Iya</option>
                                        <option value="0"{{ (old('activated') == 0) ? ' selected=selected' : '' }}>Tidak</option>
                                    </select>
                                    <label for="new-activated">Aktifkan?</label>
                                    @if ($errors->has('activated'))
                                    <span class="help-block help-block-error">{{ $errors->first('activated') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input{{ $errors->has('is_admin') ? ' has-error' : '' }}">
                                    <select id="new-is_admin" class="form-control edited" name="is_admin">
                                        <option value="1"{{ (old('is_admin') == 1) ? ' selected=selected' : '' }}>Iya</option>
                                        <option value="0"{{ (old('is_admin') == 0) ? ' selected=selected' : '' }}>Tidak</option>
                                    </select>
                                    <label for="new-is_admin">Admin?</label>
                                    @if ($errors->has('is_admin'))
                                    <span class="help-block help-block-error">{{ $errors->first('is_admin') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input type="password" id="new-password" name="password" class="form-control" value="">
                                    <label for="new-password">Password</label>
                                    @if ($errors->has('password'))
                                    <span class="help-block help-block-error">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <input type="password" id="new-password_confirmation" name="password_confirmation" class="form-control" value="">
                                    <label for="new-password_confirmation">Konfirmasi Password</label>
                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block help-block-error">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Batal</button>
                    <button type="submit" class="btn green">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Admin?</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if ( ! $list->isEmpty())
                    @foreach ($list as $item)
                    <tr>
                        <td width="10">{{ $item->id }}</td>
                        <td><i class="icon-pencil"></i> <a href="#edit-{{ $item->id }}-modal" data-toggle="modal">{{ $item->name }}</a></td>
                        <td><a href="mailto:{{ $item->email }}" data-toggle="modal">{{ $item->email }}</a> - {{ $item->phone }}</td>
                        <td>{{ ($item->isInGroup('Administrators')) ? 'Iya' : 'Bukan' }}</td>
                        <td width="70">
                            <div id="edit-{{ $item->id }}-modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" method="POST" action="{{ URL::current() }}/{{ $item->id }}">
                                        {!! csrf_field() !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">Perbaharui User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form">
                                                    <div class="form-group form-md-line-input{{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <input type="email" id="new-{{ $item->id }}-email" name="email" class="form-control" value="{{ $item->email }}">
                                                        <label for="new-{{ $item->id }}-email">Email *</label>
                                                        @if ($errors->has('email'))
                                                        <span class="help-block help-block-error">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group form-md-line-input{{ $errors->has('name') ? ' has-error' : '' }}">
                                                        <input type="text" id="new-{{ $item->id }}-name" name="name" class="form-control" value="{{ $item->name }}">
                                                        <label for="new-{{ $item->id }}-name">Nama Lengkap *</label>
                                                        @if ($errors->has('name'))
                                                        <span class="help-block help-block-error">{{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group form-md-line-input{{ $errors->has('phone') ? ' has-error' : '' }}">
                                                        <input type="text" id="new-{{ $item->id }}-phone" name="phone" class="form-control" value="{{ $item->phone }}">
                                                        <label for="new-{{ $item->id }}-phone">Nomor Telpon</label>
                                                        @if ($errors->has('phone'))
                                                        <span class="help-block help-block-error">{{ $errors->first('phone') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input{{ $errors->has('activated') ? ' has-error' : '' }}">
                                                                <select id="new-{{ $item->id }}-activated" class="form-control edited" name="activated">
                                                                    <option value="1"{{ ($item->activated == 1) ? ' selected=selected' : '' }}>Iya</option>
                                                                    <option value="0"{{ ($item->activated == 0) ? ' selected=selected' : '' }}>Tidak</option>
                                                                </select>
                                                                <label for="new-{{ $item->id }}-activated">Aktifkan?</label>
                                                                @if ($errors->has('activated'))
                                                                <span class="help-block help-block-error">{{ $errors->first('activated') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input{{ $errors->has('is_admin') ? ' has-error' : '' }}">
                                                                <select id="new-{{ $item->id }}-is_admin" class="form-control edited" name="is_admin">
                                                                    <option value="1"{{ ($item->isInGroup('Administrators')) ? ' selected=selected' : '' }}>Iya</option>
                                                                    <option value="0"{{ (!$item->isInGroup('Administrators')) ? ' selected=selected' : '' }}>Tidak</option>
                                                                </select>
                                                                <label for="new-{{ $item->id }}-is_admin">Admin?</label>
                                                                @if ($errors->has('is_admin'))
                                                                <span class="help-block help-block-error">{{ $errors->first('is_admin') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input{{ $errors->has('password') ? ' has-error' : '' }}">
                                                                <input type="password" id="new-{{ $item->id }}-password" name="password" class="form-control" value="">
                                                                <label for="new-{{ $item->id }}-password">Ganti Password?</label>
                                                                @if ($errors->has('password'))
                                                                <span class="help-block help-block-error">{{ $errors->first('password') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                                <input type="password" id="new-{{ $item->id }}-password_confirmation" name="password_confirmation" class="form-control" value="">
                                                                <label for="new-{{ $item->id }}-password_confirmation">Konfirmasi Password</label>
                                                                @if ($errors->has('password_confirmation'))
                                                                <span class="help-block help-block-error">{{ $errors->first('password_confirmation') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Batal</button>
                                                <button type="submit" class="btn green">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if ( ! $item->isInGroup('Administrators'))
                            <a href="{{ URL::current() }}/{{ $item->id }}/delete" class="btn btn-danger btn-sm hidden-xs" data-toggle="confirmation" data-popout="true" data-placement="left" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                                <span class="fa fa-times"></span>
                            </a>
                            <a href="{{ URL::current() }}/{{ $item->id }}/delete" class="btn btn-danger btn-sm visible-xs-inline" data-toggle="confirmation" data-popout="true" data-placement="top" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                                <span class="fa fa-times"></span>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="4">No item found.</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-sm-6">&nbsp;</div>
            <div class="col-sm-6">
                <?php echo $list->render(); ?>
            </div>
        </div>
    </div>
</div>
@endsection
