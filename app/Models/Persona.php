<?php

namespace App\Models;

//use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
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
    protected $primaryKey = 'cedula';
    public $timestamps = false;
    use HasFactory;
}
