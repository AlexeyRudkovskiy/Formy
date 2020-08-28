<?php


namespace Formy\Providers;


use Formy\Contracts\BaseFormBuilder;
use Formy\Contracts\FormBuilderContract;
use Illuminate\Support\ServiceProvider;

class FormyServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../assets/views', 'formy');

        $this->publishes([
            __DIR__ . '/../../assets/views' => resource_path('views/vendor/arudkovskiy')
        ]);
    }

    public function register()
    {
        $this->app->bind(FormBuilderContract::class, BaseFormBuilder::class);
    }

}
