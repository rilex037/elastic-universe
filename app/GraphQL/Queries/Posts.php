<?php

namespace App\GraphQL\Queries;

/**
 * Posts Resolver
 */
final class Posts
{
    private array $args;

    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $this->args = $args;

        $posts = $this->query()->getHits();

        //  dd($posts['total']);

        $res = [];
        $res['perPage'] = $args['perPage'];
        $res['page'] = $args['page'];

        $res['records'] = $posts['total'];
        $res['totalPages'] = (int) ceil($posts['total'] / $args['perPage']);
        //  dd($res);

        foreach ($posts['hits'] as $value) {
            $res['data'][] =   (['id' => $value['_id']] + $value['_source']);
        }

        return $res;
    }

    private function query()
    {
        return \App\Models\Post::complexSearch([
            'body' => [
                "from" => ($this->args['page'] - 1) * $this->args['perPage'],
                'size' => $this->args['perPage'],
                'query' => [
                    "bool" => [
                        "must" => $this->parseArgs($this->args)
                    ]
                ]
            ]
        ]);
    }

    private function parseArgs(): array
    {
        $parsed = [];

        if (array_key_exists('body', $this->args)) {
            $parsed[]  = [
                'query_string' => [
                    'query' => $this->args['body'],
                    "minimum_should_match" => "100%",
                    "default_field" => "body"

                ]
            ];
        }

        if (array_key_exists('title', $this->args)) {
            $parsed[]  = [
                'query_string' => [
                    'query' => $this->args['title'],
                    "minimum_should_match" => "100%",
                    "default_field" => "title",
                ]
            ];
        }

        if (array_key_exists('userId', $this->args)) {
            $parsed[]  = [
                'term' =>  ['userId' => $this->args['userId']],
            ];
        }

        return $parsed;
    }
}
