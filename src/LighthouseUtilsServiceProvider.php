<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LighthouseUtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lighthouse-utils')
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        $enumRegistrar = app(EnumRegistrar::class, [
            'paths' => config('lighthouse-utils.enums.paths', []),
        ]);

        $enumRegistrar->register();
    }
}
