<?php

namespace App\GraphQL\Type;

use GraphQL\Language\AST\Node;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use GraphQL\Type\Definition\ScalarType;
use Overblog\GraphQLBundle\Annotation as GQL;

/**
 * Class DatetimeType
 *
 * @GQL\Scalar(name="DateTime")
 */
class DateTimeType extends ScalarType implements AliasedInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return ['DateTime', 'Date'];
    }

    /**
     * @param \DateTime $value
     *
     * @return string
     */
    public function serialize($value)
    {
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parseValue($value)
    {
        return new \DateTime($value);
    }

    /**
     * @param Node $valueNode
     *
     * @return string
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        return new \DateTime($valueNode->value);
    }
}
