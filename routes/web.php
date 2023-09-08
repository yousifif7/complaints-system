<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;
use App\Http\Controllers\formController;
use App\Http\Controllers\RequestTypeController;

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



// Route::get('/', function () {
//     return view('categories/index');
// });
Route::get('/', [CatController::class,'index']);
Route::get('/complaints', [CatController::class,'index']);
Route::get('/complaints/cat/{id}', [CatController::class,'cat'])->name('category.cat');

Route::resource('category',CatController::class);

// Route::get('categories',[CatController::class,'index']);
// Route::get('/categories/cat1',[CatController::class,'cat1']);
// Route::get('/categories/cat2',[CatController::class,'cat2']);
// Route::get('categories/cat3',[CatController::class,'cat3']);
// Route::get('categories/cat4',[CatController::class,'cat4']);
// Route::get('categories/cat5',[CatController::class,'cat5']);
// Route::get('categories/cat6',[CatController::class,'cat6']);

Route::resource('form',FormController::class);
Route::get('admins/forms', [FormController::class,'index']);
Route::get('admins/delete', [FormController::class,'deleteAll'])->name('forms.delete');
Route::get('admins/deletecomp', [FormController::class,'deleteCompleted'])->name('forms.deletecomp');


Route::get('admins/createcat', [CatController::class,'create']);
Route::get('createdCategory', [CatController::class,'storeCat'])->name('category.storeCat');


Route::get('admins/createreq_type', [RequestTypeController::class,'create']);
Route::resource('requesttype',RequestTypeController::class);
Route::get('createRquesttype', [RequestTypeController::class,'store'])->name('requesttype.store');



