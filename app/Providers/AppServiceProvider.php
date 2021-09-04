<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // Binding Auth
        $this->app->bind(
            \App\Repositories\Auth\AuthRepositoryInterface::class,
            \App\Repositories\Auth\AuthRepositoryEloquent::class,
        );

        // Binding Users
        $this->app->bind(
            \App\Repositories\Users\UsersRepositoryInterface::class,
            \App\Repositories\Users\UsersRepositoryEloquent::class,
        );

        // Binding Contact
        $this->app->bind(
            \App\Repositories\Contacts\ContactsRepositoryInterface::class,
            \App\Repositories\Contacts\ContactsRepositoryEloquent::class,
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
