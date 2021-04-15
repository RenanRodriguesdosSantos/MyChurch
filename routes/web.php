<?php

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

Auth::routes(['register' => false]);
Auth::routes();
Route::get('/',function(){
    if(Auth::check()){
        $tipo = Auth::user()->tipo;
        switch ($tipo) {
            case 1:
                return redirect('/lider');
                break;
            case 2:
                return redirect('/obreiros');
                break;
            case 3:
                return redirect('/porteiros');
                break;
        }
    }
    else{
        return redirect('/login');
    }
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para usuário lider
Route::middleware(['auth','lider'])->prefix('/lider')->group(function(){
    //_________________VIEWS__________________//
        Route::get("/",[App\Http\Controllers\LiderController::class, 'index']);
    //_________________DATAS__________________//
});


Route::middleware(['auth','obreiro'])->prefix('/obreiro')->group(function(){
    //_________________VIEWS__________________//
        Route::get("/",[App\Http\Controllers\ObreiroController::class, 'index']);
    //_________________DATAS__________________//
});


Route::middleware(['auth','porteiro'])->prefix('/porteiro')->group(function(){
    //_________________VIEWS__________________//
        Route::get("/",[App\Http\Controllers\PorteiroController::class, 'index']);
    //_________________DATAS__________________//
});