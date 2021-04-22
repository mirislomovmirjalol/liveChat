<?php

use App\Http\Controllers\ManageSitesController;
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
    Route::prefix('websites')->group(function () {
        Route::get('/', [ManageSitesController::class, 'index'])->name('manage_sites');
        Route::post('/', [ManageSitesController::class, 'store']);
        Route::patch('/', [ManageSitesController::class, 'update'])->name('site.update');
        Route::get('create', [ManageSitesController::class, 'create'])->name('site.create');
        Route::get('{website}/edit', [ManageSitesController::class, 'edit'])->name('site.edit');
        Route::get('{website}/delete', [ManageSitesController::class, 'delete'])->name('site.delete');
        Route::get('{website}/about', [ManageSitesController::class, 'showAbout'])->name('site.about');
        Route::get('/{website}/operators', [ManageSitesController::class, 'showOperators'])->name('site.operators');
        Route::get('/{website}/conversations/', [ManageSitesController::class, 'showConversations'])->name('site.conversations');
    });

    Route::get('/operators/create', [ManageSitesController::class, 'showOperator'])->name('site.showOperator');
    Route::post('/operators/create', [ManageSitesController::class, 'createOperator'])->name('site.createOperator');
});
