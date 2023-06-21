<?php

declare(strict_types=1);

use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Nuwave\Lighthouse\Testing\RefreshesSchemaCache;
use Oneduo\LighthouseUtils\Tests\TestCase;

uses(
    TestCase::class,
    //    RefreshesSchemaCache::class,
    MakesGraphQLRequests::class,
)->in(__DIR__);
