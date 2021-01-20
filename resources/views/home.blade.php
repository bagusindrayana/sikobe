@extends('layouts.app-front')

@section('content')
    <div id="home-source" data-initial-state="{{ $params }}"></div>
    <div id="home-app"></div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            let province_id = 0;
            let regency_id = 0;
            let district_id = 0;
            $.ajax({
                url:'{{ url("api/territory") }}',
                type:'GET',
                success:function(data){
                    let opts = `<option value="all"{{ (empty($filter['province'])) ? ' selected=selected' : '' }}>Semua</option>`;

                    for (let i = 0; i < data[0].length; i++) {
                        const d = data[0][i];
                        opts += `<option value="${d.id}">${d.name}</option>`
                        
                    }

                    $("#filter-province").html(opts);
                    $("#filter-regency").html(`<option value="all"{{ (empty($filter['regency'])) ? ' selected=selected' : '' }}>Semua</option>`);
                    $("#filter-district").html(`<option value="all"{{ (empty($filter['district'])) ? ' selected=selected' : '' }}>Semua</option>`);
                    $("#filter-village").html(`<option value="all"{{ (empty($filter['village'])) ? ' selected=selected' : '' }}>Semua</option>`);
                }
            });

            $(document).on('change','#filter-province',function(){
                province_id = $(this).val();
                if(province_id != "semua"){
                    $.ajax({
                        url:'{{ url("api/territory") }}/'+province_id,
                        type:'GET',
                        success:function(data){
                            let opts = `<option value="all"{{ (empty($filter['regency'])) ? ' selected=selected' : '' }}>Semua</option>`;

                            for (let i = 0; i < data[0].length; i++) {
                                const d = data[0][i];
                                opts += `<option value="${d.id}">${d.name}</option>`
                                
                            }

                            $("#filter-regency").html(opts);
                            $("#filter-district").html(`<option value="all"{{ (empty($filter['district'])) ? ' selected=selected' : '' }}>Semua</option>`);
                            $("#filter-village").html(`<option value="all"{{ (empty($filter['village'])) ? ' selected=selected' : '' }}>Semua</option>`);
                        }
                    });
                }
            });

            $(document).on('change','#filter-regency',function(){
                regency_id = $(this).val();
                if(regency_id != "semua"){
                    $.ajax({
                        url:'{{ url("api/territory") }}/'+province_id+'/'+regency_id,
                        type:'GET',
                        success:function(data){
                            let opts = `<option value="all"{{ (empty($filter['district'])) ? ' selected=selected' : '' }}>Semua</option>`;

                            for (let i = 0; i < data[0].length; i++) {
                                const d = data[0][i];
                                opts += `<option value="${d.id}">${d.name}</option>`
                                
                            }

                            $("#filter-district").html(opts);
                            $("#filter-village").html(`<option value="all"{{ (empty($filter['village'])) ? ' selected=selected' : '' }}>Semua</option>`);
                        }
                    });
                }
            });


            $(document).on('change','#filter-district',function(){
                district_id = $(this).val();
                if(district_id != "semua"){
                    $.ajax({
                        url:'{{ url("api/territory") }}/'+province_id+'/'+regency_id+'/'+district_id,
                        type:'GET',
                        success:function(data){
                            let opts = `<option value="all"{{ (empty($filter['village'])) ? ' selected=selected' : '' }}>Semua</option>`;

                            for (let i = 0; i < data[0].length; i++) {
                                const d = data[0][i];
                                opts += `<option value="${d.id}">${d.name}</option>`
                                
                            }

                            $("#filter-village").html(opts);
                        }
                    });
                }
            });
        });
    </script>
@endpush
