<?php

use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/logmeout', function (Request $request) {
    Log::alert('nhan api tu serve');

    $user =  $request->user();
    $accessToken = $user->token();
    DB::table('oauth_refresh_tokens')
    ->where('access_token_id', $accessToken->id)
    ->delete();

    DB::table('session_server')
    ->where('user_id', $user->id)
    ->delete();
    $user->token()->delete();

    return response()->json([
        'message' => 'Successfully logged out',
    ]);
});
