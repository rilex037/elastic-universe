<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {


    // Post::createIndex(1, 1);
    // Post::putMapping(1);

    $post = new Post(
        [
            'body' => 'test body sample',
            'title' => 'test title',
            'userId' => 1
        ]
    );

    //$post->index();

    // $postsResponse1 = Post::search('body');
    $postsResponse2 = Post::complexSearch([
        'body' => [
            'size' => 3,
            'query' => [
                'match' => [
                    'body' => 'test'
                ]
            ]
        ]
    ]);

    // return response()->json($postsResponse);
    return response()->json($postsResponse2);

    // http://localhost:9200/default/posts/_search

    /*
    return response('', 204);*
    */
});
