<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Tests;

use Nuwave\Lighthouse\LighthouseServiceProvider;
use Oneduo\LighthouseUtils\LighthouseUtilsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LighthouseUtilsServiceProvider::class,
            LighthouseServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('lighthouse.schema_path', __DIR__.'/Support/schema.graphql');
        config()->set('lighthouse-utils.enums.paths', [
            [__DIR__.'/Enums', 'Oneduo\\LighthouseUtils\\Tests', __DIR__],
        ]);
    }
}
