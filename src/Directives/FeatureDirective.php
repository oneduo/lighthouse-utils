<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils\Directives;

use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\InterfaceTypeDefinitionNode;
use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use InvalidArgumentException;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\FieldManipulator;
use Oneduo\LighthouseUtils\Facades\LighthouseUtils;

class FeatureDirective extends BaseDirective implements FieldManipulator
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
directive @feature(
"Name of the feature to be evaluated"
name: String!
"Whether the feature should be active or not. If the evaluated feature value does not match this check value, the field will be removed."
active: Boolean = true
) on FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * @throws \Exception
     */
    public function manipulateFieldDefinition(
        DocumentAST &$documentAST,
        FieldDefinitionNode &$fieldDefinition,
        ObjectTypeDefinitionNode|InterfaceTypeDefinitionNode &$parentType,
    ): void {
        $name = $this->directiveArgValue('name');

        if (!is_string($name)) {
            throw new InvalidArgumentException('Feature name must be a string');
        }

        $active = $this->directiveArgValue('active', true);

        $featureActive = LighthouseUtils::resolveFeatureValue($name);

        if ($active === $featureActive) {
            return;
        }

        $search = null;

        foreach ($parentType->fields->getIterator() as $index => $field) {
            if ($field === $fieldDefinition) {
                $search = $index;

                break;
            }
        }

        if ($search !== null) {
            unset($parentType->fields[$search]);
        }
    }
}
