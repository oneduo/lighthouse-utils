<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Oneduo\LighthouseUtils\LighthouseUtils
 */
class LighthouseUtils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Oneduo\LighthouseUtils\LighthouseUtils::class;
    }
}
