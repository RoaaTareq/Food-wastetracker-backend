<?php
use Illuminate\Support\Facades\Route;
use Modules\Career\Http\Controllers\CareerController;

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


    Route::get('/career', 'CareerController@index');
    
    Route::get('/career/create', 'CareerController@create')->name('career.create');

