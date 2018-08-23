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

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class QueryInitial extends ObjectType
{
    protected $productClassQuery;
    protected $productQuery;
    protected $categoryQuery;
    protected $classCategoryQuery;
    protected $typesInitial;

    public function __construct(ProductClassQuery $productClassQuery, ProductQuery $productQuery, CategoryQuery $categoryQuery, ClassCategoryQuery $classCategoryQuery)
    {
        $this->productClassQuery = $productClassQuery;
        $fields = array_merge($this->productClassQuery->config());

        $this->productQuery = $productQuery;
        $fields = array_merge($this->productQuery->config(),$fields);

        $this->categoryQuery = $categoryQuery;
        $fields = array_merge($this->categoryQuery->config(),$fields);

        $this->classCategoryQuery = $classCategoryQuery;
        $fields = array_merge($this->classCategoryQuery->config(),$fields);

        $config = [
            'name' => 'Query',
            'fields' => $fields,
            'resolveField' => function($val, $args, $context, ResolveInfo $info) {
                if(substr($info->fieldName, -1)=== 'S')
                    $info->fieldName = substr($info->fieldName, 0, -1);
                $itemQuery = $info->fieldName.'Query';
                return $this->{$itemQuery}->query($val, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

}