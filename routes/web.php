<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\PersonaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas de personas //

    Route::get('/dashboard/personas', [PersonaController::class, 'index'])->name('personas.index');

    Route::get('/dashboard/personas/import', [PersonaController::class, 'importView'])->name('personas.importView');

    Route::post('/dashboard/personas/import', [PersonaController::class, 'importData'])->name('personas.importData');
    

// Ruta debug //

    Route::get('/debug', function () {
        return view('info');
    });

// Rutas de inicio y auth //    
    Route::get('/', function () {
        return view('auth.login');
    });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
});
