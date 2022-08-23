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

    Route::get('/dashboard/personas/list', [PersonaController::class, 'getPersonas'])->name('personas.list');

    Route::get('/dashboard/personas/import', [PersonaController::class, 'importView'])->name('personas.importView');

    Route::post('/dashboard/personas/import', [PersonaController::class, 'importData'])->name('personas.importData');

    Route::get('/dashboard/personas/reports', [PersonaController::class, 'reportsView'])->name('personas.reportsView');

    Route::get('/dashboard/personas/create', [PersonaController::class, 'create'])->name('personas.create');

    Route::post('/dashboard/personas/store', [PersonaController::class, 'store'])->name('personas.store');

    Route::get('/dashboard/personas/{persona}/edit', [PersonaController::class, 'edit'])->name('personas.edit');

    Route::put('/dashboard/personas/{cedula}/edit', [PersonaController::class, 'update'])->name('persona.update');

    Route::post('/dashboard/personas/{cedula}/delete', [PersonaController::class, 'destroy'])->name('persona.destroy');

    Route::get('/dashboard/personas/search', [PersonaController::class, 'searchView'])->name('personas.searchView');

    Route::post('/dashboard/personas/searchQuery', [PersonaController::class, 'searchQuery'])->name('personas.query');

    Route::get('/dashboard/personas/reports/vowels', [PersonaController::class, 'vowels'])->name('personas.vowels');







// Ruta debug //

    Route::get('/debug', function () {
        return view('info');
    });

    Route::get('/debug/personas/list', [PersonaController::class, 'getPersonas']);

    Route::get('/debug/personas/clear', [PersonaController::class, 'del']);

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
        return view('dashboard.personas');
    })->name('dashboard');
});
