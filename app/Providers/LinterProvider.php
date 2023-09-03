<?php

namespace App\Providers;

use App\Service\Event\PsrLaravelDispatcherAdapter;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\DefaultEvaluators;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\CallbackPropertyExtractor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\ChainFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\EvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\EvaluatorFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject\SubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\RulesMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\ArgumentResolverFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MemoryMetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\ParameterMapBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConverterInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class LinterProvider extends ServiceProvider
{
    public array $bindings = [
        EvaluatingSubjectFactory::class => SubjectFactory::class,
        PropertyExtractor::class => CallbackPropertyExtractor::class,
        OperatorResolver::class => \ArtARTs36\MergeRequestLinter\Infrastructure\Condition\OperatorResolver::class,
        MetricManager::class => MemoryMetricManager::class,
        EventDispatcherInterface::class => PsrLaravelDispatcherAdapter::class,
        MarkdownCleaner::class => LeagueMarkdownCleaner::class,
        ConverterInterface::class => CommonMarkConverter::class,
    ];

    public function register()
    {
        $this
            ->app
            ->when(ChainFactory::class)
            ->needs(Map::class)
            ->give(static fn () => DefaultEvaluators::map());

        $this
            ->app
            ->when(EvaluatorFactory::class)
            ->needs(EvaluatorCreator::class)
            ->give(static function (Application $app) {
                return $app->make(ChainFactory::class)->create();
            });

        $this->app->bind(RuleFactory::class, static function (Application $app) {
            return new RuleFactory(
                new ParameterMapBuilder(
                    (new ArgumentResolverFactory($app))->create(),
                ),
                new Finder(),
            );
        });

        $this->app->bind(Resolver::class, static function (Application $app) {
            return new Resolver(
                DefaultRules::map(),
                $app->make(RuleFactory::class),
                $app->make(ConditionRuleFactory::class),
            );
        });

        $this->app->bind(ConditionRuleFactory::class, static function (Application $app) {
            return ConditionRuleFactory::new(
                $app->make(OperatorResolver::class),
                $app->make(MetricManager::class),
            );
        });
    }
}
