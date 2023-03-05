<?php

namespace App\Service\Analysis;

/**
 * @phpstan-import-type MergeRequestPayload from \App\Models\Analysis
 * @phpstan-import-type ConfigPayload from \App\Models\Analysis
 */
class AnalysisPayload
{
    /**
     * @param MergeRequestPayload $mergeRequest
     * @param ConfigPayload $config
     */
    public function __construct(
        public array $mergeRequest,
        public array $config,
    ) {
        //
    }
}
