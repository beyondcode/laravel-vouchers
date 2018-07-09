<?php

namespace BeyondCode\Vouchers;

use Illuminate\Support\ServiceProvider;

class VouchersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../translations', 'vouchers');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('vouchers.php'),
            ], 'config');


            if (! class_exists('CreateVouchersTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/create_vouchers_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_vouchers_table.php'),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__.'/../translations' => resource_path('lang/vendor/vouchers'),
            ], 'translations');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'vouchers');

        $this->app->singleton('vouchers', function ($app) {
            $generator = new VoucherGenerator(config('vouchers.characters'), config('vouchers.mask'));
            $generator->setPrefix(config('vouchers.prefix'));
            $generator->setSuffix(config('vouchers.suffix'));
            $generator->setSeparator(config('vouchers.separator'));
            return new Vouchers($generator);
        });
    }
}
