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

use Eccube\Entity\ProductClass;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class ProductClassType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ProductClass',
            'description' => 'Product of EC-CUBE',
            'fields' => function() {
                return [
                    'id' => Type::id(),
                    'code' => Type::string(),
                    'Product' => TypesInitial::getProductType(),
                    'ClassCategory1' => TypesInitial::getClassCategoryType(),
                    'ClassCategory2' => TypesInitial::getClassCategoryType(),
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
                if (method_exists($this, $method)) { echo $method;
                    return $this->{$method}($value, $args, $context, $info);
                } else {
                    return $value->{$method}();
                }
            }
        ];
        parent::__construct($config);
    }
//    public function getClassCategory1(ProductClass $product, $args)
//    {
//        return $product->getClassCategory1();//DataSource::getUserPhoto($user->id, $args['size']);
//    }
}