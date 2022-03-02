<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileController;
use App\Models\Contact;

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
    return view('welcome');
});

//*******Auth route*********// 

Route::get("/logout", function(){
    if(session()->has('user')){
        session()->pull('user');
    }
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

//***************Group middleware for auth ********************* */

Route::group(['middleware' => ['web','admin_middleware']],function(){

    //***********Admin Route*************/
    Route::resource('users', UserController::class);
    Route::get('admin',[AdminController::class,'index'])->middleware("admin_middleware");;
    Route::get('admin/user/register',[AdminController::class,'user_Register'])->middleware("admin_middleware");
    Route::get('admin/user/{id}/edit',[AdminController::class,'edit_user'])->middleware("admin_middleware");;

    Route::put('users/{id}/status',[UserController::class,'updateStatus']);
    Route::post('admin/user/register',[AdminController::class,'store_user']);
    Route::put('admin/user/{id}/update',[AdminController::class,'update_user']);
    Route::delete('/admin/user/{id}/delete',[AdminController::class,'delete_user']);
    Route::put('/admin/user/{id}/status',[AdminController::class,'user_status']);

    //***********User Dashboard Route*************/
    Route::get('user/file_upload',[ContactController::class,'create']);
    Route::get('file',[FileController::class,'index']);
    Route::get('contact/{name}',[ContactController::class,'show']);
    Route::post('contact',[ContactController::class,'store']);
});