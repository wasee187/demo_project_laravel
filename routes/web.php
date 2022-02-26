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

//***************Group middleware for auth ********************* */

Route::group(['middleware' => ['pagerestriced']],function(){

    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);

    //***********Admin Dashboard Route*************/
    Route::resource('users', UserController::class);
    Route::put('users/{id}/status',[UserController::class,'updateStatus']);
    Route::get('admin',[AdminController::class,'index']);

    //***********User Dashboard Route*************/
    Route::get('user/file_upload',[ContactController::class,'create']);
    Route::get('file',[FileController::class,'index']);
    Route::get('contact/{name}',[ContactController::class,'show']);
    Route::post('contact',[ContactController::class,'store']);
});