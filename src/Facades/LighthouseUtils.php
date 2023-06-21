<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Oneduo\LighthouseUtils\LighthouseUtils
 *
 * @method static bool resolveFeatureValue(string $name)
 */
class LighthouseUtils extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Oneduo\LighthouseUtils\LighthouseUtils::class;
    }
}
