<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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

Route::controller(TaskController::class)->group(function(){
    Route::get('/','index')->name('home');
    Route::post('add/task','addTask')->name('addTask');
    Route::post('Delete/Task','delete')->name('deleteTask');
    Route::get('Show/All/Task','showAllTask')->name('showAllTask');
    Route::post('Complete/Task','completeTask')->name('completeTask');
});



