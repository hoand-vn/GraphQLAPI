<?php
/*
 * This file is part of the Custom Csv Export Plugin
 *
 * Copyright (C) 2017 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GraphQLAPI\Mutation;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class MutationInitial extends ObjectType
{
    protected $productMutation;
    protected $productClassMutation;
    protected $typesInitial;

    public function __construct(ProductMutation $productMutation, ProductClassMutation $productClassMutation )
    {

        $this->productMutation = $productMutation;
        $fields = array_merge($this->productMutation->config());

        $this->productClassMutation = $productClassMutation;
        $fields = array_merge($this->productClassMutation->config(), $fields);

        $config = [
            'name' => 'Mutation',
            'fields' => $fields
        ];
        parent::__construct($config);
    }

}