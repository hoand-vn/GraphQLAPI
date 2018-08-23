<?php
namespace Plugin\GraphQLAPI\Services;

use GraphQL\Examples\Blog\Data\User;
use Plugin\GraphQLAPI\Type\ConnectorType;

/**
 * Class AppContext
 * Instance available in all GraphQL resolvers as 3rd argument
 *
 * @package Plugin\GraphQLAPI
 */
class AppContext
{
    /**
     * @var string
     */
    public $rootUrl;
    /**
     * @var ConnectorType
     */
    public $viewer;

}