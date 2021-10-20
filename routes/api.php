<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\Representation\RepresentationController;
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
$router = app(Router::class);

$router->group(['prefix'=>'v1','as'=>'v1.'], function() use ($router){
    $router->post('/auth/register', [AuthController::class, 'register'])->name('register');

    $router->post('/auth/login', [AuthController::class, 'login'])->name('login');

    $router->group(['middleware' => ['auth:sanctum']], function () use ($router) {
        $router->get('/me', function(Request $request) {
            return auth()->user();
        })->name('me');;

        $router->post('/auth/logout', [AuthController::class, 'logout'])->name('logout');



        /*
        |--------------------------------------------------------------------------
        | Route Contacts Api
        |--------------------------------------------------------------------------
        */
        $router
        ->prefix('representation')
        ->name('representation.')
        ->group(function () use ($router) {
            $router->get('/', [RepresentationController::class, 'index'])->name('index');
        });


    });

});

