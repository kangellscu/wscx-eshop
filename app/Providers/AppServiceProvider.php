<?php

namespace App\Providers;

use Ramsey\Uuid\Uuid;
use Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendValidator();
        $this->schemaModifier();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function schemaModifier()
    {
        Schema::defaultStringLength(191);
    }

    private function extendValidator()
    {
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            $len = strlen($value);
            return $len >= 4 && $len <= 16;
        });

        Validator::extend('uuid', function ($attribute, $value, $parameters, $validator) {
            return empty($value) || Uuid::isValid($value);
        });

        // client serial_no, unique
        Validator::extend('serial_no', function ($attribute, $value, $parameters, $validator) {
            $pattern = '/^[A-Z]\d{3,5}$/';
            return empty($value) || preg_match($pattern, $value);
        });
    }
}
