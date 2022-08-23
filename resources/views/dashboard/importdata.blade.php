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
            <button type="submit" class="btn btn-primary" id="sendInput">Cargar</button>
        </div>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
    <script>
        $('#sendInput').click(function(e) {
            toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.info('Espere por favor...', 'Importacion Iniciada');
        });
    </script>

    



@stop
