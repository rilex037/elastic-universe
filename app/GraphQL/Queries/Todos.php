<?php

namespace App\GraphQL\Queries;

use App\Models\Todo;
use Carbon\Carbon;

/**
 * Todos Resolver
 */
final class Todos
{
    private array $args;

    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $this->args = $args;

        $todos = $this->query()->getHits();

        $res = [];
        $res['perPage'] = $args['perPage'];
        $res['page'] = $args['page'];

        $res['records'] = $todos['total'];
        $res['totalPages'] = (int) ceil($todos['total'] / $args['perPage']);

        foreach ($todos['hits'] as $value) {
            $value['_source']['dueOn']  =  Carbon::parse($value['_source']['dueOn']);
            $res['data'][] = (['id' => $value['_id']] + $value['_source']);
        }

        return ($res);
    }

    private function query()
    {
        return \App\Models\Todo::complexSearch([
            'body' => [
                "from" => ($this->args['page'] - 1) * $this->args['perPage'],
                'size' => $this->args['perPage'],
                'query' => [
                    "bool" => [
                        'filter' => ["type" => ["value" => (new Todo())->getTypeName()]],
                        "must" => $this->parseArgs($this->args),
                    ]
                ]
            ]
        ]);
    }

    private function parseArgs(): array
    {
        $parsed = [];

        if (array_key_exists('dueOn', $this->args)) {
            $dTime = Carbon::parse($this->args['dueOn']);
            $parsed[] = [
                'match' => ['dueOn' => $dTime->toTimeString() == '00:00:00' ? $this->args['dueOn'] : $dTime]
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

        if (array_key_exists('status', $this->args)) {
            $parsed[]  = [
                'query_string' => [
                    'query' => $this->args['status'],
                    "minimum_should_match" => "100%",
                    "default_field" => "status",
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
