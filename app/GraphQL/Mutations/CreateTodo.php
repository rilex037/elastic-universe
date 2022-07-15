<?php

namespace App\GraphQL\Mutations;

use App\Models\Todo;

/**
 * CreateTodo Resolver
 */
final class CreateTodo
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $todo = new Todo([
            'dueOn' => $args['dueOn'],
            'userId' => $args['userId'],
            'title' => $args['title'],
            'status' => $args['status']
        ]);

        $doc = $todo->index();
        $id = ['id' => $doc['_id']];

        return  $id + $todo->toArray();
    }
}
