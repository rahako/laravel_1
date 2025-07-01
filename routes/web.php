<?php

use App\Http\Controllers\HomebudgetController;
use App\Models\HomeBudget;
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
    return view('homebudget.index');
});

Route::get('/', [HomebudgetController::class, 'index'])->name('index');
Route::post('/post', [HomebudgetController::class, 'store'])->name('store');
Route::get('/edit/{id}', [HomebudgetController::class, 'edit'])->name('homebudget.edit');
Route::put('/homebudget/{id}', [HomebudgetController::class, 'update'])->name('homebudget.update');
Route::post('/destroy/{id}',[HomebudgetController::class,'destroy'] )->name('homebudget.destroy');