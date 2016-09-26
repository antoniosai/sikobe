<?php

// use Illuminate\Http\Request;

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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'middleware' => 'api.throttle', 
    'limit' => 500, 
    'expires' => 1
], function ($api) {

    $api->group(['middleware' => 'api.auth'], function ($api) {

        $api->get('refresh_token', [
            'middleware' => 'jwt.refresh', 
            'uses' => 'App\Http\Controllers\Api\Token@refreshToken'
        ]);

        // Information routes
        $api->get(
            'informations', 
            'App\Http\Controllers\Api\v1\Information@getAll'
        );

    });

});
