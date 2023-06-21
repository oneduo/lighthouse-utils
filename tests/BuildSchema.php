<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Tests;

use GraphQL\Type\Schema;
use Nuwave\Lighthouse\Schema\SchemaBuilder;
use Nuwave\Lighthouse\Testing\UsesTestSchema;

trait BuildSchema
{
    use UsesTestSchema;

    /**
     * Build an executable schema from an SDL string.
     */
    protected function buildSchema(string $schema): Schema
    {
        $this->schema = $schema;

        return app(SchemaBuilder::class)->schema();
    }
}
