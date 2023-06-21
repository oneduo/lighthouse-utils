<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils;

use GraphQL\Type\Definition\EnumType;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nuwave\Lighthouse\Schema\TypeRegistry;
use Oneduo\LighthouseUtils\Support\ClassFinder;

class EnumRegistrar
{
    public function __construct(public readonly array $paths)
    {
    }

    public function register(): void
    {
        $registry = app(TypeRegistry::class);

        $this->enums()->each(function (\ReflectionClass $enum) use ($registry) {
            $registry->register(
                new EnumType([
                    'name' => $enum->getShortName(),
                    'values' => collect($enum->getConstants())
                        ->mapWithKeys(function (\UnitEnum $enum) {
                            return [
                                $enum->name => [
                                    'value' => $enum,
                                ],
                            ];
                        })
                        ->toArray(),
                ])
            );
        });
    }

    public function enums(): Collection
    {
        return collect($this->paths)
            ->map(fn (array|string $path) => ClassFinder::enumsIn(...Arr::wrap($path)))
            ->collapse();
    }
}
