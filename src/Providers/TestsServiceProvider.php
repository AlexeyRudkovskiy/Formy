<?php


namespace Formy\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TestsServiceProvider extends ServiceProvider
{

    public function register()
    {
        Factory::guessFactoryNamesUsing(function ($modelName) {
            $modelName = \Str::after($modelName, 'Formy\\Tests\\Database\\Models\\');

            return 'Formy\\Tests\\Database\\factories\\' . $modelName . 'Factory';
        });

        Factory::guessModelNamesUsing(function ($factory) {
            $factoryBaseName = Str::replaceLast('Factory', '', class_basename($factory));
            return 'Formy\\Tests\\Database\\Models\\' . $factoryBaseName;
        });
    }

}
