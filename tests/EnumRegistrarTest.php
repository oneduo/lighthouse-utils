<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Oneduo\LighthouseUtils\Tests\Enums\SecretEnum;

it('can register a GraphQL enum', function () {
    $enum = $this->introspectType('SecretEnum');

    $names = collect(data_get($enum, 'enumValues'))
        ->map(fn (array $enum) => Arr::only($enum, ['name']));

    expect($enum)
        ->toMatchArray([
            'kind' => 'ENUM',
            'name' => 'SecretEnum',
        ])
        ->and($names->toArray())
        ->toMatchArray(array_map(function (SecretEnum $enum) {
            return [
                'name' => $enum->name,
            ];
        }, SecretEnum::cases()));
});
