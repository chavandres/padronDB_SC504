<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsv;
use Illuminate\Http\Request;
use App\Models\Persona;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use PDO;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index()
     {
        return view('dashboard.personas');
     }


     public function getPersonas(Request $request)
    {  
        //$data = Persona::select(['cedula','codelec','venccedula','juntareceptora','nombre', 'primerapellido', 'segundoapellido']);
        //return Datatables::of($data)
        $datatable = new Datatables();
        $personas = DB::table('personas')->select(['cedula','codelec','venccedula','juntareceptora','nombre', 'primerapellido', 'segundoapellido']);
        $datatable = $datatable::of($personas)
            ->addColumn('action', function($row){
                $btn = '<a href="/dashboard/personas/'.$row->cedula.'/edit" class="edit btn btn-primary btn-sm">Editar</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
        //ddd($datatable);    
        return $datatable;
    }


    public function del()
    {
        $deleted = DB::delete('delete from personas');
        return redirect('dashboard/personas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $persona = new Persona();


        $persona->cedula = $request->get('inputCedula');
        $persona->codelec = $request->get('inputCodelec');
        $persona->venccedula = $request->get('inputVenccedula');
        $persona->juntareceptora = $request->get('inputJuntaReceptora');
        $persona->nombre = $request->get('inputNombre');
        $persona->primerapellido = $request->get('inputPrimerApellido');
        $persona->segundoapellido = $request->get('inputSegundoApellido');

        $persona->save();

        return redirect('dashboard/personas');
    }


    public function importView()
    {
        return view('dashboard.importdata');
    }

    public function reportsView()
    {
        // Top 5 Nombres Mas Comunes //
        $top5Nombres = DB::select("SELECT padronapp.top5_names FROM dual");    
  
        $top5Data = [];
    
        foreach($top5Nombres as $nombre) {
            $top5Data['label'][] = $nombre->nombre;
            $top5Data['data'][] = (int) $nombre->total;
        }
    
        $top5Data['data'] = json_encode($top5Data);

        // Top 5 Nombres Menos Comunes //

        $bottom5Nombres = DB::select("SELECT padronapp.bottom5_names FROM dual");
        $bottom5Data = [];
    
        foreach($bottom5Nombres as $nombre) {
            $bottom5Data['label'][] = $nombre->nombre;
            $bottom5Data['data'][] = (int) $nombre->total;
        }
    
        $bottom5Data['data'] = json_encode($bottom5Data);

        // Top 5 Cantones con Mas Electores //

        $cantones = DB::select("SELECT padronapp.topcantones FROM dual");
        $cantonesData = [];
    
        foreach($cantones as $canton) {
            $cantonesData['label'][] = $canton->canton;
            $cantonesData['data'][] = (int) $canton->total;
        }
    
        $cantonesData['data'] = json_encode($cantonesData);

        return view('dashboard.reports')
            ->with('top5Names', $top5Data['data'])
            ->with('bottom5Names', $bottom5Data['data'])
            ->with('cantones', $cantonesData['data']);
        
    }

    public function importData(Request $req)
    {
        // dd($request->file('importField'));
        $path = $req->file('importField')->getRealPath();
        //dd(file($path));

        //Validate the file is a csv
        // $req->validate([
        //     'file' => 'required|mimes:csv,txt'
        // ]);
        // dd(file($req->file('importField')->getRealPath()));
         $data = file($path);

        //chunk array every 5000 lines
         $parts = (array_chunk($data, 5000));

        // //Loop though each part of 1000 lines and put those contents to each index file i.e part 1, part 2...
         foreach($parts as $index=>$part){
             $filename = resource_path('pendingPersonas/personas_'.date('y-m-d-H-i-s').$index. '.csv');
             file_put_contents($filename, $part);
         }

         session()->flash('status', 'Procesando archivo.');

         $path = resource_path('pendingPersonas/personas*.csv');

        //Glob function will get all of the files within the $path directory
         $files = glob($path);
         


         //This processes two files at a time
         foreach ($files as $file) {
 

            $data = array_map('str_getcsv', file($file));
            $personasArray = [];
            foreach($data as $row) {
                Persona::firstOrCreate([
                    'cedula' => $row[0]
                ], [
                    'codelec' => $row[1],
                    'venccedula' => $row[2],
                    'juntareceptora' => $row[3],
                    'nombre' => $row[4],
                    'primerapellido' => $row[5],
                    'segundoapellido' => $row[6]
                ]);
                 
            }

            unlink($file);

         }
        return redirect('dashboard/personas')->with('status','Datos importados correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cedula)
    {
        $persona = Persona::where('cedula', $cedula)->get();
        //return $persona;
        return view('dashboard.edit')->with('persona', $persona);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cedula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cedula)
    {
        $persona = Persona::where('cedula', $cedula)->get()->first();

        $persona->codelec = $request->get('inputCodelec');
        $persona->venccedula = $request->get('inputVenccedula');
        $persona->juntareceptora = $request->get('inputJuntaReceptora');
        $persona->nombre = $request->get('inputNombre');
        $persona->primerapellido = $request->get('inputPrimerApellido');
        $persona->segundoapellido = $request->get('inputSegundoApellido');
        
        $persona->save();

        return redirect('dashboard/personas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $cedula
     * @return \Illuminate\Http\Response
     */
    public function destroy($cedula)
    {
        $persona = Persona::where('cedula', $cedula)->get()->first();
        $persona->delete();

        return redirect('/dashboard/personas');
    }

    public function searchView()
    {
        return view('dashboard.consultas');
    }

    public function searchQuery(Request $request)
    {
        $searchCedula = $request->get('formData')['1']['value'];
        $searchNombre = $request->get('formData')['2']['value'];
        $searchApe1 = $request->get('formData')['3']['value'];
        $searchApe2 = $request->get('formData')['4']['value'];
        
        $searchResults = DB::select("select consulta_persona('".$searchCedula."','".$searchNombre."','".$searchApe1."','".$searchApe2."') from dual");
        $datatable = new Datatables();
        $datatable = $datatable::of($searchResults)
            ->addColumn('action', function($row){
                $btn = '<a href="/dashboard/personas/'.$row->cedula.'/edit" class="edit btn btn-primary btn-sm">Editar</a>';
                return $btn;
            })
            ->rawColumns(['action']);  
        return $datatable->make(true);
    }

    public function vowels()
    {
        $vowels = DB::select("SELECT padronapp.nombresVocales FROM dual");

        $datatable = new Datatables();
        $datatable = $datatable::of($vowels);  
        return $datatable->make(true);

    }
}
