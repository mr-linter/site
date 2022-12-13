<?php

namespace App\Providers;

use ArtARTs36\MergeRequestLinter\Configuration\Loader\RulesMapper;
use ArtARTs36\MergeRequestLinter\Rule\Condition\DefaultOperators;
use ArtARTs36\MergeRequestLinter\Rule\Condition\OperatorFactory;
use ArtARTs36\MergeRequestLinter\Rule\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\Builder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Argument\DefaultResolvers;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Factory\RuleFactory;
use ArtARTs36\MergeRequestLinter\Support\PropertyExtractor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LinterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RuleFactory::class, static function () {
            return new RuleFactory(
                new Builder(
                    DefaultResolvers::get(),
                ),
                new ConstructorFinder(),
            );
        });

        $this->app->bind(OperatorResolver::class, static function () {
            return new OperatorResolver(new OperatorFactory(DefaultOperators::map(), new PropertyExtractor()));
        });

        $this->app->bind(RulesMapper::class, static function (Application $app) {
            return new RulesMapper(
                new Resolver(
                    DefaultRules::map(),
                    $app->make(RuleFactory::class),
                    $app->make(OperatorResolver::class),
                ),
            );
        });
    }
}
