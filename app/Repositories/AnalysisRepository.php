<?php

namespace App\Repositories;

use App\Models\Analysis;
use Illuminate\Cache\RedisStore;

class AnalysisRepository
{
    public function __construct(
        private RedisStore $redis,
    ) {
        //
    }

    public function find(string $id): ?Analysis
    {
        return $this->redis->get($this->createIdKey($id));
    }

    public function save(Analysis $analysis): void
    {
        $this
            ->redis
            ->connection()
            ->client()
            ->set($this->createIdKey($analysis->id), $this->serialize($analysis));
    }

    private function serialize(Analysis $analysis): string
    {
        return serialize($analysis);
    }

    private function createIdKey(string $id): string
    {
        return 'analysis_' . $id;
    }
}
