{{ csrf_field() }}
<div class="row margin-top-20">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group form-md-line-input{{ $errors->has('area_id') ? ' has-error' : '' }}">
            <select id="area_id" name="area_id" class="form-control">
                @if ( ! $areas->isEmpty())
                @foreach ($areas as $item)
                <option value="{{ $item->id }}"{{ ($item->id == $data->area_id) ? ' selected=selected' : '' }}">
                  {{ $item->title }}
                </option>
                @endforeach
                @endif
            </select>
            <label for="village">Area</label>
            @if ($errors->has('areas_id'))
            <span class="help-block help-block-error">{{ $errors->first('areas_id') }}</span>
            @endif
        </div>
        <div class="form-group form-md-line-input{{ $errors->has('title') ? ' has-error' : '' }}">
            <input type="text" id="title" name="title" class="form-control" placeholder="Input nama posko di sini" value="{{ old('title', $data->title) }}">
            <label for="title">Nama Posko</label>
            @if ($errors->has('title'))
            <span class="help-block help-block-error">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group form-md-line-input{{ $errors->has('leader') ? ' has-error' : '' }}">
            <input type="text" id="leader" name="leader" class="form-control" placeholder="Input nama posko di sini" value="{{ old('leader', $data->leader) }}">
            <label for="title">Pimpinan Posko</label>
            @if ($errors->has('leader'))
            <span class="help-block help-block-error">{{ $errors->first('leader') }}</span>
            @endif
        </div>
        <div class="form-group form-md-line-input{{ $errors->has('phone') ? ' has-error' : '' }}">
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Input nomoer telepon pimpinan posko di sini" value="{{ old('phone', $data->phone) }}">
            <label for="title">Telepon Pimpinan Posko</label>
            @if ($errors->has('phone'))
            <span class="help-block help-block-error">{{ $errors->first('phone') }}</span>
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
                                  @if ( ! $data->files->isEmpty())
                                  @foreach ($data->files as $file)
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
      <div class="col-md-6">
        <div class="form-group form-md-line-input{{ $errors->has('address') ? ' has-error' : '' }}">
            <input type="text" id="address" name="address" class="form-control" placeholder="Input alamat posko di sini" value="{{ old('address', $data->address) }}">
            <label for="title">Alamat Posko</label>
            @if ($errors->has('address'))
            <span class="help-block help-block-error">{{ $errors->first('address') }}</span>
            @endif
        </div>
        <div class="form-group form-md-line-input{{ $errors->has('village_id') ? ' has-error' : '' }}">
          <select id="village" name="village_id" class="form-control">
            @if ( ! $villages->isEmpty())
            @foreach ($villages as $item)
            <option value="{{ $item->id }}"{{ ($item->id == $data->village_id) ? ' selected=selected' : '' }} data-village="{{ $item->name }}" data-district="{{ $item->district }}">
              {{ $item->name }} | {{ $item->district }}
            </option>
            @endforeach
            @endif
          </select>
          <label for="village">Kelurahan / Desa | Kecamatan</label>
          @if ($errors->has('village_id'))
          <span class="help-block help-block-error">{{ $errors->first('village_id') }}</span>
          @endif
        </div>
        <div class="row">
            <div class="col-md-12">
              <label>Geser Marker Ke Posisi Posko</label>
              <div style="width:100%;height:250px;background-color:#dcdcdc;margin-bottom:20px" id="map_canvas"></div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input{{ $errors->has('latitude') ? ' has-error' : '' }}">
                    <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Input koordinat di sini" value="{{ old('latitude', $data->latitude) }}">
                    <label for="latitude">Latitude</label>
                    @if ($errors->has('latitude'))
                    <span class="help-block help-block-error">{{ $errors->first('latitude') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input{{ $errors->has('longitude') ? ' has-error' : '' }}">
                    <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Input koordinat di sini" value="{{ old('longitude', $data->longitude) }}">
                    <label for="longitude">Longitude</label>
                    @if ($errors->has('longitude'))
                    <span class="help-block help-block-error">{{ $errors->first('longitude') }}</span>
                    @endif
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="form-actions fluid margin-t-20">
    <div class="row padding-10">
      <div class="col-md-7 font-grey-cascade">
          @if ( ! empty($data->id))
          <i class="icon-user"></i> <small>dibuat oleh</small> #{{ $data->author_id }}, <i class="icon-calendar"></i> {{ $data->created_at }}
          @endif
      </div>
        <div class="col-md-5">
            <div class="btn-group pull-right">
                <a href="{{ url('/ctrl/posko') }}" class="btn dark">
                    <i class="icon-logout"></i> Kembali
                </a>
                <button type="submit" name="save" value="1" class="btn green-meadow">
                    <i class="fa fa-save"></i> {{ $data->id ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </div>
    </div>
</div>
