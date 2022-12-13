<?php

namespace App\Service\Linter;

use ArtARTs36\MergeRequestLinter\Configuration\Loader\RulesMapper;
use ArtARTs36\MergeRequestLinter\Linter\Event\NullLintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Linter\Linter as MrLinter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Linter\Runner\Runner;
use ArtARTs36\MergeRequestLinter\Linter\StaticMergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class Linter
{
    public function __construct(
        private RulesMapper $rulesMapper,
    ) {
        //
    }

    public function run(array $configData, array $mergeRequest): LintResult
    {
        $linter = new MrLinter($this->rulesMapper->map($configData['rules']), new NullLintEventSubscriber());

        $runner = new Runner(new StaticMergeRequestFetcher(MergeRequest::fromArray($mergeRequest)));

        return $runner->run($linter);
    }
}
