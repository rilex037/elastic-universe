<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


/**
 * POST
 */
Route::get('/post', function () {

    /**
     * POST
     */

    // Post::createIndex(1, 1);
    // Post::putMapping(1);


    // elasticsearch v2.0 using builder

    \Elasticsearch\ClientBuilder::fromConfig([]);




    die();
    $post = new \App\Models\Post(
        [
            'body' => 'test body sample',
            'title' => 'test title',
            'userId' => 1
        ]
    );

    $post->index();

    // $postsResponse1 = Post::search('body');
    $postsResponse2 =  \App\Models\Post::complexSearch([
        'body' => [
            'size' => 3,
            'query' => [
                'match' => [
                    'body' => 'test' . Str::random(32)
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

/**
 * POST
 */
Route::get('/todo', function () {

    /**
     * POST
     */

    \App\Models\Todo::createIndex(1, 1);

    // Todo::putMapping(1);

    $todo = new Todo(
        [
            'dueOn' => '2022-12-01',
            'title' => 'test title ' . Str::random(32),
            'userId' => 1
        ]
    );

    $todo->index();

    /*
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
    */
    // http://localhost:9200/default/posts/_search

    /*
    return response('', 204);*
    */
});
