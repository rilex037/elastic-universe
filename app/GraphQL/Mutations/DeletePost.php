<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Elasticsearch\Common\Exceptions\NoDocumentsToGetException;

/**
 * DeletePost Resolver
 */
final class DeletePost
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

        $post = Post::searchByQuery(
            [
                'terms' => [
                    '_id' => [$this->args['id']]
                ]
            ]
        )->getHits()['hits'];

        if (!$post) {
            throw new NoDocumentsToGetException('Invalid document ID!');
        }

        $client = $this->getElasticSearchClient();
        $status =  $client->delete(
            ([
                'id' => $post[0]['_id'],
                'index' => config('elasticquent.default_index'),
                'type' => (new Post)->getTypeName(),

            ])
        );

        return $status['result'] == 'deleted' ?
            sprintf('Document with ID: %s has been deleted.', $status['_id']) :
            sprintf('Document with ID: %s has not being deleted.', $status['_id']);
    }
}
