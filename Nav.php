<?php

/*
 * This file is part of the Custom Csv Export Plugin
 *
 * Copyright (C) 2017 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Plugin\GraphQLAPI;


use Eccube\Common\EccubeNav;

class Nav implements EccubeNav
{
    public static function getNav()
    {
        return [
            'setting' => [
                'id' => 'admin_graphql_api_author',
                'name' => 'GraphQL API 権限',
                'url' => 'plugin_graphql_api_author',
            ],
        ];
    }
}
