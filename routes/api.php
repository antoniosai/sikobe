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

        // Area routes
        $api->get(
            'areas', 
            'App\Http\Controllers\Api\v1\Area@getAll'
        );
        $api->get(
            'areas/{id}/photos', 
            'App\Http\Controllers\Api\v1\Area@getPhotos'
        );
        $api->get(
            'areas/{id}/statuses', 
            'App\Http\Controllers\Api\v1\Area@getAllStatuses'
        );
        $api->get(
            'area-statuses', 
            'App\Http\Controllers\Api\v1\Area@getAllStatuses'
        );

        // Command Post routes
        $api->get(
            'command-posts', 
            'App\Http\Controllers\Api\v1\CommandPost@getAll'
        );
        $api->get(
            'command-posts/{id}/photos', 
            'App\Http\Controllers\Api\v1\CommandPost@getPhotos'
        );

    });

});
