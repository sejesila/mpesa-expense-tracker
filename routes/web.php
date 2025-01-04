<?php

use App\Http\Controllers\ExpensesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/import',[ExpensesController::class,'import'])->name('import');
Route::get('/paybill',[ExpensesController::class,'paybill'])->name('paybill');
Route::get('/till',[ExpensesController::class,'till'])->name('till');
Route::get('/send_money',[ExpensesController::class,'send_money'])->name('send_money');
Route::get('/import', function () {
   //should match the name of your component file without the .blade.php extension
    return view('import_excel');
});
