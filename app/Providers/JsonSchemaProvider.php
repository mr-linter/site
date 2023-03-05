<?php

namespace App\Providers;

use App\Http\Validators\JsonSchemaRule;
use App\Http\Validators\JsonSchemaValidator;
use App\Service\JsonSchema\CacheStorage;
use App\Service\JsonSchema\FileStorage;
use App\Service\JsonSchema\Storage;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class JsonSchemaProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CacheStorage::class);

        $this
            ->app
            ->when(CacheStorage::class)
            ->needs(Storage::class)
            ->give(FileStorage::class);

        $this
            ->app
            ->when(CacheStorage::class)
            ->needs(Repository::class)
            ->give(static function () {
                return Cache::store('array');
            });

        $this
            ->app
            ->when(FileStorage::class)
            ->needs(Filesystem::class)
            ->give(static function () {
                return \Illuminate\Support\Facades\Storage::disk('json_schemas');
            });

        $this->app->bind(Storage::class, CacheStorage::class);
    }
}
