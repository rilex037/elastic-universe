<?php

namespace App\Models;

use App\Models\Abstract\ElasticqModel;
use Elasticquent\ElasticquentTrait;

class Todo extends ElasticqModel
{
    protected $fillable = ['dueOn', 'userId', 'title'];

    protected $mappingProperties = [
        'dueOn' => [
            'type' => 'date',
        ],
        'userId' => [
            'type' => 'integer',
        ],
        'title' => [
            'type' => 'string',
        ]
    ];

    function getTypeName()
    {
        return 'todos';
    }
}
