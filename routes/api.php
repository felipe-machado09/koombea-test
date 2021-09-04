<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Contact\ContactController;
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
        | Route Users Api
        |--------------------------------------------------------------------------
        */
        $router
        ->prefix('users')
        ->name('users.')
        ->group(function () use ($router) {
            $router->get('/', [UserController::class, 'index'])->name('index');
            $router->get('/{id}', [UserController::class, 'show'])->name('show');
            $router->post('/store', [UserController::class, 'store'])->name('store');
            $router->put('/update/{id}', [UserController::class, 'update'])->name('update');
            $router->delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | Route Contacts Api
        |--------------------------------------------------------------------------
        */
        $router
        ->prefix('contacts')
        ->name('contacts.')
        ->group(function () use ($router) {
            $router->get('/', [ContactController::class, 'index'])->name('index');
            $router->post('/store', [ContactController::class, 'store'])->name('store');
            $router->post('/import', [ContactController::class, 'import'])->name('import');

        });


    });

});

