<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Asset\DistributionAssetController;
use App\Http\Controllers\Asset\MasterAssetController;
use App\Http\Controllers\Asset\ServiceAssetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\WorkOrderController;
use App\Models\StockOpnameHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/save-fcm-token', [AuthController::class, 'saveFcmToken']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/getNotification', [HomeController::class, 'getNotification']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('get_wo_summary', [HomeController::class, 'get_wo_summary']);
    Route::get('summaryAsset', [MasterAssetController::class, 'summaryAsset']);
    Route::get('woInProgress', [WorkOrderController::class, 'woInProgress']);
    Route::post('updateNotif', [HomeController::class, 'updateNotif']);
    Route::get('/woDetailById/{id}', [WorkOrderController::class, 'showById']);
    Route::post('/updateWO', [WorkOrderController::class, 'approve_assignment_pic']);
    Route::get('/getActiveStockOpname', [StockOpnameController::class, 'getActiveStockOpname']);
    
    // StockOpname  
        Route::get('/getStockOpnameTicket', [StockOpnameController::class, 'getStockOpnameTicket']);
        Route::get('/stock-opname/detail', [StockOpnameController::class, 'stockOPnameDetail']);
        Route::get('/stock-opname/assign', [StockOpnameController::class, 'stockOPnameAssign']);
        Route::get('/stockOpnameFilter', [StockOpnameController::class, 'stockOpnameFilter']);
        Route::post('/stock-opname/update-item', [StockOpnameController::class, 'stockOPnameUpdateItem']);
        Route::post('/stock-opname/assign', [StockOpnameController::class, 'approveSO']);
        Route::post('/stock-opname/checking', [StockOpnameController::class, 'stockOpnameChecking']);
    // StockOpname
        
    // Aset Service    
        Route::get('/service', [ServiceAssetController::class, 'getServiceTicket']);
        Route::get('/service/request_code', [ServiceAssetController::class, 'getRequestCode']);
        Route::get('/service/detail', [ServiceAssetController::class, 'detailServiceTicket']);
        Route::post('/service/add-ticket', [ServiceAssetController::class, 'addService']);
        Route::get('/detail-request_code', [ServiceAssetController::class, 'detailRequestCode']);
        Route::post('/service/start', [ServiceAssetController::class, 'startService']);
        Route::post('/service/update', [ServiceAssetController::class, 'updateService']);
    // Aset Service

    // Asset Distribution
        Route::get('/distribution', [DistributionAssetController::class, 'getDistributionTicket']);
        Route::get('/distribution/{id}', [DistributionAssetController::class, 'detailDistributionTicket']);
    
    // Asset Distribution
        
    // Master Asset
        Route::get('/master-assets/{id}', [MasterAssetController::class, 'show']);
        Route::get('/mappingAssetChild', [MasterAssetController::class, 'mappingAssetChild']);
    // Master Asset
});