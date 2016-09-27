@if (empty($status->id))
<form role="form" method="POST" enctype="multipart/form-data" action="{{ sprintf(url('/ctrl/areas/%d/statuses'), $data->id) }}" class="form">
@else
<form role="form" method="POST" enctype="multipart/form-data" action="{{ sprintf(url('/ctrl/areas/%d/statuses/%d'), $status->area_id, $status->id) }}" class="form">
@endif
    {!! csrf_field() !!}

    <div class="row margin-top-20">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-md-line-input{{ $errors->has('description') ? ' has-error' : '' }}">
                        <textarea id="description" name="description" class="form-control" rows="20" placeholder="Input keterangan lengkap di sini">{{ old('description', $status->description) }}</textarea>
                        <label for="description">Keterangan Status terakhir</label>
                        @if ($errors->has('description'))
                        <span class="help-block help-block-error">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-md-line-input{{ $errors->has('scale') ? ' has-error' : '' }}">
                        <select id="scale" name="scale" class="form-control">
                            <option value="1"{{ (1 == $status->scale) ? ' selected=selected' : '' }}>
                                1 | Satu
                            </option>
                            <option value="2"{{ (2 == $status->scale) ? ' selected=selected' : '' }}>
                                2 | Dua
                            </option>
                            <option value="3"{{ (3 == $status->scale) ? ' selected=selected' : '' }}>
                                3 | Tiga
                            </option>
                            <option value="4"{{ (4 == $status->scale) ? ' selected=selected' : '' }}>
                                4 | Empat
                            </option>
                            <option value="5"{{ (5 == $status->scale) ? ' selected=selected' : '' }}>
                                5 | Lima
                            </option>
                        </select>
                        <label for="scale">Skala dampak terakhir</label>
                        @if ($errors->has('scale'))
                        <span class="help-block help-block-error">{{ $errors->first('scale') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('datetime') ? ' has-error' : '' }}">
                        <input type="text" id="datetime" name="datetime" class="form-control" placeholder="{{ date('Y-m-d H:i') }}" value="{{ old('datetime', $status->datetime) }}">
                        <label for="datetime">Tanggal + Jam</label>
                        @if ($errors->has('datetime'))
                        <span class="help-block help-block-error">{{ $errors->first('datetime') }}</span>
                        @endif
                    </div>
                    <div class="upload-container mt-element-list margin-bottom-10">
                        <div class="mt-list-container list-todo">
                            <ul>
                                <li class="mt-list-item no-padding">
                                    <div class="list-todo-item grey no-margin">
                                        <a class="list-toggle-container font-white" data-toggle="collapse" aria-expanded="true">
                                            <div class="list-toggle done uppercase">
                                                <div class="list-toggle-title bold">Unggah foto - foto</div>
                                            </div>
                                        </a>
                                        <div class="task-list panel-collapse collapse in" aria-expanded="true">
                                            <ul id="upload-container">
                                                <li id="upload-row-example" class="task-list-item" style="display:none;">
                                                    <div class="task-status">
                                                        <a class="pending del-file" href="javascript:;">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="task-content padding-l-0">
                                                        <input type="file" name="files[]" accept=".png,.PNG,.jpg,.JPG,.jpeg,.JPEG,.gif,.GIF" class="form-control" />
                                                    </div>
                                                </li>
                                                @if ( ! $status->files->isEmpty())
                                                @foreach ($status->files as $file)
                                                <li class="task-list-item">
                                                    <div class="task-icon">
                                                        <a href="{{ sprintf(url('/storage/%s'), $file->filename) }}" target="_blank">
                                                            <img src="{{ sprintf(url('/storage/%s'), $file->filename) }}" />
                                                        </a>
                                                    </div>
                                                    <div class="task-status">
                                                        <a class="pending del-file" href="javascript:;">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="task-content padding-l-0">
                                                        <input type="hidden" name="keep-files[]" value="{{ $file->id }}">
                                                        <a href="{{ sprintf(url('/storage/%s'), $file->filename) }}" target="_blank"><i class="icon-cloud-download"></i> {{ $file->title }}</a>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @endif
                                                <li class="task-list-item">
                                                    <div class="task-status">
                                                        <a class="pending del-file" href="javascript:;">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="task-content padding-l-0">
                                                        <input type="file" name="files[]" accept=".png,.PNG,.jpg,.JPG,.jpeg,.JPEG,.gif,.GIF" class="form-control" />
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="task-footer bg-grey">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        Total Maksimal: {{ humanFilesize(fileUploadMaxSize()) }}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <a class="task-add add-file tooltips" href="javascript:;" data-container="body" data-placement="top" data-original-title="Tambah berkas">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions fluid margin-t-20">
        <div class="row padding-10">
            <div class="col-md-7 font-grey-cascade">
                @if ( ! empty($status->id))
                <i class="icon-user"></i> <small>dibuat oleh</small> #{{ $status->author_id }}, <i class="icon-calendar"></i> {{ $status->created_at }}
                @endif
            </div>
            <div class="col-md-5">
                <div class="btn-group pull-right">
                    <a href="{{ sprintf(url('/ctrl/areas/%d'), $data->id) }}" class="btn dark">
                        <i class="icon-logout"></i> Kembali
                    </a>
                    @if ( ! empty($status->id))
                        <a href="{{ sprintf(url('/ctrl/areas/%d/delete'), $status->id) }}" class="btn btn-danger" data-toggle="confirmation" data-popout="true" data-placement="top" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
                            <i class="fa fa-close"></i> Hapus
                        </a>
                    @endif
                    <button type="submit" name="save" value="1" class="btn green-meadow">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
