<?php

namespace App\Service\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\LinterFactory;
use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\MemoryRequestFetcher;
use Psr\Log\LoggerInterface;

class Linter
{
    public function __construct(
        private LinterFactory $factory,
        private MergeRequestFactory $requestFactory,
        private LoggerInterface $logger,
        private ArrayConfigHydrator $arrayConfigHydrator,
    ) {
        //
    }

    public function run(array $configData, array $mergeRequest): LintResult
    {
        $config = $this->arrayConfigHydrator->hydrate($configData, Config::SUBJECT_RULES | Config::SUBJECT_LINTER);

        $linter = $this->factory->create($config);

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
