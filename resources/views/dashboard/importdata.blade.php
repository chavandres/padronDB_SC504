@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Padron Electoral</h1>
@stop

@section('content')

    <div class="card-header">
        <h3 class="card-title">Importar datos al Padron Electoral</h3>
    </div>


    <form method="POST"  enctype='multipart/form-data' action="{{url('/dashboard/personas/import')}}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="importField">Importar CSV</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="importField" name="importField">
                        <label class="custom-file-label" for="importField">Buscar archivo...</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cargar</button>
        </div>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>


@stop
