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

use Eccube\Repository\ClassCategoryRepository;
use GraphQL\Type\Definition\Type;
use Plugin\GraphQLAPI\Type\TypesInitial;

class ClassCategoryQuery extends AbstractQuery
{
    public function __construct( ClassCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function config()
    {
        return ['classCategory' => [
                    'type' => TypesInitial::getClassCategoryType(),
                    'description' => 'dummy class category',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
            ];
    }
}
