<?php

use App\Http\Controllers\Admin\KanbanController;
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
Route::controller(KanbanController::class)->name('web.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/get-app', 'getApp')->name('index.post');
        Route::post('/update-card', 'update')->name('index.update');
        Route::post('/show-card', 'show')->name('index.show');
});
