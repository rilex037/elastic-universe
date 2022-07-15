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
        // Delete index in case it exists
        Http::delete(env('ELASTICSEARCH_URL') . '/default')->body();

        // Creating it first time
        $this->assertNull((new CreateMappings())->handle());

        // Return false if it already exists
        $this->assertNull((new CreateMappings())->handle());
    }
}
