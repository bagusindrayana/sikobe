@if (empty($data->id))
<form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/ctrl/areas') }}" class="form">
@else
<form role="form" method="POST" enctype="multipart/form-data" action="{{ sprintf(url('/ctrl/areas/%d'), $data->id) }}" class="form">
@endif
    {!! csrf_field() !!}

    @if (empty($data->id))
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/ctrl/areas') }}"><span>Area Terdampak</span></a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Tambah</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div class="btn-group pull-right">
                <a href="{{ url('/ctrl/areas') }}" class="btn dark">
                    <i class="icon-logout"></i> Kembali
                </a>
                <button type="submit" name="save" value="1" class="btn green-meadow">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title">Tambah Area Terdampak</h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    @endif

    <div class="row margin-top-20">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-md-line-input{{ $errors->has('title') ? ' has-error' : '' }}">
                        <input type="text" id="title" name="title" class="form-control" placeholder="Input judul di sini" value="{{ old('title', $data->title) }}">
                        <label for="title">Judul</label>
                        @if ($errors->has('title'))
                        <span class="help-block help-block-error">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('description') ? ' has-error' : '' }}">
                        <textarea id="description" name="description" class="form-control" rows="20" placeholder="Input keterangan lengkap di sini">{{ old('description', $data->description) }}</textarea>
                        <label for="description">Keterangan</label>
                        @if ($errors->has('description'))
                        <span class="help-block help-block-error">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('status') ? ' has-error' : '' }}">
                        <select id="status" name="status" class="form-control">
                            <option value="in_progress"{{ ('in_progress' == $data->status) ? ' selected=selected' : '' }}>
                                Sedang di proses
                            </option>
                            <option value="completed"{{ ('completed' == $data->status) ? ' selected=selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                        <label for="village">Status</label>
                        @if ($errors->has('status'))
                        <span class="help-block help-block-error">{{ $errors->first('status') }}</span>
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
                        <input type="text" id="address" name="address" class="form-control" placeholder="Input alamat di sini" value="{{ old('address', $data->address) }}">
                        <label for="address">Alamat</label>
                        @if ($errors->has('address'))
                        <span class="help-block help-block-error">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-md-line-input{{ $errors->has('province') ? ' has-error' : '' }}">
                        <select id="province" name="province" class="form-control">
                            
                        </select>
                        <label for="province">Provincsi</label>
                        @if ($errors->has('province'))
                        <span class="help-block help-block-error">{{ $errors->first('village') }}</span>
                        @endif
                    </div>

                    <div class="form-group form-md-line-input{{ $errors->has('regency') ? ' has-error' : '' }}">
                        <select id="regency" name="regency" class="form-control">
                            
                        </select>
                        <label for="regency">Kabupaten/Kota</label>
                        @if ($errors->has('regency'))
                        <span class="help-block help-block-error">{{ $errors->first('village') }}</span>
                        @endif
                    </div>

                    <div class="form-group form-md-line-input{{ $errors->has('district') ? ' has-error' : '' }}">
                        <select id="district" name="district" class="form-control">
                            
                        </select>
                        <label for="district">Kecamatan</label>
                        @if ($errors->has('district'))
                        <span class="help-block help-block-error">{{ $errors->first('village') }}</span>
                        @endif
                    </div>

                    <div class="form-group form-md-line-input{{ $errors->has('village') ? ' has-error' : '' }}">
                        <select id="village" name="village" class="form-control">
                            
                        </select>
                        <label for="village">Kelurahan / Desa | Kecamatan</label>
                        @if ($errors->has('village'))
                        <span class="help-block help-block-error">{{ $errors->first('village') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <label>Geser Marker Ke Posisi Area</label>
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
                    <a href="{{ url('/ctrl/areas') }}" class="btn dark">
                        <i class="icon-logout"></i> Kembali
                    </a>
                    @if ( ! empty($data->id))
                        <a href="{{ sprintf(url('/ctrl/areas/%d/delete'), $data->id) }}" class="btn btn-danger" data-toggle="confirmation" data-popout="true" data-placement="top" data-btn-ok-label="Lanjutkan" data-btn-cancel-label="Jangan!">
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


@push('styles')
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.10.1/mapbox-gl.css' rel='stylesheet' />
    <link
      rel="stylesheet"
      href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css"
      type="text/css">
@endpush

@push('scripts')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
    <script>
        $(document).ready(function(){
            let province_id = '{{ @$data->province_id ?? 0 }}';
            let regency_id = '{{ @$data->regency_id ?? 0 }}';
            let district_id = '{{ @$data->district_id ?? 0 }}';
            $.ajax({
                url:'{{ url("api/territory") }}',
                type:'GET',
                success:function(data){
                    let opts = ``;

                    for (let i = 0; i < data[0].length; i++) {
                        const d = data[0][i];
                        let selected = '';
                        if(d.id == '{{ @$data->province_id ?? 0 }}'){
                            selected = 'selected';
                        }
                        opts += `<option value="${d.id}" ${selected}>${d.name}</option>`
                        
                    }


                    $("#province").html(opts);
                    province_id = $("#province").val();
                    getRegency();
                }
            });

            function getRegency(){
                $.ajax({
                    url:'{{ url("api/territory") }}/'+province_id,
                    type:'GET',
                    success:function(data){
                        let opts = ``;

                        for (let i = 0; i < data[0].length; i++) {
                            const d = data[0][i];
                            let selected = '';
                            if(d.id == '{{ @$data->regency_id ?? 0 }}'){
                                selected = 'selected';
                            }
                            opts += `<option value="${d.id}" ${selected}>${d.name}</option>`
                            
                        }

                        $("#regency").html(opts);
                        regency_id = $("#regency").val();
                        getDistrict();
                    }
                });
            }

            function getDistrict(){
                $.ajax({
                    url:'{{ url("api/territory") }}/'+province_id+'/'+regency_id,
                    type:'GET',
                    success:function(data){
                        let opts = ``;

                        for (let i = 0; i < data[0].length; i++) {
                            const d = data[0][i];
                            let selected = '';
                            if(d.id == '{{ @$data->district_id ?? 0 }}'){
                                selected = 'selected';
                            }
                            opts += `<option value="${d.id}" ${selected}>${d.name}</option>`
                            
                        }

                        $("#district").html(opts);
                        district_id = $("#district").val();
                        getVillage();
                    }
                });
            }

            function  getVillage(){
                $.ajax({
                    url:'{{ url("api/territory") }}/'+province_id+'/'+regency_id+'/'+district_id,
                    type:'GET',
                    success:function(data){
                        let opts = ``;

                        for (let i = 0; i < data[0].length; i++) {
                            const d = data[0][i];
                            let selected = '';
                            if(d.id == '{{ @$data->village_id ?? 0 }}'){
                                selected = 'selected';
                            }
                            opts += `<option value="${d.id}" ${selected}>${d.name}</option>`
                            
                        }

                        $("#village").html(opts);
                    }
                });
            }

            $(document).on('change','#province',function(){
                province_id = $(this).val();
                if(province_id != "semua"){
                    getRegency();
                }
            });



            $(document).on('change','#regency',function(){
                regency_id = $(this).val();
                if(regency_id != "semua"){
                    getDistrict();
                }
            });


            $(document).on('change','#district',function(){
                district_id = $(this).val();
                if(district_id != "semua"){
                    getVillage();
                }
            });


            
            const data = {{ json_encode(@$data) }};
            let marker = null
            let map = null
            let lk = [{{ @$data->longitude ?? 116.924 }},{{ @$data->latitude ?? -0.331 }}];

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    
                }
            }

            function showPosition(position) {
                if(data.longitude == undefined || data.longitude == null){
                    lk = [position.coords.longitude,position.coords.latitude]
                }
                
                
            }

            mapboxgl.accessToken = '{{ env("MAPBOX_TOKEN") }}';
            
            map = new mapboxgl.Map({
                container: 'map_canvas',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: lk,
                zoom: 5
            });

            var geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl,
                marker:false,
                placeholder: 'Masukan kata kunci...',
                zoom:20
            });


            map.addControl(
                geocoder
            );

            marker = new mapboxgl.Marker()
                .setLngLat(lk)
                .addTo(map);
            

            map.on('click', function(e) {
                if(marker == null){
                    marker = new mapboxgl.Marker()
                    .setLngLat(e.lngLat)
                    .addTo(map);
                } else {
                    marker.setLngLat(e.lngLat)
                }
                lk = e.lngLat
                $("#latitude").val(e.lngLat.lat)
                $("#longitude").val(e.lngLat.lng)
                
                
            });
        
                
          
        });
    </script>
@endpush
