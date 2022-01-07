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

Route::get('/', [AuthController::class, 'showFormLogin'])->name('login-form');
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

    

    Route::middleware(['checkauth'])->group(function () {
        Route::get('/menu', 'App\Http\Controllers\MenuController@index')->name('menu');
        Route::post('/getlistmenu', 'App\Http\Controllers\MenuController@get_list');
        Route::get('/menu/{menu}', 'App\Http\Controllers\MenuController@show');
        Route::get('/createmenu', 'App\Http\Controllers\MenuController@create');
        Route::post('/storemenu', 'App\Http\Controllers\MenuController@store');
        Route::get('/menu/{menu}/edit', 'App\Http\Controllers\MenuController@edit');
        Route::post('/getdatamenu', 'App\Http\Controllers\MenuController@getdata');
        Route::post('/updatemenu/{menu}', 'App\Http\Controllers\MenuController@update');
        Route::post('/deletemenu', 'App\Http\Controllers\MenuController@destroy');

        Route::get('/dashboard/labarugi', 'App\Http\Controllers\DashboardController@labarugi');
        Route::post('/dashboard/get_list', 'App\Http\Controllers\DashboardController@get_list');
        

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
        Route::post('/getlinksuser', 'App\Http\Controllers\UserController@getlinks');
        Route::post('/uploadfileuser', 'App\Http\Controllers\UserController@storeUploadFile');
        Route::get('/assignmenu/{user}/edit', 'App\Http\Controllers\UserController@assignmenu');
        Route::post('/assignmenu/{user}', 'App\Http\Controllers\UserController@update_assignmenu');
        Route::post('/getdataassignmenuuser', 'App\Http\Controllers\UserController@getdataassignmenuuser');
        Route::post('/getdataassignmenuuserrole', 'App\Http\Controllers\UserController@getdataassignmenuuserrole');
        Route::post('/updateassignmenuuser/{user}', 'App\Http\Controllers\UserController@updateassignmenu');
        Route::get('/getusermenu', 'App\Http\Controllers\UserController@getUserMenu');

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
        Route::get('/printcoa2', 'App\Http\Controllers\CoaController@get_list');
        Route::get('/coa/{coa}', 'App\Http\Controllers\CoaController@show');
        Route::get('/createcoa', 'App\Http\Controllers\CoaController@create');
        Route::post('/storecoa', 'App\Http\Controllers\CoaController@store');
        Route::get('/coa/{coa}/edit', 'App\Http\Controllers\CoaController@edit');
        Route::post('/getdatacoa', 'App\Http\Controllers\CoaController@getdata');
        Route::post('/updatecoa/{coa}', 'App\Http\Controllers\CoaController@update');
        Route::post('/deletecoa', 'App\Http\Controllers\CoaController@destroy');
        Route::post('/getoptionscoa', 'App\Http\Controllers\CoaController@getoptions');
        Route::post('/getlinkscoa', 'App\Http\Controllers\CoaController@getlinks');
        Route::post('/printcoa', 'App\Http\Controllers\CoaController@print');

        Route::get('/jurnal', 'App\Http\Controllers\JurnalController@index')->name('jurnal');
        Route::post('/getlistjurnal', 'App\Http\Controllers\JurnalController@get_list');
        Route::get('/jurnal/{jurnal}', 'App\Http\Controllers\JurnalController@show');
        Route::get('/createjurnal', 'App\Http\Controllers\JurnalController@create');
        Route::get('/createsaldoawal', 'App\Http\Controllers\JurnalController@createsaldoawal');
        Route::post('/storejurnal', 'App\Http\Controllers\JurnalController@store');
        Route::get('/jurnal/{jurnal}/edit', 'App\Http\Controllers\JurnalController@edit');
        Route::post('/getdatajurnal', 'App\Http\Controllers\JurnalController@getdata');
        Route::post('/updatejurnal/{jurnal}', 'App\Http\Controllers\JurnalController@update');
        Route::post('/deletejurnal', 'App\Http\Controllers\JurnalController@destroy');
        Route::post('/getlinksjurnal', 'App\Http\Controllers\JurnalController@getlinks');
        Route::get('/createjurnalbkm', 'App\Http\Controllers\JurnalController@createbkm');
        Route::get('/createjurnalbkk', 'App\Http\Controllers\JurnalController@createbkk');
        Route::get('/createjurnalbbm', 'App\Http\Controllers\JurnalController@createbbm');
        Route::get('/createjurnalbbk', 'App\Http\Controllers\JurnalController@createbbk');
        Route::post('/storejurnalbkmk', 'App\Http\Controllers\JurnalController@storebkmk');
        Route::post('/getdatajurnal_bkmk', 'App\Http\Controllers\JurnalController@getdata_bkmk');
        Route::post('/getlistjurnal_bkmk', 'App\Http\Controllers\JurnalController@get_list_bkmk');
        Route::post('/updatejurnalbkmk/{jurnal}', 'App\Http\Controllers\JurnalController@update_bkmk');
        Route::post('/jurnal/print', 'App\Http\Controllers\JurnalController@print');
        Route::post('/jurnalbkmk/print', 'App\Http\Controllers\JurnalController@bkmkprint');
        Route::post('/jurnal/excel', 'App\Http\Controllers\JurnalController@excel');
        Route::post('/jurnalbkmk/excel', 'App\Http\Controllers\JurnalController@bkmkexcel');

        Route::get('/bukubesar', 'App\Http\Controllers\BukuBesarController@index')->name('bukubesar');
        Route::post('/getlistbukubesar', 'App\Http\Controllers\BukuBesarController@get_list');
        Route::post('/getlinksbukubesar', 'App\Http\Controllers\BukuBesarController@getlinks');
        Route::post('/getsaldoawal', 'App\Http\Controllers\BukuBesarController@get_saldo_awal');
        Route::post('/bukubesar/print', 'App\Http\Controllers\BukuBesarController@print');
        Route::post('/bukubesar/excel', 'App\Http\Controllers\BukuBesarController@excel');

        Route::get('/neracasaldo', 'App\Http\Controllers\NeracasaldoController@index')->name('neracasaldo');
        Route::post('/getlistneracasaldo', 'App\Http\Controllers\NeracasaldoController@get_list');
        Route::post('/neracasaldo/print', 'App\Http\Controllers\NeracasaldoController@print');
        Route::post('/neracasaldo/excel', 'App\Http\Controllers\NeracasaldoController@excel');
        
        Route::get('/neraca', 'App\Http\Controllers\NeracaController@index')->name('neraca');
        Route::post('/getlistneraca', 'App\Http\Controllers\NeracaController@get_list');
        Route::post('/neraca/print', 'App\Http\Controllers\NeracaController@print');
        Route::post('/neraca/excel', 'App\Http\Controllers\NeracaController@excel');
        
        Route::get('/labarugi', 'App\Http\Controllers\LabarugiController@index')->name('labarugi');
        Route::post('/getlistlabarugi', 'App\Http\Controllers\LabarugiController@get_list');
        Route::post('/labarugi/print', 'App\Http\Controllers\LabarugiController@print');
        Route::post('/labarugi/excel', 'App\Http\Controllers\LabarugiController@excel');

        Route::get('/globalsetting', 'App\Http\Controllers\GlobalsettingController@index')->name('globalsetting');
        Route::post('/getlistglobalsetting', 'App\Http\Controllers\GlobalsettingController@get_list');
        Route::get('/globalsetting/{globalsetting}', 'App\Http\Controllers\GlobalsettingController@show');
        Route::get('/createglobalsetting', 'App\Http\Controllers\GlobalsettingController@create');
        Route::post('/storeglobalsetting', 'App\Http\Controllers\GlobalsettingController@store');
        Route::get('/globalsetting/{globalsetting}/edit', 'App\Http\Controllers\GlobalsettingController@edit');
        Route::post('/getdataglobalsetting', 'App\Http\Controllers\GlobalsettingController@getdata');
        Route::post('/updateglobalsetting/{globalsetting}', 'App\Http\Controllers\GlobalsettingController@update');
        Route::post('/deleteglobalsetting', 'App\Http\Controllers\GlobalsettingController@destroy');
        Route::post('/getoptionsglobalsetting', 'App\Http\Controllers\GlobalsettingController@getoptions');
        Route::post('/getlinksglobalsetting', 'App\Http\Controllers\GlobalsettingController@getlinks');
        Route::post('/uploadfileglobalsetting', 'App\Http\Controllers\GlobalsettingController@storeUploadFile');    
        Route::get('/getglobalsetting', 'App\Http\Controllers\GlobalsettingController@getglobalsetting');
        
        //Route::get('/openperiode/{month}/{year}', 'App\Http\Controllers\OpencloseperiodeController@openperiode');
        Route::get('/opencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@index')->name('opencloseperiode');
        Route::post('/getlistopencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@get_list');
        Route::get('/opencloseperiode/{opencloseperiode}', 'App\Http\Controllers\OpencloseperiodeController@show');
        Route::get('/createopencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@create');
        Route::post('/storeopencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@store');
        Route::get('/opencloseperiode/{opencloseperiode}/edit', 'App\Http\Controllers\OpencloseperiodeController@edit');
        Route::post('/getdataopencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@getdata');
        Route::post('/updateopencloseperiode/{opencloseperiode}', 'App\Http\Controllers\OpencloseperiodeController@update');
        Route::post('/deleteopencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@destroy');
        Route::post('/getoptionsopencloseperiode', 'App\Http\Controllers\OpencloseperiodeController@getoptions');

        Route::get('/fakultas', 'App\Http\Controllers\FakultasController@index')->name('fakultas');
        Route::post('/getlistfakultas', 'App\Http\Controllers\FakultasController@get_list');
        Route::get('/fakultas/{fakultas}', 'App\Http\Controllers\FakultasController@show');
        Route::get('/createfakultas', 'App\Http\Controllers\FakultasController@create');
        Route::post('/storefakultas', 'App\Http\Controllers\FakultasController@store');
        Route::get('/fakultas/{fakultas}/edit', 'App\Http\Controllers\FakultasController@edit');
        Route::post('/getdatafakultas', 'App\Http\Controllers\FakultasController@getdata');
        Route::post('/updatefakultas/{fakultas}', 'App\Http\Controllers\FakultasController@update');
        Route::post('/deletefakultas', 'App\Http\Controllers\FakultasController@destroy');

        Route::get('/prodi', 'App\Http\Controllers\ProdiController@index')->name('prodi');
        Route::post('/getlistprodi', 'App\Http\Controllers\ProdiController@get_list');
        Route::get('/prodi/{prodi}', 'App\Http\Controllers\ProdiController@show');
        Route::get('/createprodi', 'App\Http\Controllers\ProdiController@create');
        Route::post('/storeprodi', 'App\Http\Controllers\ProdiController@store');
        Route::get('/prodi/{prodi}/edit', 'App\Http\Controllers\ProdiController@edit');
        Route::post('/getdataprodi', 'App\Http\Controllers\ProdiController@getdata');
        Route::post('/updateprodi/{prodi}', 'App\Http\Controllers\ProdiController@update');
        Route::post('/deleteprodi', 'App\Http\Controllers\ProdiController@destroy');
        Route::post('/getlinksprodi', 'App\Http\Controllers\ProdiController@getlinks');
    });
});



