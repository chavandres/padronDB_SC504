@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Padron Electoral</h1>
@stop

@section('content')

    <body>
        <div class="container">
            <h1>Personas Registradas en el Padron</h1>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Codigo Electoral</th>
                        <th>Expiracion Cedula</th>
                        <th>Junta Receptora</th>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th width="100px">Accion</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </body>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}} 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({

                processing: true,
                serverSide: true,
                ajax: "{{ route('personas.index') }}",
                columns: [{data: 'cedula', name: 'cedula'},
                    {data: 'codelec', name: 'codelec'},
                    {data: 'venccedula', name: 'venccedula'},
                    {data: 'juntareceptora', name: 'juntareceptora'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'primerapellido', name: 'primerapellido'},
                    {data: 'segundoapellido', name: 'segundoapellido'},
                    {data: 'action',name: 'action',
                    orderable: false, searchable: false},

                ]
            });
        });
    </script>
@stop
