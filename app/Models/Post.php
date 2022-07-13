<?php

namespace App\Models;

use App\Models\Abstract\ElasticqModel;
use Elasticquent\ElasticquentTrait;

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

    use ElasticquentTrait;


    function getTypeName()
    {
        return 'posts';
    }
}
