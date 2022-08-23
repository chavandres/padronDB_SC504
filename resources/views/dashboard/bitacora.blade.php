@extends('adminlte::page')

@section('title', 'Bitacora - Padron Electoral')

@section('content_header')
    <h1>Bitacora del Padron Electoral</h1>
@stop

@section('content')

    <body>
        <div class="container">
            <table class="table table-bordered yajra-datatable" id="yajra-datatable">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Sentencia SQL</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </body>

@stop

@section('css')

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
            var table = $('#yajra-datatable').DataTable();
            table.clear();
            table.destroy();
            table = $('#yajra-datatable').DataTable({

                processing: true,
                serverSide: true,
                ajax: "{{ route('personas.bitacoraList') }}",
                columns: [
                    {data: 'usuario', name: 'usuario'},
                    {data: 'fecha', name: 'fecha'},
                    {data: 'sentencia', name: 'sentencia'},
                ],
                order: [[1, 'desc']],
            });
        });
    </script>
@stop
