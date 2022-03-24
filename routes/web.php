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
 
Route::post('/send_otp','App\Http\Controllers\UserController@kirimemail');

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

        Route::get('/dashboard/dss', 'App\Http\Controllers\DashboardController@dss');
        Route::get('/dashboard/labarugi', 'App\Http\Controllers\DashboardController@labarugi');
        Route::get('/dashboard/neraca', 'App\Http\Controllers\DashboardController@neraca');
        Route::get('/dashboard/labarugi/chart', 'App\Http\Controllers\DashboardController@labarugichart'); 
        Route::get('/dashboard/neraca/chart', 'App\Http\Controllers\DashboardController@neracachart'); 
        Route::get('/dashboard/neracasaldo/chart', 'App\Http\Controllers\DashboardController@neracasaldochart');        
        Route::get('/dashboard/fuzzy', 'App\Http\Controllers\DashboardController@fuzzy');
        Route::post('/dashboard/get_list', 'App\Http\Controllers\DashboardController@get_list');
        Route::post('/dashboard/get_list_two_month', 'App\Http\Controllers\DashboardController@get_list_two_month');
        Route::post('/dashboard/get_transaction', 'App\Http\Controllers\DashboardController@get_transaction');
        Route::post('/dashboard/get_data_fuzzy', 'App\Http\Controllers\DashboardController@get_data_fuzzy');
        Route::get('/dashboard/roa', 'App\Http\Controllers\DashboardController@roa');
        Route::get('/dashboard/roe', 'App\Http\Controllers\DashboardController@roe');
        Route::get('/dashboard/roi', 'App\Http\Controllers\DashboardController@roi');
        Route::post('/dashboard/klasifikasi', 'App\Http\Controllers\DashboardController@klasifikasi');
        Route::get('/dashboard/analisis', 'App\Http\Controllers\DashboardController@analisis');
        Route::get('/dashboard/forecast', 'App\Http\Controllers\DashboardController@forecast');
        Route::post('/dashboard/get_forecast', 'App\Http\Controllers\DashboardController@get_forecast');
        Route::post('/dashboard/get_3month', 'App\Http\Controllers\DashboardController@get_3month');
        
        Route::get('/user', 'App\Http\Controllers\UserController@index')->name('user');
        Route::post('/getlistuser', 'App\Http\Controllers\UserController@get_list');
        Route::get('/user/{user}', 'App\Http\Controllers\UserController@show');
        Route::get('/createuser', 'App\Http\Controllers\UserController@create');
        Route::post('/storeuser', 'App\Http\Controllers\UserController@store');
        Route::get('/user/{user}/edit', 'App\Http\Controllers\UserController@edit');
        Route::post('/getdatauser', 'App\Http\Controllers\UserController@getdata');
        Route::post('/getoptionsuser', 'App\Http\Controllers\UserController@getoptions');
        Route::post('/getoptionsuserrole', 'App\Http\Controllers\UserController@getoptions');
        Route::post('/updateuser/{user}', 'App\Http\Controllers\UserController@update');
        Route::post('/deleteuser', 'App\Http\Controllers\UserController@destroy');
        Route::post('/getlinksuser', 'App\Http\Controllers\UserController@getlinks');
        Route::post('/uploadfileuser', 'App\Http\Controllers\UserController@storeUploadFile');
        Route::get('/assignmenu/{user}/edit', 'App\Http\Controllers\UserController@assignmenu');
        Route::post('/assignmenu/{user}', 'App\Http\Controllers\UserController@update_assignmenu');
        Route::post('/getdataassignmenuuser', 'App\Http\Controllers\UserController@getdataassignmenuuser');
        Route::post('/updateassignmenuuser/{user}', 'App\Http\Controllers\UserController@updateassignmenu');
        Route::get('/change_password/{id}', 'App\Http\Controllers\UserController@change_password');
        Route::post('/update_password/{id}', 'App\Http\Controllers\UserController@update_password');
        

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

        Route::get('/role', 'App\Http\Controllers\RoleController@index')->name('role');
        Route::post('/getlistrole', 'App\Http\Controllers\RoleController@get_list');
        Route::get('/role/{role}', 'App\Http\Controllers\RoleController@show');
        Route::get('/createrole', 'App\Http\Controllers\RoleController@create');
        Route::post('/storerole', 'App\Http\Controllers\RoleController@store');
        Route::get('/role/{role}/edit', 'App\Http\Controllers\RoleController@edit');
        Route::post('/getdatarole', 'App\Http\Controllers\RoleController@getdata');
        Route::post('/updaterole/{role}', 'App\Http\Controllers\RoleController@update');
        Route::post('/deleterole', 'App\Http\Controllers\RoleController@destroy');
        Route::post('/getdataassignmenurole', 'App\Http\Controllers\RoleController@getdataassignmenurole');
        Route::post('/updateassignmenurole/{role}', 'App\Http\Controllers\RoleController@updateassignmenu');
        Route::get('/assignmenurole/{role}/edit', 'App\Http\Controllers\RoleController@assignmenu');
        Route::get('/getrolemenu', 'App\Http\Controllers\RoleController@getRoleMenu');


        Route::get('/kebijakan', 'App\Http\Controllers\KebijakanController@index')->name('kebijakan');
        Route::post('/getlistkebijakan', 'App\Http\Controllers\KebijakanController@get_list');
        Route::get('/kebijakan/{kebijakan}', 'App\Http\Controllers\KebijakanController@show');
        Route::get('/createkebijakan', 'App\Http\Controllers\KebijakanController@create');
        Route::post('/storekebijakan', 'App\Http\Controllers\KebijakanController@store');
        Route::get('/kebijakan/{kebijakan}/edit', 'App\Http\Controllers\KebijakanController@edit');
        Route::post('/getdatakebijakan', 'App\Http\Controllers\KebijakanController@getdata');
        Route::post('/updatekebijakan/{kebijakan}', 'App\Http\Controllers\KebijakanController@update');
        Route::post('/deletekebijakan', 'App\Http\Controllers\KebijakanController@destroy');

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
        Route::post('/getlinksneracasaldo', 'App\Http\Controllers\NeracasaldoController@getlinks');
        Route::post('/getlistneracasaldo', 'App\Http\Controllers\NeracasaldoController@get_list');
        Route::post('/neracasaldo/print', 'App\Http\Controllers\NeracasaldoController@print');
        Route::post('/neracasaldo/excel', 'App\Http\Controllers\NeracasaldoController@excel');
        
        Route::get('/neraca', 'App\Http\Controllers\NeracaController@index')->name('neraca');
        Route::post('/getlinksneraca', 'App\Http\Controllers\NeracaController@getlinks');
        Route::post('/getlistneraca', 'App\Http\Controllers\NeracaController@get_list');
        Route::post('/neraca/print', 'App\Http\Controllers\NeracaController@print');
        Route::post('/neraca/excel', 'App\Http\Controllers\NeracaController@excel');
        
        Route::get('/labarugi', 'App\Http\Controllers\LabarugiController@index')->name('labarugi');
        Route::post('/getlinkslabarugi', 'App\Http\Controllers\LabarugiController@getlinks');
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

        Route::get('/aruskas', 'App\Http\Controllers\AruskasController@index')->name('aruskas');
        Route::post('/getlistaruskas', 'App\Http\Controllers\AruskasController@get_list');
        Route::post('/getlinksaruskas', 'App\Http\Controllers\AruskasController@getlinks');
        Route::post('/getsaldoawalaruskas', 'App\Http\Controllers\AruskasController@get_saldo_awal');
        Route::post('/aruskas/print', 'App\Http\Controllers\AruskasController@print');
        Route::post('/get_saldo_awalaruskas', 'App\Http\Controllers\AruskasController@get_saldo_awal');
        Route::post('/aruskas/excel', 'App\Http\Controllers\AruskasController@excel');
        Route::get('/forecast', 'App\Http\Controllers\AruskasController@forecast');
        Route::get('/total-forecast', 'App\Http\Controllers\AruskasController@get_total_forecast');
        Route::post('/get_forecast', 'App\Http\Controllers\AruskasController@get_forecast');

        Route::get('/iku', 'App\Http\Controllers\IkuunitkerjaController@index')->name('iku');
        Route::get('/createiku', 'App\Http\Controllers\IkuunitkerjaController@create');
        Route::post('/storeiku', 'App\Http\Controllers\IkuunitkerjaController@store');
        Route::post('/getlistiku', 'App\Http\Controllers\IkuunitkerjaController@get_list');
        Route::post('/getdataiku', 'App\Http\Controllers\IkuunitkerjaController@getdata');
        Route::post('/updateiku/{iku}', 'App\Http\Controllers\IkuunitkerjaController@update');
        Route::post('/deleteiku', 'App\Http\Controllers\IkuunitkerjaController@destroy');
        Route::post('/getoptionsiku', 'App\Http\Controllers\IkuunitkerjaController@getoptions');
        Route::post('/getlinksiku', 'App\Http\Controllers\IkuunitkerjaController@getlinks');
        Route::get('/iku/{iku}', 'App\Http\Controllers\IkuunitkerjaController@show');
        Route::get('/iku/{iku}/edit', 'App\Http\Controllers\IkuunitkerjaController@edit');
        
        
        Route::get('/iku/laporan', 'App\Http\Controllers\IkuunitkerjaController@laporan');
        Route::post('/getlistikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@get_list');
        Route::get('/ikuunitkerja/{ikuunitkerja}', 'App\Http\Controllers\IkuunitkerjaController@show');
        Route::get('/createikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@create');
        Route::post('/storeikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@store');
        Route::get('/ikuunitkerja/{ikuunitkerja}/edit', 'App\Http\Controllers\IkuunitkerjaController@edit');
        Route::post('/getdataikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getdata');
        Route::post('/updateikuunitkerja/{ikuunitkerja}', 'App\Http\Controllers\IkuunitkerjaController@update');
        Route::post('/deleteikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@destroy');
        Route::post('/getoptionsikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getoptions');
        Route::post('/getlinksikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getlinks');
        Route::post('/uploadfileikuunitkerja', 'App\Http\Controllers\IkuunitkerjaController@storeUploadFile');

        Route::get('/iktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@indexikt')->name('iktunitkerja');
        Route::post('/getlistiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@get_list');
        Route::get('/iktunitkerja/{iktunitkerja}', 'App\Http\Controllers\IkuunitkerjaController@showikt');
        Route::get('/createiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@createikt');
        Route::post('/storeiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@storeikt');
        Route::get('/iktunitkerja/{iktunitkerja}/edit', 'App\Http\Controllers\IkuunitkerjaController@editikt');
        Route::post('/getdataiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getdata');
        Route::post('/updateiktunitkerja/{iktunitkerja}', 'App\Http\Controllers\IkuunitkerjaController@updateikt');
        Route::post('/deleteiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@destroy');
        Route::post('/getoptionsiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getoptions');
        Route::post('/getlinksiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getlinks');
        Route::post('/uploadfileiktunitkerja', 'App\Http\Controllers\IkuunitkerjaController@storeUploadFile');

        Route::get('/sikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@indexikt')->name('sikunitkerja');
        Route::post('/getlistsikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@get_list');
        Route::get('/sikunitkerja/{iktunitkerja}', 'App\Http\Controllers\IkuunitkerjaController@showsik');
        Route::get('/createsikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@createsik');
        Route::post('/storesikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@storesik');
        Route::get('/sikunitkerja/{iktunitkerja}/edit', 'App\Http\Controllers\IkuunitkerjaController@editsik');
        Route::post('/getdatasikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getdata');
        Route::post('/updatesikunitkerja/{iktunitkerja}', 'App\Http\Controllers\IkuunitkerjaController@updatesik');
        Route::post('/deletesikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@destroy');
        Route::post('/getoptionssikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getoptions');
        Route::post('/getlinksikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@getlinks');
        Route::post('/uploadfilesikunitkerja', 'App\Http\Controllers\IkuunitkerjaController@storeUploadFile');

        Route::get('/pengajuan', 'App\Http\Controllers\KegiatanController@pengajuan');
        Route::get('/pengajuan/{kegiatan}/edit', 'App\Http\Controllers\KegiatanController@edit_pengajuan');
        Route::post('/getlistpengajuan', 'App\Http\Controllers\KegiatanController@get_list_pengajuan');
        Route::post('/getoptionspengajuan', 'App\Http\Controllers\KegiatanController@getoptions');
        Route::post('/getdatapengajuan', 'App\Http\Controllers\KegiatanController@getdata_pengajuan');
        Route::post('/getlinkspengajuan', 'App\Http\Controllers\KegiatanController@getlinks');
        Route::post('/updatepengajuan/{kegiatan}', 'App\Http\Controllers\KegiatanController@update_pengajuan');
        Route::get('/pengajuan/{kegiatan}', 'App\Http\Controllers\KegiatanController@show_pengajuan');
        Route::post('/processapprovepengajuan', 'App\Http\Controllers\KegiatanController@processapprove_pengajuan');
        
        Route::get('/pertanggungjawaban', 'App\Http\Controllers\KegiatanController@pertanggungjawaban');
        Route::post('/getlistpertanggungjawaban', 'App\Http\Controllers\KegiatanController@get_list_pertanggungjawaban');
        
        Route::get('/kegiatan/laporan', 'App\Http\Controllers\KegiatanController@laporan');     
        Route::post('/kegiatan/laporan/print', 'App\Http\Controllers\KegiatanController@print');        
        Route::post('/getlistlaporan/{jenis}', 'App\Http\Controllers\KegiatanController@get_list_laporan');
        Route::get('/pengajuan-laporan', 'App\Http\Controllers\KegiatanController@laporan_pengajuan');        
        Route::get('/pencairan-laporan', 'App\Http\Controllers\KegiatanController@laporan_pencairan');                
        Route::get('/pertanggungjawaban-laporan', 'App\Http\Controllers\KegiatanController@laporan_pertanggungjawaban');        
        

        Route::get('/kegiatan', 'App\Http\Controllers\KegiatanController@index')->name('kegiatan');
        Route::post('/getlistkegiatan', 'App\Http\Controllers\KegiatanController@get_list_rka');
        Route::get('/kegiatan/{kegiatan}', 'App\Http\Controllers\KegiatanController@show');
        Route::get('/createkegiatan', 'App\Http\Controllers\KegiatanController@create');
        Route::post('/storekegiatan', 'App\Http\Controllers\KegiatanController@store');
        Route::get('/kegiatan/{kegiatan}/edit', 'App\Http\Controllers\KegiatanController@edit');
        Route::post('/getdatakegiatan', 'App\Http\Controllers\KegiatanController@getdata');
        Route::post('/updatekegiatan/{kegiatan}', 'App\Http\Controllers\KegiatanController@update');
        Route::post('/deletekegiatan', 'App\Http\Controllers\KegiatanController@destroy');
        Route::post('/getoptionskegiatan', 'App\Http\Controllers\KegiatanController@getoptions');
        Route::post('/getlinkskegiatan', 'App\Http\Controllers\KegiatanController@getlinks');
        Route::post('/uploadfilekegiatan', 'App\Http\Controllers\KegiatanController@storeUploadFile');
        Route::post('/processapprove', 'App\Http\Controllers\KegiatanController@processapprove');
        Route::post('/getdatakegiatanhistory', 'App\Http\Controllers\KegiatanController@getdatahistory');
        Route::post('/getdatapjkhistory', 'App\Http\Controllers\KegiatanController@getdatahistorypjk');
        Route::get('/persetujuankegiatan', 'App\Http\Controllers\KegiatanController@persetujuankegiatan');
        Route::post('/getlistpersetujuankegiatan', 'App\Http\Controllers\KegiatanController@get_list_persetujuankegiatan');
        Route::post('/getdatakegiatanplafon', 'App\Http\Controllers\KegiatanController@getdatakegiatanplafon');
        Route::post('/getdatadetailkegiatan', 'App\Http\Controllers\KegiatanController@getdatadetailkegiatan');

        Route::get('/pjk/{kegiatan}/edit', 'App\Http\Controllers\KegiatanController@createpjk');
        Route::post('/storepjk', 'App\Http\Controllers\KegiatanController@storepjk');
        Route::post('/updatepjk/{kegiatan}', 'App\Http\Controllers\KegiatanController@updatepjk');
        Route::get('/pjk/{kegiatan}', 'App\Http\Controllers\KegiatanController@showpjk');
        Route::post('/processapprovepjk', 'App\Http\Controllers\JurnalController@processapprovepjk');
        Route::post('/getdatapjk', 'App\Http\Controllers\KegiatanController@getdatapjk');

        Route::get('/pencairan', 'App\Http\Controllers\PencairanController@index');
        Route::post('/getlistpencairan', 'App\Http\Controllers\PencairanController@get_list');
        Route::get('/createpencairan', 'App\Http\Controllers\PencairanController@create');
        Route::post('/getlinkspencairan', 'App\Http\Controllers\PencairanController@getlinks');
        Route::post('/getbiayakegiatan', 'App\Http\Controllers\PencairanController@getbiayakegiatan');
        Route::post('/getlistrka', 'App\Http\Controllers\PencairanController@getlistrka');
        Route::post('/storepencairan', 'App\Http\Controllers\JurnalController@storepencairan');
        Route::post('/deletepencairan', 'App\Http\Controllers\PencairanController@destroy');
        Route::get('/pencairan/{pencairan}', 'App\Http\Controllers\PencairanController@show');
        Route::post('/getdatapencairan', 'App\Http\Controllers\PencairanController@getdata');

        Route::get('/settingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@index')->name('settingpagupendapatan');
        Route::post('/getlistsettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@get_list');
        Route::get('/settingpagupendapatan/{settingpagupendapatan}', 'App\Http\Controllers\SettingpagupendapatanController@show');
        Route::get('/createsettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@create');
        Route::post('/storesettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@store');
        Route::get('/settingpagupendapatan/{settingpagupendapatan}/edit', 'App\Http\Controllers\SettingpagupendapatanController@edit');
        Route::post('/getdatasettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@getdata');
        Route::post('/updatesettingpagupendapatan/{settingpagupendapatan}', 'App\Http\Controllers\SettingpagupendapatanController@update');
        Route::post('/deletesettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@destroy');
        Route::post('/getlinkssettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@getlinks');
        Route::post('/getoptionssettingpagupendapatan', 'App\Http\Controllers\SettingpagupendapatanController@getoptions');

        Route::get('/satuan', 'App\Http\Controllers\SatuanController@index')->name('satuan');
        Route::post('/getlistsatuan', 'App\Http\Controllers\SatuanController@get_list');
        Route::get('/satuan/{satuan}', 'App\Http\Controllers\SatuanController@show');
        Route::get('/createsatuan', 'App\Http\Controllers\SatuanController@create');
        Route::post('/storesatuan', 'App\Http\Controllers\SatuanController@store');
        Route::get('/satuan/{satuan}/edit', 'App\Http\Controllers\SatuanController@edit');
        Route::post('/getdatasatuan', 'App\Http\Controllers\SatuanController@getdata');
        Route::post('/updatesatuan/{satuan}', 'App\Http\Controllers\SatuanController@update');
        Route::post('/deletesatuan', 'App\Http\Controllers\SatuanController@destroy');
        Route::post('/getoptionssatuan', 'App\Http\Controllers\SatuanController@getoptions');

        Route::get('/programkerja', 'App\Http\Controllers\ProgramkerjaController@index')->name('programkerja');
        Route::post('/getlistprogramkerja', 'App\Http\Controllers\ProgramkerjaController@get_list');
        Route::get('/programkerja/{programkerja}', 'App\Http\Controllers\ProgramkerjaController@show');
        Route::get('/createprogramkerja', 'App\Http\Controllers\ProgramkerjaController@create');
        Route::post('/storeprogramkerja', 'App\Http\Controllers\ProgramkerjaController@store');
        Route::get('/programkerja/{programkerja}/edit', 'App\Http\Controllers\ProgramkerjaController@edit');
        Route::post('/getdataprogramkerja', 'App\Http\Controllers\ProgramkerjaController@getdata');
        Route::post('/updateprogramkerja/{programkerja}', 'App\Http\Controllers\ProgramkerjaController@update');
        Route::post('/deleteprogramkerja', 'App\Http\Controllers\ProgramkerjaController@destroy');
        Route::post('/getlinksprogramkerja', 'App\Http\Controllers\ProgramkerjaController@getlinks');
    });
});



