<?php

use App\Http\Controllers\Api\ControlController;
use App\Http\Controllers\Api\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\InventarisController;
use App\Http\Controllers\Api\MaintenanceItController;
use App\Http\Controllers\Api\FormPerawatanController;
use App\Http\Controllers\Api\PerawatanController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->namespace('Api')->group(function() {
    Route::get('viewer/{path}', [FileController::class, 'viewer'])->name('file.viewer');

	Route::get('inventaris-it/{code}', 	[InventarisController::class, 'itDetail']);

	Route::get('inventaris-kantor/{code}', 	[InventarisController::class, 'officeDetail']);

	Route::post('maintenance-it', [MaintenanceItController::class, 'store']);

	Route::post('kontrol-inventeris-kantor', [ControlController::class, 'store']);

	Route::get('form-perawatan/{kd_pat}', [FormPerawatanController::class, 'index']);

	Route::post('perawatan', [PerawatanController::class, 'store']);

	Route::prefix('dashboard')->group(function() {
		Route::get('/it-inventaris/{kdwil}', [DashboardController::class, 'itInventaris'])->name('dashboard.it-inventaris');
		Route::get('/software/{kdwil}', [DashboardController::class, 'software'])->name('dashboard.software');
	});
});
