<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use App\Models\Todo;
use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Elasticsearch\Common\Exceptions\NoDocumentsToGetException;

/**
 * DeleteTodo Resolver
 */
final class DeleteTodo
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
        $status =  $client->delete(
            ([
                'id' => $todo[0]['_id'],
                'index' => config('elasticquent.default_index'),
                'type' => (new Todo)->getTypeName(),

            ])
        );

        return $status['result'] == 'deleted' ?
            sprintf('Document with ID: %s has been deleted.', $status['_id']) :
            sprintf('Document with ID: %s has not being deleted.', $status['_id']);
    }
}
