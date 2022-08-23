@extends('adminlte::page')

@section('title', 'Agregar datos - Padron Electoral')

@section('content_header')
    <h1>Padron Electoral</h1>
@stop

@section('content')

    <div class="card-header">
        <h3 class="card-title">Agregar datos al Padron Electoral</h3>
    </div>


    <form method="POST" action="{{url('/dashboard/personas/store')}}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="inputCedula">Cedula</label>
                <input type="text" class="form-control" id="inputCedula" name="inputCedula" placeholder="Digite la cedula">
              </div>
              <div class="form-group">
                <label for="inputCodelec">Codigo Electoral</label>
                <input type="text" class="form-control" id="inputCodelec" name="inputCodelec" placeholder="Digite el codigo electoral">
                <small id="codelecHelp" class="form-text text-muted">Debe insertar un Codigo Electoral existente.</small>
              </div>
              <div class="form-group">
                <label for="inputVenccedula">Vencimiento Cedula</label>
                <input type="text" class="form-control" id="inputVenccedula" name="inputVenccedula" placeholder="Digite vencimiento cedula">
                <small id="vencHelp" class="form-text text-muted">Ejemplo: 20100831.</small>
              </div>
              <div class="form-group">
                <label for="inputJuntaReceptora">Junta Receptora</label>
                <input type="text" class="form-control" id="inputJuntaReceptora" name="inputJuntaReceptora" placeholder="Digite junta receptora">
              </div>
              <div class="form-group">
                <label for="inputNombre">Nombre</label>
                <input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Digite el nombre">
              </div>
              <div class="form-group">
                <label for="inputPrimerApellido">Primer Apellido</label>
                <input type="text" class="form-control" id="inputPrimerApellido" name="inputPrimerApellido" placeholder="Digite el primer apellido">
              </div>
              <div class="form-group">
                <label for="inputSegundoApellido">Segundo Apellido</label>
                <input type="text" class="form-control" id="inputSegundoApellido" name="inputSegundoApellido" placeholder="Digite el segundo apellido">
              </div>

        </div>

        <div class="card-footer">
            <a href="/dashboard/personas" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" id="sendInput">Insertar</button>
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