<?php

namespace App\Resolver;

use App\Service\MutationService;
use App\Service\QueryService;
use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class CustomResolverMap extends ResolverMap
{
    private MutationService $mutationService;
    private QueryService $queryService;

    public function __construct(MutationService $mutationService, QueryService $queryService) {
        $this->mutationService = $mutationService;
        $this->queryService = $queryService;
    }

    /**
     * @inheritDoc
     */
    protected function map(): array
    {
        return [
            'RootQuery' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    switch ($info->fieldName) {
                        case 'getstat':
                            return $this->queryService->getStat($args['start_date'] ?? null, $args['end_date'] ?? null, $args['type'] ?? null);
                        default:
                            return null;
                    }
                },
            ],
            'RootMutation' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    switch ($info->fieldName) {
                        case 'updateTag':
                            return $this->mutationService->updateTag($args['tag']);
                        default:
                            return null;
                    }
                },
            ],
        ];
    }
}
