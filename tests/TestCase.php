<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Tests;

use Laravel\Pennant\Feature;
use Laravel\Pennant\PennantServiceProvider;
use Nuwave\Lighthouse\Auth\AuthServiceProvider;
use Nuwave\Lighthouse\Cache\CacheServiceProvider;
use Nuwave\Lighthouse\GlobalId\GlobalIdServiceProvider;
use Nuwave\Lighthouse\LighthouseServiceProvider;
use Nuwave\Lighthouse\OrderBy\OrderByServiceProvider;
use Nuwave\Lighthouse\Pagination\PaginationServiceProvider;
use Nuwave\Lighthouse\SoftDeletes\SoftDeletesServiceProvider;
use Nuwave\Lighthouse\Testing\TestingServiceProvider;
use Nuwave\Lighthouse\Validation\ValidationServiceProvider;
use Oneduo\LighthouseUtils\LighthouseUtilsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LighthouseUtilsServiceProvider::class,
            LighthouseServiceProvider::class,
            PennantServiceProvider::class,
            AuthServiceProvider::class,
            CacheServiceProvider::class,
            GlobalIdServiceProvider::class,
            OrderByServiceProvider::class,
            PaginationServiceProvider::class,
            SoftDeletesServiceProvider::class,
            TestingServiceProvider::class,
            ValidationServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('pennant.default', 'array');

        config()->set('lighthouse.schema_path', __DIR__.'/Support/schema.graphql');
        config()->set('lighthouse-utils.enums.paths', [
            [__DIR__.'/Enums', 'Oneduo\\LighthouseUtils\\Tests', __DIR__],
        ]);

        Feature::define('active-feature', true);
        Feature::define('inactive-feature', false);
    }
}
