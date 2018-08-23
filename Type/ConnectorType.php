<?php
namespace Plugin\GraphQLAPI\Type;

use GraphQL\Utils\Utils;

class ConnectorType
{
    public $id;
    public $email;
    public $token;
    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}