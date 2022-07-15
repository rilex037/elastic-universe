<?php

namespace App\Models\Abstract;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

abstract class ElasticqModel extends Model
{
    use ElasticquentTrait;

    public function index()
    {
        $params = $this->getBasicEsParams();
        $params['body'] = $this->getIndexDocumentData();
        $params['id'] = $this->getKey();
        return $this->getElasticSearchClient()->index($params);
    }
}
