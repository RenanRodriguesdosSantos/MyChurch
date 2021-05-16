<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\VisitanteController;
use App\Http\Controllers\TiposController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitasController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\MembresiaEventosController;
use App\Http\Controllers\MembresiaVisitasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware(['auth'])->group(function(){

        // Route::get("/",return view('home'););
        Route::get('/',function(){
            $user = Auth::user();
            // $user->load('role')->;
            return view('home', compact('user'));
        });
        Route::prefix('membresia')->group(function () {
            Route::post('cadastro', [MembresiaController::class, 'store']);
            Route::get('get-membros', [MembresiaController::class, 'index']);
            Route::get('get-membro', [MembresiaController::class, 'show']);
            Route::post('delete-membro', [MembresiaController::class, 'destroy']);
        });

        Route::prefix('user')->group(function () {
            Route::post('cadastro', [UserController::class, 'store']);
            Route::get('get-all-users', [UserController::class, 'index']);
            Route::get('get-user', [UserController::class, 'show']);
            Route::post('delete-user', [UserController::class, 'destroy']);
        });

        Route::prefix('tipos')->group(function () {
            Route::get('get-all-types', [TiposController::class, 'index']);
        });

        Route::prefix('visitante')->group(function () {
            Route::post('cadastro', [VisitanteController::class, 'store']);
            Route::get('get-all-visitantes', [VisitanteController::class, 'index']);
            Route::get('get-visitante', [VisitanteController::class, 'show']);
            Route::post('delete-visitante', [VisitanteController::class, 'destroy']);
            Route::post('tonar-mebro-visitante', [VisitanteController::class, 'tornarMembro']);
        });

        Route::prefix('visitas')->group(function () {
            Route::post('agendar', [VisitasController::class, 'store']);
            Route::get('get-all-visitas', [VisitasController::class, 'index']);
            Route::get('get-visita', [VisitasController::class, 'show']);
            Route::post('delete-visita', [VisitasController::class, 'destroy']);
            Route::post('realizar', [VisitasController::class, 'finalizar']);
        });

        Route::prefix('evento')->group(function () {
            Route::post('cadastro', [EventoController::class, 'store']);
            Route::get('get-all-eventos', [EventoController::class, 'index']);
            Route::get('get-evento', [EventoController::class, 'show']);
            Route::post('delete-evento', [EventoController::class, 'destroy']);

        });
        Route::prefix('membresia-evento')->group(function () {
            Route::post('add-membro-to-evento', [MembresiaEventosController::class, 'addMembroEvento']);
            Route::post('remove-membro-from-evento', [MembresiaEventosController::class, 'removeMembroEvento']);
            Route::get('get-all-membros', [MembresiaEventosController::class, 'getAllMembrosInEventos']);
        });
        Route::prefix('dashboard')->group(function () {
            Route::get('get-dashboard-data', [DashboardController::class, 'getDashboardData']);
        });
});
