<?php

namespace Tests\Feature\Console;

use App\Console\Commands\CreateMappings;
use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Illuminate\Support\Facades\Http;
use Tests\Feature\FeatureSetup;


class CreateMappingsTest extends FeatureSetup
{
    public function testHandle()
    {
        $this->assertTrue(true);
    }
}
