@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><span>Information</span></li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="#addModals" data-toggle="modal" class="btn blue btn-sm">
                <i class="fa fa-plus"></i> Tambah Information
            </a>
        </div>
    </div>
</div>

<!-- Start Modal-->

    <div id="addModals" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="POST" action="{{ URL::current() }}">
                  <input type="hidden" name="identifier" value="information">
                {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Tambah Informasi</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form">
                            <div class="form-group form-md-line-input{{ $errors->has('title') ? ' has-error' : '' }}">
                                <input type="title" id="new-title" name="title" class="form-control" value="">
                                <label for="new-title">Judul informasi</label>
                                @if ($errors->has('title'))
                                <span class="help-block help-block-error">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group form-md-line-input{{ $errors->has('description') ? ' has-error' : '' }}">
                                <textarea name="description" id="new-description" rows="8" cols="40" class="form-control"></textarea>
                                <label for="new-description">Deskripsi *</label>
                                @if ($errors->has('description'))
                                <span class="help-block help-block-error">{{ $errors->first('description') }}</span>
                                @endif
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
<!-- End Modal -->

<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Informasi</h3>
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


        <!-- Start of Content -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Posted by</th>
                        <th>Tanggal dibuat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                @if ( ! $list->isEmpty())
                    @foreach ($list as $item)
                    <tr>
                        <td width="10">{{ $no++ }}</td>
                        <td>{{ $item->title }}</td>
                        <td width=250>{{ substr($item->description,0, 120) }} <a href="{{ sprintf(url('/ctrl/information/%d'), $item->id) }}">...Readmore</a></td>
                        <td>{{ $item->author_id }}</td>
                        <td width="200">{{ $item->created_at }}</td>
                        <td width="160">
                          <a href="#view-{{ $item->id }}-modal" data-toggle="modal" class="btn blue btn-sm"><i class="icon-pencil"></i> Edit</a>
                            <a href="{{ URL::current() }}/{{ $item->id }}/delete" class="btn btn-danger btn-sm" data-toggle="confirmation" data-popout="true" data-placement="left" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                                <span class="fa fa-times"></span>
                            </a>
                        </td>
                    </tr>
                    <!-- Start Modal -->
                    <div id="view-{{ $item->id }}-modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <form role="form" method="POST" action="{{ URL::current() }}/update">
                                <input type="hidden" name="identifier" value="information">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                              {!! csrf_field() !!}
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                      <h4 class="modal-title">Tambah Informasi</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form">
                                          <div class="form-group form-md-line-input{{ $errors->has('title') ? ' has-error' : '' }}">
                                              <input type="title" id="new-title" name="title" class="form-control" value="{{ $item->title}}">
                                              <label for="new-title">Judul informasi</label>
                                          </div>
                                          <div class="form-group form-md-line-input{{ $errors->has('description') ? ' has-error' : '' }}">
                                              <textarea name="description" id="new-description" rows="8" cols="40" class="form-control">{{ $item->description }}</textarea>
                                              <label for="new-description">Deskripsi *</label>
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
                    <!-- End Modal -->
                    @endforeach
                @else
                <tr>
                    <td colspan="3">No item found.</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
        <!-- End of Content -->

        <div class="row">
            <div class="col-sm-6">&nbsp;</div>
            <div class="col-sm-6">
                <?php echo $list->render(); ?>
            </div>
        </div>
    </div>
</div>
@endsection
