<?php
/*
 * This file is part of the Custom Csv Export Plugin
 *
 * Copyright (C) 2017 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GraphQLAPI\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Category',
            'description' => 'Category of EC-CUBE',
            'fields' => function() {
                return [
                    'id' => Type::id(),
                    'name' => Type::string(),
                    'Products' => [
                        'type' => Type::listOf(TypesInitial::getProductType()),
                        'args' => [
                            'id' => [
                                'type' => Type::id(),
                            ],
                            'after' => [
                                'type' => Type::id(),
                                'defaultValue' => 0,
                                'description' => 'Load all comments listed after given comment ID'
                            ],
                            'limit' => [
                                'type' => Type::int(),
                                'defaultValue' => 5
                            ]
                        ]
                    ],
                    'fieldWithError' => [
                        'type' => Type::string(),
                        'resolve' => function() {
                            throw new \Exception("This is error field");
                        }
                    ]
                ];
            },
            'resolveField' => function($value, $args, $context, ResolveInfo $info) {
                $method = 'get' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($value, $args, $context, $info);
                } else {
                    return $value->{$method}();
                }
            }
        ];
        parent::__construct($config);
    }
    public function getProducts($value, $args, $context, $info)
    {
        $result = null;
        foreach( $value->getProductCategories() as $productCategory )
        {
            if(!isset($args['id'])){
                $result[] = $productCategory->getProduct();
            }else if($args['id']==$productCategory->getProductId()){
                $result[] = $productCategory->getProduct();
            }
        }
        return $result;
    }
}