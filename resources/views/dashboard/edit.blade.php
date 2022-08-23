@extends('adminlte::page')

@section('title', 'Editar persona - Padron Electoral')

@section('content_header')
    <h1>Padron Electoral</h1>
@stop

@section('content')
    <form id="delete" method="POST" action="{{url('/dashboard/personas/'.$persona[0]->cedula.'/delete')}}">@csrf</form>

    <div class="card-header">
        <h3 class="card-title">Editar Persona del Padron Electoral</h3>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('persona.update', ['cedula' => $persona[0]->cedula])}}">
          @csrf
          @method('PUT')
              <div class="form-group">
                  <label for="inputCedula">Cedula</label>
                  <input type="text" class="form-control" id="inputCedula" name="inputCedula" value="{!! $persona[0]->cedula !!}" readonly>
                </div>
                <div class="form-group">
                  <label for="inputCodelec">Codigo Electoral</label>
                  <input type="text" class="form-control" id="inputCodelec" name="inputCodelec" value="{!! $persona[0]->codelec !!}">
                  <small id="codelecHelp" class="form-text text-muted">Debe insertar un Codigo Electoral existente.</small>
                </div>
                <div class="form-group">
                  <label for="inputVenccedula">Vencimiento Cedula</label>
                  <input type="text" class="form-control" id="inputVenccedula" name="inputVenccedula" value="{!! $persona[0]->venccedula !!}">
                  <small id="vencHelp" class="form-text text-muted">Ejemplo: 20100831.</small>
                </div>
                <div class="form-group">
                  <label for="inputJuntaReceptora">Junta Receptora</label>
                  <input type="text" class="form-control" id="inputJuntaReceptora" name="inputJuntaReceptora" value="{!! $persona[0]->juntareceptora !!}">
                </div>
                <div class="form-group">
                  <label for="inputNombre">Nombre</label>
                  <input type="text" class="form-control" id="inputNombre" name="inputNombre" value="{!! $persona[0]->nombre !!}">
                </div>
                <div class="form-group">
                  <label for="inputPrimerApellido">Primer Apellido</label>
                  <input type="text" class="form-control" id="inputPrimerApellido" name="inputPrimerApellido" value="{!! $persona[0]->primerapellido !!}">
                </div>
                <div class="form-group">
                  <label for="inputSegundoApellido">Segundo Apellido</label>
                  <input type="text" class="form-control" id="inputSegundoApellido" name="inputSegundoApellido" value="{!! $persona[0]->segundoapellido !!}">
                </div>
        <div class="card-footer" style="padding: .75rem 0">
            <a href="/dashboard/personas" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary " id="sendInput">Actualizar</button>
            </form>
            <button type="submit" form="delete" class="btn btn-danger" id="sendInput">Eliminar</button>
        </div>    
    </div>
    

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $('#sendInput').click(function(e) {
            toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.info('Espere por favor...', 'Actualizacion Iniciada');
        });
    </script>

    



@stop