<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\OfficesDisplayController;
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
// Route::get('/', function() {
//     return view('import');
// });
Route::controller(ImportController::class)->group(function(){
    Route::get('/', 'importFile');
    Route::post('import', 'import')->name('import');
    Route::get('export', 'export')->name('export');
});
Route::get('/', [OfficesDisplayController::class,'indexFiltering'])->name('office.filter');