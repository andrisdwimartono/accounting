<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
 
Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('test', [HomeController::class, 'test'])->name('test');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user/editprofile', 'App\Http\Controllers\UserController@editprofile');
    Route::post('/updateprofile', 'App\Http\Controllers\UserController@updateprofile');

    Route::get('/user', 'App\Http\Controllers\UserController@index')->name('user');
    Route::post('/getlistuser', 'App\Http\Controllers\UserController@get_list');
    Route::get('/user/{user}', 'App\Http\Controllers\UserController@show');
    Route::get('/createuser', 'App\Http\Controllers\UserController@create');
    Route::post('/storeuser', 'App\Http\Controllers\UserController@store');
    Route::get('/user/{user}/edit', 'App\Http\Controllers\UserController@edit');
    Route::post('/getdatauser', 'App\Http\Controllers\UserController@getdata');
    Route::post('/getoptionsuser', 'App\Http\Controllers\UserController@getoptions');
    Route::post('/updateuser/{user}', 'App\Http\Controllers\UserController@update');
    Route::post('/deleteuser', 'App\Http\Controllers\UserController@destroy');
    Route::post('/uploadfileuser', 'App\Http\Controllers\UserController@storeUploadFile');

    Route::get('/unitkerja', 'App\Http\Controllers\UnitkerjaController@index')->name('unitkerja');
    Route::post('/getlistunitkerja', 'App\Http\Controllers\UnitkerjaController@get_list');
    Route::get('/unitkerja/{unitkerja}', 'App\Http\Controllers\UnitkerjaController@show');
    Route::get('/createunitkerja', 'App\Http\Controllers\UnitkerjaController@create');
    Route::post('/storeunitkerja', 'App\Http\Controllers\UnitkerjaController@store');
    Route::get('/unitkerja/{unitkerja}/edit', 'App\Http\Controllers\UnitkerjaController@edit');
    Route::post('/getdataunitkerja', 'App\Http\Controllers\UnitkerjaController@getdata');
    Route::post('/updateunitkerja/{unitkerja}', 'App\Http\Controllers\UnitkerjaController@update');
    Route::post('/deleteunitkerja', 'App\Http\Controllers\UnitkerjaController@destroy');

    Route::get('/coa/{category}/list', 'App\Http\Controllers\CoaController@index');
    Route::post('/getlistcoa', 'App\Http\Controllers\CoaController@get_list');
    Route::get('/getlistcoa', 'App\Http\Controllers\CoaController@get_list');
    Route::get('/coa/{coa}', 'App\Http\Controllers\CoaController@show');
    Route::get('/createcoa', 'App\Http\Controllers\CoaController@create');
    Route::post('/storecoa', 'App\Http\Controllers\CoaController@store');
    Route::get('/coa/{coa}/edit', 'App\Http\Controllers\CoaController@edit');
    Route::post('/getdatacoa', 'App\Http\Controllers\CoaController@getdata');
    Route::post('/updatecoa/{coa}', 'App\Http\Controllers\CoaController@update');
    Route::post('/deletecoa', 'App\Http\Controllers\CoaController@destroy');
    Route::post('/getoptionscoa', 'App\Http\Controllers\CoaController@getoptions');
    Route::post('/getlinkscoa', 'App\Http\Controllers\CoaController@getlinks');

    Route::get('/jurnal', 'App\Http\Controllers\JurnalController@index')->name('jurnal');
    Route::post('/getlistjurnal', 'App\Http\Controllers\JurnalController@get_list');
    Route::get('/jurnal/{jurnal}', 'App\Http\Controllers\JurnalController@show');
    Route::get('/createjurnal', 'App\Http\Controllers\JurnalController@create');
    Route::post('/storejurnal', 'App\Http\Controllers\JurnalController@store');
    Route::get('/jurnal/{jurnal}/edit', 'App\Http\Controllers\JurnalController@edit');
    Route::post('/getdatajurnal', 'App\Http\Controllers\JurnalController@getdata');
    Route::post('/updatejurnal/{jurnal}', 'App\Http\Controllers\JurnalController@update');
    Route::post('/deletejurnal', 'App\Http\Controllers\JurnalController@destroy');
    Route::post('/getlinksjurnal', 'App\Http\Controllers\JurnalController@getlinks');

    Route::get('/bukubesar', 'App\Http\Controllers\BukuBesarController@index')->name('bukubesar');
    Route::post('/getlistbukubesar', 'App\Http\Controllers\BukuBesarController@get_list');
    Route::post('/getlinksbukubesar', 'App\Http\Controllers\BukuBesarController@getlinks');
    Route::post('/getsaldoawal', 'App\Http\Controllers\BukuBesarController@get_saldo_awal');
    

    Route::get('/neracasaldo', 'App\Http\Controllers\NeracasaldoController@index')->name('neracasaldo');
    Route::post('/getlistneracasaldo', 'App\Http\Controllers\NeracasaldoController@get_list');
    Route::get('/neracasaldo/{neracasaldo}', 'App\Http\Controllers\NeracasaldoController@show');
    Route::get('/createneracasaldo', 'App\Http\Controllers\NeracasaldoController@create');
    Route::post('/storeneracasaldo', 'App\Http\Controllers\NeracasaldoController@store');
    Route::get('/neracasaldo/{neracasaldo}/edit', 'App\Http\Controllers\NeracasaldoController@edit');
    Route::post('/getdataneracasaldo', 'App\Http\Controllers\NeracasaldoController@getdata');
    Route::post('/updateneracasaldo/{neracasaldo}', 'App\Http\Controllers\NeracasaldoController@update');
    Route::post('/deleteneracasaldo', 'App\Http\Controllers\NeracasaldoController@destroy');
    Route::post('/getlinksneracasaldo', 'App\Http\Controllers\NeracasaldoController@getlinks');
   
    Route::get('/neraca', 'App\Http\Controllers\NeracaController@index')->name('neraca');
    Route::post('/getlistneraca', 'App\Http\Controllers\NeracaController@get_list');
    Route::get('/neraca/{neraca}', 'App\Http\Controllers\NeracaController@show');
    Route::get('/createneraca', 'App\Http\Controllers\NeracaController@create');
    Route::post('/storeneraca', 'App\Http\Controllers\NeracaController@store');
    Route::get('/neraca/{neraca}/edit', 'App\Http\Controllers\NeracaController@edit');
    Route::post('/getdataneraca', 'App\Http\Controllers\NeracaController@getdata');
    Route::post('/updateneraca/{neraca}', 'App\Http\Controllers\NeracaController@update');
    Route::post('/deleteneraca', 'App\Http\Controllers\NeracaController@destroy');
    Route::post('/getlinksneraca', 'App\Http\Controllers\NeracaController@getlinks');

    Route::get('/openperiode/{month}/{year}', 'App\Http\Controllers\OpencloseperiodeController@openperiode');

    Route::middleware(['checkauth'])->group(function () {
        
        
    });
});



