<?php

namespace App\Http\Handlers;

use App\Http\Requests\LintRequest;
use App\Http\Responses\LintResponse;
use App\Service\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Version;

class LintHandler
{
    public function __construct(
        private Linter $linter,
    ) {
        //
    }

    public function handle(LintRequest $request): LintResponse
    {
        return new LintResponse(
            Version::VERSION,
            $this->linter->run($request->input('config'), $request->getMergeRequest()),
        );
    }
}
