<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::resource('/student',StudentController::class);
Route::get('/delete/{id}',[StudentController::class,'Delete_id']);
Route::get('/edit/{id}',[StudentController::class,'Edit_id']);
Route::post('/update-data',[StudentController::class,'update_data']);
Route::get('/delete-img',[StudentController::class,'delete_img']);
Route::get('/view-single-page/{id}',[StudentController::class,'view_single_page']);