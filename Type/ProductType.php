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

class ProductType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Product',
            'description' => 'Product of EC-CUBE',
            'fields' => function() {
                return [
                    'id' => Type::id(),
                    'name' => Type::string(),
                    'descriptionDetail' => Type::string(),
                    'Categories' => [
                        'type' => Type::listOf(TypesInitial::getCategoryType()),
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
                    'ProductClasses' => [
                        'type' => Type::listOf(TypesInitial::getProductClassType()),
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

    public function getCategories($value, $args, $context, $info)
    {
        $result = null;
        foreach( $value->getProductCategories() as $productCategory )
        {
            if(!isset($args['id'])){
                $result[] = $productCategory->getCategory();
            }else if($args['id']==$productCategory->getCategoryId()){
                $result[] = $productCategory->getCategory();
            }
        }
        return $result;
    }
    public function getProductClasses($value, $args, $context, $info)
    {
        if(!isset($args['id']))
            return $value->getProductClasses();

        $result = null;
        foreach( $value->getProductClasses() as $productClass )
        {
               if($args['id']==$productClass->getId()){
                $result[] = $productClass;
            }
        }
        return $result;
    }
}