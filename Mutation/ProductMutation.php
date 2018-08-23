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

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Repository\ProductRepository;
use GraphQL\Type\Definition\Type;
use Plugin\GraphQLAPI\Type\TypesInitial;



class ProductMutation
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    protected $typesInitial;

    protected $repository;
    public function __construct( EntityManagerInterface $entityManager, ProductRepository $repository )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function config()
    {
        $that = $this;
        return ['product' => [
                    'type' => TypesInitial::getProductType(),
                    'description' => 'dummy product mutation',
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'name' => Type::nonNull(Type::string())
                    ],
                    'resolve' => function($root, $args, $context, $info) use ($that){
                        return $that->resolve($root, $args, $context, $info);
                    }
                ],
            ];
    }
    
    public function resolve($root, $args, $context, $info)
    {
        $Product = $this->repository->find($args['id']);
        if(!$Product){
            $Product = new Product();
        }
        $Product->setName($args['name']);
        $this->entityManager->persist($Product);
        $this->entityManager->flush();
    }
}
