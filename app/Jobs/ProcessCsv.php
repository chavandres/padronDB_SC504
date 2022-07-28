<?php

namespace App\Jobs;

use App\Models\Persona;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $personas;
    public $personasArray;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $personas, $personasArray)
    {
        $this->file = $file;
        $this->personas = $personas;
        $this->personasArray = $personasArray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dump('processing file:----', $this->file);

        $data = array_map('str_getcsv', file($this->file));
        
        foreach($data as $row) {
            if(!in_array($row[0], $this->personas)){
                $this->personasArray[] = [
                    'cedula' => $row[0],
                    'codelec' => $row[1],
                    'venccedula' => $row[2],
                    'juntareceptora' => $row[3],
                    'nombre' => $row[4],
                    'primerapellido' => $row[5],
                    'segundoapellido' => $row[6],
                ];
            } 
        }
        Persona::insert($this->personasArray);
        dump('done file:----', $this->file);
        unlink($this->file);
    }
}
