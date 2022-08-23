<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Persona extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personas';
    public $timestamps = false;
    protected $fillable = ['cedula','codelec','venccedula', 'juntareceptora', 'nombre', 'primerapellido', 'segundoapellido'];
    use HasFactory;
}
