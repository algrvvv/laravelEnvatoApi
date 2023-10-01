<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\CustomerController;

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

// метод из видео (год назад)
// Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
//     Route::apiResources([
//         '/customers' => CustomerController::class,
//         '/invoices' => InvoiceController::class
//     ]);
// });

// более современный метод
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        '/customers' => CustomerController::class,
        '/invoices' => InvoiceController::class
    ]);

    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
});