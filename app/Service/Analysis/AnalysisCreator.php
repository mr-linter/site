<?php

namespace App\Service\Analysis;

use App\Models\Analysis;
use App\Repositories\AnalysisRepository;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Nonstandard\Uuid;

class AnalysisCreator
{
    public function __construct(
        private AnalysisRepository $repository,
    ) {
        //
    }

    public function create(AnalysisPayload $payload): Analysis
    {
        $analysis = $this->make($payload);

        $this->repository->save($analysis);

        return $analysis;
    }

    private function make(AnalysisPayload $payload): Analysis
    {
        return new Analysis(
            Uuid::uuid4()->toString(),
            $payload->mergeRequest,
            $payload->config,
        );
    }
}
