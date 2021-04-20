<?php

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

Route::get('/', function () {
    return view('index');
})->name('home');

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/manage_sites', [App\Http\Controllers\ManageSitesController::class, 'index'])->name('manage_sites');
    Route::get('/manage_sites/create', [App\Http\Controllers\ManageSitesController::class, 'create'])->name('site.create');
    Route::post('/manage_sites', [App\Http\Controllers\ManageSitesController::class, 'store']);
    Route::get('/manage_sites/site/{website}', [App\Http\Controllers\ManageSitesController::class, 'edit'])->name('site.edit');
    Route::patch('/manage_sites', [App\Http\Controllers\ManageSitesController::class, 'update'])->name('site.update');

});
