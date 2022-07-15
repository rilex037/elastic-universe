<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;

/**
 * CreatePost Resolver
 */
final class CreatePost
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $post = new Post([
            'body' =>  $args['body'],
            'title' =>  $args['title'],
            'userId' =>  $args['userId']
        ]);

        $doc = $post->index();
        $id = ['id' => $doc['_id']];

        return  $id + $post->toArray();
    }
}
