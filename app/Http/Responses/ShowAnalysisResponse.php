<?php

namespace App\Http\Responses;

use App\Models\Analysis;
use Illuminate\Contracts\Support\Arrayable;

class ShowAnalysisResponse implements Arrayable
{
    public function __construct(
        private Analysis $analysis,
        private LintResponse $lintResponse,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'analysis' => [
                'merge_request' => $this->analysis->mergeRequest,
                'config' => $this->analysis->config,
            ],
            'result' => $this->lintResponse->toArray(),
        ];
    }
}
