<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Elasticsearch\Common\Exceptions\NoDocumentsToGetException;

/**
 * CreatePost Resolver
 */
final class EditPost
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
            throw new NoDocumentsToGetException('invalid');
        }

        $client = $this->getElasticSearchClient();
        $status =  $client->update(
            ([
                'id' => $post[0]['_id'],
                'index' => config('elasticquent.default_index'),
                'type' => (new Post)->getTypeName(),
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

        if (array_key_exists('body', $this->args)) {
            $parsed['doc']['body']  = $this->args['body'];
        }

        if (array_key_exists('title', $this->args)) {
            $parsed['doc']['title']  = $this->args['title'];
        }

        if (array_key_exists('userId', $this->args)) {
            $parsed['doc']['userId']  = $this->args['userId'];
        }

        return $parsed;
    }
}
