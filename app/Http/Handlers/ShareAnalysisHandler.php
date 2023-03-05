<?php

namespace App\Http\Handlers;

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

    public function share(Request $request): ShareAnalysisResponse
    {
        return new ShareAnalysisResponse($this->creator->create(
            new AnalysisPayload(
                $request->input('merge_request'),
                $request->input('config'),
            ),
        ));
    }
}
