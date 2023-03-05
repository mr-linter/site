<?php

namespace App\Models;

/**
 * @phpstan-type MergeRequestPayload array<string, mixed>
 * @phpstan-type ConfigPayload array<string, mixed>
 */
class Analysis
{
    /**
     * @param MergeRequestPayload $mergeRequest
     * @param ConfigPayload $config
     */
    public function __construct(
        public string $id,
        public array $mergeRequest,
        public array $config,
    ) {
        //
    }
}
