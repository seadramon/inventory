<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipePcController;
use App\Http\Controllers\ItemPcController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MerkItController;
use App\Http\Controllers\MerkKantorController;
use App\Http\Controllers\InventarisItController;
use App\Http\Controllers\InventarisKantorController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\FormPerawatanItController;
use App\Http\Controllers\ItSoftwareController;
use App\Http\Controllers\PerawatanAssignController;
use App\Http\Middleware\EnsureSessionIsValid;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PerawatanListController;
use App\Http\Controllers\KantorNamaInventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IkDocumentController;

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

Route::middleware([EnsureSessionIsValid::class])->group(function () {
    Route::get('/', function () {
        // return view('layout.main');
        return redirect()->route('dashboard.dashboard-it');
    })->name('home');
    Route::get('ping', function () {
        dd(session()->all());
    })->name('ping');

    Route::group(['prefix' => 'master', 'as' => 'master.'], function(){
        //Tipe Perangkat
        Route::resource('tipe-pc', TipePcController::class)->except(['show', 'destroy']);
        Route::get('/tipe-pc/data', [TipePcController::class, 'data'])->name('tipe-pc.data');
        Route::post('/tipe-pc/destroy',	[TipePcController::class, 'destroy'])->name('tipe-pc.destroy');

        //Item PC
        Route::resource('item-pc', ItemPcController::class)->except(['show', 'destroy']);
        Route::get('/item-pc/data', [ItemPcController::class, 'data'])->name('item-pc.data');
        Route::post('/item-pc/destroy',	[ItemPcController::class, 'destroy'])->name('item-pc.destroy');

        //Jenis
        Route::resource('jenis', JenisController::class)->except(['show', 'destroy']);
        Route::get('/jenis/data', [JenisController::class, 'data'])->name('jenis.data');
        Route::post('/jenis/destroy',	[JenisController::class, 'destroy'])->name('jenis.destroy');

        Route::post('/ruangan/destroy', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
        Route::get('/ruangan/data', [RuanganController::class, 'data'])->name('ruangan.data');
        Route::resource('ruangan',  RuanganController::class)->except([
            'destroy'
        ]);

        Route::group(['prefix' => '/merk-kantor', 'as' => 'merk.kantor.'], function(){
            Route::post('/destroy', [MerkKantorController::class, 'destroy'])->name('destroy');
            Route::get('/data', [MerkKantorController::class, 'data'])->name('data');
            Route::resource('/',  MerkKantorController::class)->except([
                'destroy'
            ])->parameters(['' => 'merk-kantor']);
        });

        Route::group(['prefix' => '/merk-it', 'as' => 'merk.it.'], function(){
            Route::post('/destroy', [MerkItController::class, 'destroy'])->name('destroy');
            Route::get('/data', [MerkItController::class, 'data'])->name('data');
            Route::resource('/',  MerkItController::class)->except([
                'destroy'
            ])->parameters(['' => 'merk-it']);
        });

        Route::group(['prefix' => '/it-software', 'as' => 'it-software.'], function(){
            Route::post('/destroy', [ItSoftwareController::class, 'destroy'])->name('destroy');
            Route::get('/data', [ItSoftwareController::class, 'data'])->name('data');
            Route::resource('/',  ItSoftwareController::class)->except([
                'destroy'
            ])->parameters(['' => 'it-software']);
        });

        Route::group(['prefix' => '/kantor-nama-inventory', 'as' => 'kantor.nama.inventory.'], function(){
            Route::post('/destroy', [KantorNamaInventoryController::class, 'destroy'])->name('destroy');
            Route::get('/data', [KantorNamaInventoryController::class, 'data'])->name('data');
            Route::resource('/',  KantorNamaInventoryController::class)->except([
                'destroy'
            ])->parameters(['' => 'kni']);
        });

    });

    Route::group(['prefix' => '/maintenance-it', 'as' => 'maintenance-it.'], function(){
        Route::post('/destroy', [MaintenanceController::class, 'destroy'])->name('destroy');
        Route::get('/data', [MaintenanceController::class, 'data'])->name('data');
        Route::resource('/',  MaintenanceController::class)->except([
            'destroy'
        ])->parameters(['' => 'maintenance-it']);
    });

    Route::group(['prefix' => 'inventaris-it', 'as' => 'inventaris-it.'], function(){
        Route::resource('/', InventarisItController::class)->except(['show', 'destroy'])->parameters(['' => 'inventaris-it']);
        Route::get('/data', [InventarisItController::class, 'data'])->name('data');
        Route::get('/qrcode', [InventarisItController::class, 'qrcode'])->name('qrcode');
        Route::post('/qrcode', [InventarisItController::class, 'qrcodePdf'])->name('qrcode-pdf');
        Route::post('/destroy',	[InventarisItController::class, 'destroy'])->name('destroy');
        Route::post('/get-personal-data', [InventarisItController::class, 'getDataPersonal'])->name('get.personal.data');
    });

    Route::group(['prefix' => 'inventaris-it-detail', 'as' => 'inventaris-it-detail.'], function(){
        Route::get('{id}',      [InventarisItController::class, 'dataDetail'])->name('data');
        Route::post('/',        [InventarisItController::class, 'storeDetail'])->name('store');
        Route::post('/destroy', [InventarisItController::class, 'destroyDetail'])->name('destroy');
    });

    Route::group(['prefix' => 'inventaris-it-software', 'as' => 'inventaris-it-software.'], function(){
        Route::get('{id}',      [InventarisItController::class, 'dataSoftware'])->name('data');
        Route::post('/',        [InventarisItController::class, 'storeSoftware'])->name('store');
        Route::post('/destroy', [InventarisItController::class, 'destroySoftware'])->name('destroy');
    });

    Route::group(['prefix' => 'inventaris-kantor', 'as' => 'inventaris-kantor.'], function(){
        Route::resource('/', InventarisKantorController::class)->except(['show', 'destroy'])->parameters(['' => 'inventaris-kantor']);
        Route::get('/data', [InventarisKantorController::class, 'data'])->name('data');
        Route::get('/qrcode', [InventarisKantorController::class, 'qrcode'])->name('qrcode');
        Route::post('/qrcode', [InventarisKantorController::class, 'qrcodePdf'])->name('qrcode-pdf');
        Route::post('/destroy',	[InventarisKantorController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'form-perawatan-it', 'as' => 'form-perawatan-it.'], function(){
        Route::resource('/', FormPerawatanItController::class)->except(['show', 'destroy'])->parameters(['' => 'form-perawatan-it']);
        Route::get('/data', [FormPerawatanItController::class, 'data'])->name('data');
        Route::post('/destroy',	[FormPerawatanItController::class, 'destroy'])->name('destroy');
    });

    Route::controller(RoleController::class)->prefix('setting-akses-menu')->name('setting.akses.menu.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/setting/{id}', 'setting')->name('setting');
        Route::post('/update', 'update_setting')->name('update.setting');
        Route::post('/tree-data', 'tree_data')->name('tree.data');
        Route::get('/delete-setting/{id}', 'delete_setting')->name('delete.setting');
    });

    Route::group(['prefix' => 'perawatan-assign', 'as' => 'perawatan-assign.'], function(){
        Route::resource('/', PerawatanAssignController::class)->except(['destroy', 'show'])->parameters(['' => 'id']);
        Route::get('data', [PerawatanAssignController::class, 'data'])->name('data');
        Route::post('destroy',	[PerawatanAssignController::class, 'destroy'])->name('destroy');

        // Route::post('/destroy', [MaintenanceController::class, 'destroy'])->name('destroy');
        // Route::get('/data', [MaintenanceController::class, 'data'])->name('data');
        // Route::resource('/',  MaintenanceController::class)->except([
        //     'destroy'
        // ])->parameters(['' => 'maintenance-it']);
    });

    Route::controller(PerawatanListController::class)->prefix('perawatan')->name('perawatan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/view/{id}', 'view')->name('view');
    });
    
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function(){
        Route::get('/dashboard-it', [DashboardController::class, 'dashIt'])->name('dashboard-it');
    });

    Route::group(['prefix' => 'report', 'as' => 'report.'], function(){
        Route::get('/inventaris-kantor', [InventarisKantorController::class, 'report'])->name('inventaris-kantor');
        Route::post('/inventaris-kantor', [InventarisKantorController::class, 'reportExport'])->name('inventaris-kantor');

        Route::get('/inventaris-it', [InventarisItController::class, 'report'])->name('inventaris-it');
        Route::post('/inventaris-it', [InventarisItController::class, 'reportExport'])->name('inventaris-it');

        Route::get('/maintenance-it', [MaintenanceController::class, 'report'])->name('maintenance-it');
        Route::post('/maintenance-it', [MaintenanceController::class, 'reportExport'])->name('maintenance-it');
    });

    Route::post('/ikdocument/destroy',	[IkDocumentController::class, 'destroy'])->name('ikdocument.destroy');
	Route::get('/ikdocument/data',	[IkDocumentController::class, 'data'])->name('ikdocument.data');
	Route::resource('ikdocument',	IkDocumentController::class)->except([
		'destroy'
	]);
});