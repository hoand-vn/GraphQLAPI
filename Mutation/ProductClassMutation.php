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
use Eccube\Entity\ProductClass;
use Eccube\Repository\ProductClassRepository;
use Eccube\Repository\ProductRepository;
use GraphQL\Type\Definition\Type;
use Plugin\GraphQLAPI\Type\TypesInitial;



class ProductClassMutation
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    protected $typesInitial;
    protected $repository;
    protected $productRepository;

    public function __construct( EntityManagerInterface $entityManager, ProductClassRepository $repository, ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

    public function config()
    {
        $that = $this;
        return ['productClass' => [
                    'type' => TypesInitial::getProductClassType(),
                    'description' => 'dummy productClass mutation',
                    'args' => [
                        'id' => Type::id(),
                        'code' => Type::string(),
                        'Product' => Type::int()
                    ],
                    'resolve' => function($root, $args, $context, $info) use ($that){
                        return $that->resolve($root, $args, $context, $info);
                    }
                ],
            ];
    }

    public function resolve($root, $args, $context, $info)
    {
        if(isset($args['id']))
            $ProductClass = $this->repository->find($args['id']);

        if(!isset($ProductClass)){
            $ProductClass = new ProductClass();
        }

        if(isset($args['code']))
            $ProductClass->setCode($args['code']);

        if(isset($args['Product'])){
            $Product = $this->productRepository->find($args['Product']);
            if(!$Product)
                throw new NotFoundHttpException();

            $ProductClass->setProduct($Product);
        }
        $this->entityManager->persist($ProductClass);
        $this->entityManager->flush();

        return $ProductClass;
    }
}
