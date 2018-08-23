<?php
/*
 * This file is part of the Custom Csv Export Plugin
 *
 * Copyright (C) 2017 LOCKON CO.,LTD. All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GraphQLAPI\Controller;

use Eccube\Controller\AbstractController;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use \GraphQL\Error\FormattedError;
use \GraphQL\Error\Debug;

use Plugin\GraphQLAPI\Mutation\MutationInitial;
use Plugin\GraphQLAPI\Query\QueryInitial;
use Plugin\GraphQLAPI\Services\AppContext;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends AbstractController
{

    protected $queryInitial;
    // TODO: filter, complexity

    /**
     * @Route("/plugin/api", name="plugin_graphql_api_query" )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, QueryInitial $queryInitial, MutationInitial $mutationInitial)
    {
        $this->queryInitial = $queryInitial;
        $debug = true;
//        if (!empty($_GET['debug'])) {
//            set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
//                throw new \ErrorException($message, 0, $severity, $file, $line);
//            });
//            $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
//        }

        $schema = new Schema([
            'query' => $this->queryInitial,
            'mutation' => $mutationInitial
        ]);

        // query
        $rawInput = $request->getContent();
        $input = json_decode($rawInput, true);
        $query = $input['query'];

        //Root value
        $rootValue = ['prefix' => 'You said: '];

        // Prepare context that will be available in all field resolvers (as 3rd argument):
        $appContext = new AppContext();
        $appContext->viewer = null;//verify connector information
        $appContext->rootUrl = null;//url of connector 'http://eccube.sf:8080';

        // variable array
        $variableValues = isset($input['variables']) ? $input['variables'] : null;
        $variableArray = (array)$variableValues;

        try {
            $result = GraphQL::executeQuery(
                $schema,
                $query,
                $rootValue,
                $appContext,
                $variableArray
            );
            $output = $result->toArray();
        } catch (\Exception $error) {
            $output['errors'] = [
                FormattedError::createFromException($error, $debug)
            ];
        }
        return $this->json($output);

    }

}
