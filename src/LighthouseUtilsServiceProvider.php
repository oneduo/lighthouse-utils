<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils;

use Illuminate\Support\Arr;
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

        config()->set(
            'lighthouse.namespaces.directives',
            [
                ...Arr::wrap(config('lighthouse.namespaces.directives')),
                'Oneduo\\LighthouseUtils\\Directives',
            ],
        );
    }
}
