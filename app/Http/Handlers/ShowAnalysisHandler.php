<?php

namespace App\Http\Handlers;

use App\Http\Responses\LintResponse;
use App\Http\Responses\ShowAnalysisResponse;
use App\Repositories\AnalysisRepository;
use App\Service\Linter\Linter;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ArtARTs36\MergeRequestLinter\Version;

class ShowAnalysisHandler
{
    public function __construct(
        private AnalysisRepository $analyses,
        private Linter $linter,
    ) {
        //
    }

    public function show(string $id): ShowAnalysisResponse|Response
    {
        $analysis = $this->analyses->find($id);

        if ($analysis === null) {
            return new Response('Analysis not found', 404);
        }

        $result = $this->linter->run(
            $analysis->config,
            $analysis->mergeRequest,
        );

        return new ShowAnalysisResponse($analysis, new LintResponse(Version::VERSION, $result));
    }
}
