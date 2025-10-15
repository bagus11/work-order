<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Asset\MasterAssetController;
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
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('get_wo_summary', [HomeController::class, 'get_wo_summary']);
    Route::get('summaryAsset', [MasterAssetController::class, 'summaryAsset']);
    Route::get('woInProgress', [WorkOrderController::class, 'woInProgress']);
    Route::get('/woDetailById/{id}', [WorkOrderController::class, 'showById']);
    Route::post('/updateWO', [WorkOrderController::class, 'updateWO']);
    Route::get('/getActiveStockOpname', [StockOpnameController::class, 'getActiveStockOpname']);
    
    // StockOpname  
        Route::get('/getStockOpnameTicket', [StockOpnameController::class, 'getStockOpnameTicket']);
        Route::get('/stock-opname/detail', [StockOpnameController::class, 'stockOPnameDetail']);
        Route::get('/stockOpnameFilter', [StockOpnameController::class, 'stockOpnameFilter']);
        Route::post('/stock-opname/update-item', [StockOpnameController::class, 'stockOPnameUpdateItem']);


    // StockOpname
});