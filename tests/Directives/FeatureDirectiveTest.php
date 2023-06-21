<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Laravel\Pennant\Feature;
use Nuwave\Lighthouse\Events\BuildSchemaString;

it('registers a field based on feature flag value', function () {
    Event::listen(
        events: BuildSchemaString::class,
        listener: function (): string {
            return /** @lang GraphQL */ <<<'GRAPHQL'
                    extend type Query {
                        getUser(email: String): User @find @feature(name: "active-feature", active: true)
                        getUser(phone: String): User @find @feature(name: "active-feature", active: false)
                    }
                GRAPHQL;
        },
    );

    $fields = data_get($this->introspectType('Query'), 'fields');

    $fields = collect($fields);

    $getUserQuery = $fields->filter(fn (array $field) => $field['name'] === 'getUser')->first();

    expect(data_get($getUserQuery, 'args.0.name'))->toBe('email');
});

it('de-registers a field based on feature flag value', function () {
    Feature::define('active-feature', false);

    Event::listen(
        events: BuildSchemaString::class,
        listener: function (): string {
            return /** @lang GraphQL */ <<<'GRAPHQL'
                    extend type Query {
                        getUser(email: String): User @find @feature(name: "active-feature", active: true)
                        getUser(phone: String): User @find @feature(name: "active-feature", active: false)
                    }
                GRAPHQL;
        },
    );

    $query = $this->introspectType('Query');

    $fields = data_get($query, 'fields');

    $fields = collect($fields);

    $getUserQuery = $fields->filter(fn (array $field) => $field['name'] === 'getUser')->first();

    expect(data_get($getUserQuery, 'args.0.name'))->toBe('phone');
});

it('registers a nested field based on feature flag value', function () {
    Event::listen(
        events: BuildSchemaString::class,
        listener: function (): string {
            return /** @lang GraphQL */ <<<'GRAPHQL'
                    type Post {
                        id: ID!
                        title: String @feature(name: "active-feature", active: true)
                    }
                GRAPHQL;
        },
    );

    $type = $this->introspectType('Post');

    $fields = data_get($type, 'fields');

    expect($fields)->toHaveCount(2);
});

it('de-registers a nested field based on feature flag value', function () {
    Event::listen(
        events: BuildSchemaString::class,
        listener: function (): string {
            return /** @lang GraphQL */ <<<'GRAPHQL'
                    type Post {
                        id: ID!
                        title: String @feature(name: "inactive-feature", active: true)
                    }
                GRAPHQL;
        },
    );

    $type = $this->introspectType('Post');

    $fields = data_get($type, 'fields');

    expect($fields)->toHaveCount(1);
});
