<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Support;

use Illuminate\Support\Collection;
use ReflectionEnum;
use ReflectionException;
use Symfony\Component\Finder\Finder;

class ClassFinder
{
    public static function enumsIn(array|string $path, ?string $namespace, ?string $basePath): Collection
    {
        $namespace ??= app()->getNamespace();
        $basePath ??= app_path();

        $enums = collect();

        $files = (new Finder())->in($path)->files();

        foreach ($files as $class) {
            $class = str($class)
                ->after($basePath)
                ->before('.php')
                ->prepend($namespace)
                ->replace('/', '\\')
                ->replace('\\\\', '\\')
                ->toString();

            try {
                $reflection = new ReflectionEnum($class);

                if ($reflection->isEnum()) {
                    $enums->push($reflection);
                }
            } catch (ReflectionException) {
            }
        }

        return $enums;
    }
}
