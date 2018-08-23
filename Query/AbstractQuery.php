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

class AbstractQuery
{
    protected $typesInitial;
    protected $repository;


    public function query($rootValue, $args)
    {
        if(isset($args['id']))
            return $this->repository->find($args['id']);
        $args += ['after' => null];
        return $this->repository->findBy([],[],$args['limit'],$args['after']);
    }

}
