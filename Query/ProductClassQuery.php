<?php
/*
 * This file is part of the Custom Csv Export Plugin
 *
 * Copyright (C) 2017 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GraphQLAPI\Query;

use Eccube\Repository\ProductClassRepository;
use GraphQL\Type\Definition\Type;
use Plugin\GraphQLAPI\Type\TypesInitial;

class ProductClassQuery extends AbstractQuery
{
    public function __construct( ProductClassRepository $repository)
    {
        $this->repository = $repository;
    }

    public function config()
    {
        return [
            'productClass' => [
                    'type' => TypesInitial::getProductClassType(),
                    'description' => 'dummy productClass',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
            'productClassS' => [
                'type' => Type::listOf(TypesInitial::getProductClassType()),
                'description' => 'dummy productClass',
                'args' => [
                    'after' => [
                        'type' => Type::id(),
                        'description' => 'Fetch products listed after the story with this ID'
                    ],
                    'limit' => [
                        'type' => Type::int(),
                        'description' => 'Number of products to be returned',
                        'defaultValue' => 2
                    ]
                ]
            ],
        ];
    }
}
