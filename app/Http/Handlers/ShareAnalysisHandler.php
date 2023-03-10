<?php

namespace App\Http\Handlers;

use App\Http\Requests\LintRequest;
use App\Http\Responses\ShareAnalysisResponse;
use App\Service\Analysis\AnalysisCreator;
use App\Service\Analysis\AnalysisPayload;
use Illuminate\Http\Request;

class ShareAnalysisHandler
{
    public function __construct(
        private AnalysisCreator $creator,
    ) {
        //
    }

    public function share(LintRequest $request): ShareAnalysisResponse
    {
        return new ShareAnalysisResponse($this->creator->create(
            new AnalysisPayload(
                $request->input('mergeRequest'),
                $request->input('config'),
            ),
        ));
    }
}
