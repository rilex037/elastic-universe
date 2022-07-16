<?php

namespace App\Models;

use App\Models\Abstract\ElasticqModel;

class Post extends ElasticqModel
{
    protected $fillable = ['body', 'title', 'userId'];

    protected $mappingProperties = [

        'userId' => [
            'type' => 'integer',
        ],
        'title' => [
            'type' => 'string',
        ],
        'body' => [
            'type' => 'string',
        ]
    ];

    public function getTypeName()
    {
        return 'posts';
    }
}
