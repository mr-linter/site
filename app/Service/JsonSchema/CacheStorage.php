<?php

namespace App\Service\JsonSchema;

use Illuminate\Contracts\Cache\Repository;

class CacheStorage implements Storage
{
    public function __construct(
        private Repository $cache,
        private Storage $storage,
    ) {
        //
    }

    public function get(string $name): string
    {
        return $this->cache->rememberForever($this->createKey($name), function () use ($name) {
            return $this->storage->get($name);
        });
    }

    private function createKey(string $name): string
    {
        return sprintf('json_schema_%s', $name);
    }
}
