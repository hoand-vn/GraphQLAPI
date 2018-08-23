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

use Eccube\Repository\ProductRepository;
use GraphQL\Type\Definition\Type;
use Plugin\GraphQLAPI\Type\TypesInitial;

class ProductQuery extends AbstractQuery
{

    public function __construct( ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function config()
    {
        return [
                'product' => [
                    'type' => TypesInitial::getProductType(),
                    'description' => 'dummy product',
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'name' => Type::string()
                    ]
                ],
                'productS' => [
                    'type' => Type::listOf(TypesInitial::getProductType()),
                    'description' => 'dummy product',
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
