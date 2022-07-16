<?php

namespace App\Models;

use App\Models\Abstract\ElasticqModel;

class Todo extends ElasticqModel
{
    protected $fillable = ['dueOn', 'userId', 'title', 'status'];

    protected $mappingProperties = [
        'dueOn' => [
            'type' => 'date',
        ],
        'userId' => [
            'type' => 'integer',
        ],
        'title' => [
            'type' => 'string',
        ],
        'status' => [
            'type' => 'string',
        ]
    ];

    public function getTypeName()
    {
        return 'todos';
    }
}
