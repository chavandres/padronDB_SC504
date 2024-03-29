@extends('adminlte::page')

@section('title', 'Reportes - Padron Electoral')

@section('content_header')
    <h1>Reportes</h1>
@stop

@section('content')
<div style="display: flex; flex-wrap: wrap;">
    <div class="card" style="width: 48%; height: auto; margin: 1rem;">
      <h5 class="card-header" style="font-weight: bold;">Top 5 Nombres Mas Comunes</h5>
      <div class="pie-chart-container">
        <canvas id="topNombres"></canvas>
      </div>
    </div>

  <div class="card" style="width: 48%; height: auto; margin: 1rem;">
    <h5 class="card-header" style="font-weight: bold;">Top 5 Nombres Menos Comunes</h5>
    <div class="pie-chart-container">
      <canvas id="bottomNombres"></canvas>
    </div>
  </div>
        
  <div class="card" style="width: 48%; height: auto; margin: 1rem;">
    <h5 class="card-header" style="font-weight: bold;">Top 5 Cantones con Mayor Cantidad de Personas Inscritas</h5>
      <div class="bar-chart-container">
        <canvas id="cantones"></canvas>
      </div>
  </div>    

  <div class="card" style="width: 48%; height: auto; margin: 1rem;">
    <h5 class="card-header" style="font-weight: bold;">Nombres con 5 Vocales Diferentes</h5>
        <table class="table table-bordered yajra-datatable"  id="yajra-datatable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

<script>
    $(document).ready(function(){
        //get the pie chart canvas
        const cData = JSON.parse(`<?php echo $top5Names; ?>`)
        var ctx = $("#topNombres");
   
        //pie chart data
        var data = {
          labels: cData.label,
          datasets: [
            {
              label: "Users Count",
              data: cData.data,
              backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
              ],
              borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
              ],
              borderWidth: [1, 1, 1, 1, 1,1,1]
            }
          ]
        };
   
        //options
        var options = {
          responsive: true,
          title: {
            display: true,
            position: "top",
          },
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontColor: "#333",
              fontSize: 16
            }
          }
        };
   
        //create Pie Chart class object
        const chart1 = new Chart(ctx, {
          type: "pie",
          data: data,
          options: options
        });
   
    });
  </script>

<script>
  $(document).ready(function(){
      //get the pie chart canvas
      const cData = JSON.parse(`<?php echo $bottom5Names; ?>`)
      var ctx = $("#bottomNombres");
 
      //pie chart data
      var data = {
        labels: cData.label,
        datasets: [
          {
            label: "Users Count",
            data: cData.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {display: true},
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        }
      };
 
      //create Pie Chart class object
      const chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: options
      });
 
  });
</script>

<script>
  $(document).ready(function(){
      //get the Bar chart canvas
      const cData = JSON.parse(`<?php echo $cantones; ?>`);
      var ctx = $("#cantones");
 
      //Bar chart data
      var data = {
        labels: cData.label,
        datasets: [
          {
            data: cData.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
        },
        legend: {
          display: false
        }
      };
 
      //create Bar Chart class object
      const chart1 = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
      });
 
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
      var table = $('#yajra-datatable').DataTable();
          
      table.clear();
      table.destroy();

      table = $('#yajra-datatable').DataTable({

          processing: true,
          serverSide: true,
          ajax: "{{ route('personas.vowels') }}",
          columns: [
              {data: 'nombre', name: 'nombre'},
              {data: 'total', name: 'total'},
          ],
          searching: false,
          lengthChange: false,
          order: [[1, 'desc']],
      });
  });
</script>



@stop