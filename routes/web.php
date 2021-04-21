<?php

use App\Http\Controllers\MembresiaController;
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

Auth::routes(['register' => true]);
// Auth::routes();
// Route::get('/',function(){
//     return view('home');
// });
// Route::get('/home',function(){
//     return view('home');
// });



Route::middleware(['auth'])->group(function(){

        // Route::get("/",return view('home'););
        Route::get('/',function(){
            $user = Auth::user();
            // $user->load('role')->;
            return view('home', compact('user'));
        });
        Route::prefix('membresia')->group(function () {
            Route::post('cadastro', [MembresiaController::class, 'store']);
            Route::get('get-all-membros', [MembresiaController::class, 'index']);
            Route::get('get-membro', [MembresiaController::class, 'show']);
            Route::post('delete-membro', [MembresiaController::class, 'destroy']);
        });



});




// Route::middleware(['auth','obreiro'])->prefix('/obreiro')->group(function(){

//         Route::get("/",[App\Http\Controllers\ObreiroController::class, 'index']);

// });


// Route::middleware(['auth','porteiro'])->prefix('/porteiro')->group(function(){

//         Route::get("/",[App\Http\Controllers\PorteiroController::class, 'index']);

// });
