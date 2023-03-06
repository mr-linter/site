<?php

namespace App\Service\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\RulesMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class Linter
{
    public function __construct(
        private RulesMapper $rulesMapper,
        private LinterFactory $factory,
        private MergeRequestFactory $requestFactory,
        private LoggerInterface $logger,
    ) {
        //
    }

    public function run(array $configData, array $mergeRequest): LintResult
    {
        $linter = $this->factory->create($this->rulesMapper->map($configData['rules']));

        $this->logger->info('linter started');

        $runner = new Runner(new MemoryRequestFetcher(
            $this->requestFactory->create($mergeRequest),
        ));

        try {
            $result = $runner->run($linter);

            $this->logger->info('linter finished');

            return $result;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf(
                'linter failed: %s',
                $e->getMessage(),
            ));

            throw $e;
        }
    }
}
