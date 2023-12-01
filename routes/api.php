<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('regions')->group(function () {

    Route::get('/', function () {
        if (Cache::has('regions')) {
            return response(["regions" => Cache::get('regions')], 200);
        }

        $data = Http::get('https://restcountries.com/v3.1/all');
        $response_code = $data->status();

        Cache::add('regions', $data?->collect()->pluck("region")->unique());
        return response(["regions" => $data?->collect()->pluck("region")->unique()], $response_code);
    })->name('regions');

    Route::get('{region}/countries', function (string $region) {

        if (Cache::has($region . '_countries')) {
            return response(["countries" => Cache::get(($region . '_countries'))], 200);
        }

        $data = Http::get('https://restcountries.com/v3.1/region/' . $region);
        $response_code = $data->status();
        $colect = $data->collect()->map(function ($item) {
            return [
                'name' => $item['name']['common'],
                'flags' => $item['flags']['svg'],
                'currencies' => isset($item['currencies']) ? array_values($item['currencies']) : [["name" => "", "symbol" => ""]]
            ];
        });

        Cache::add($region . '_countries', $colect);

        return response(["countries" => $colect], $response_code);
    })->name('regions.countries');
});
