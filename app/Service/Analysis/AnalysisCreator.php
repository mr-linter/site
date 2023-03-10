<?php

namespace App\Service\Analysis;

use App\Models\Analysis;
use App\Repositories\AnalysisRepository;
use Illuminate\Validation\Rule;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Nonstandard\Uuid;

class AnalysisCreator
{
    public function __construct(
        private AnalysisRepository $repository,
        private LoggerInterface $logger,
    ) {
        //
    }

    public function create(AnalysisPayload $payload): Analysis
    {
        $this->logger->info('[AnalysisCreator] Start analysis creating');

        $analysis = $this->make($payload);

        $this->repository->save($analysis);

        $this->logger->info(sprintf('[AnalysisCreator] Analysis with id "%s" was created', $analysis->id));

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
