<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsv;
use Illuminate\Http\Request;
use App\Models\Persona;
use DataTables;
use DB;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $data = Persona::select('*');
        dd($data);
         if ($request->ajax()) {
          
             $data = Persona::select('*');
             return Datatables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function($row){
                     $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
         return view('dashboard.personas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('dashboard.importdata');
    // }

    public function importView()
    {
        return view('dashboard.importdata');
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
                Persona::updateOrCreate([
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
