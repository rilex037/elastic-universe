<?php

namespace App\GraphQL\Mutations;

use App\Models\Todo;
use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Elasticsearch\Common\Exceptions\NoDocumentsToGetException;

/**
 * EditTodo Resolver
 */
final class EditTodo
{
    use ElasticquentTrait;
    use ElasticquentClientTrait;

    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $this->args = $args;

        $todo = Todo::searchByQuery(
            [
                'terms' => [
                    '_id' => [$this->args['id']]
                ]
            ]
        )->getHits()['hits'];

        if (!$todo) {
            throw new NoDocumentsToGetException('Invalid document ID!');
        }

        $client = $this->getElasticSearchClient();
        $status =  $client->update(
            ([
                'id' => $todo[0]['_id'],
                'index' => config('elasticquent.default_index'),
                'type' => (new Todo())->getTypeName(),
                'body' => $this->parseArgs()
            ])
        );

        return $status['result'] == 'updated' ?
            sprintf('Document with ID: %s has been updated.', $status['_id']) :
            sprintf('Document with ID: %s has not being updated.', $status['_id']);
    }

    private function parseArgs(): array
    {
        $parsed = [];

        if (array_key_exists('dueOn', $this->args)) {
            $parsed['doc']['dueOn']  = $this->args['dueOn'];
        }

        if (array_key_exists('userId', $this->args)) {
            $parsed['doc']['userId']  = $this->args['userId'];
        }

        if (array_key_exists('title', $this->args)) {
            $parsed['doc']['title']  = $this->args['title'];
        }

        if (array_key_exists('status', $this->args)) {
            $parsed['doc']['status']  = $this->args['status'];
        }

        return $parsed;
    }
}
