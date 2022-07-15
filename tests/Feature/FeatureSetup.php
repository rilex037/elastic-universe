<?php

namespace Tests\Feature;

use App\Console\Commands\CreateMappings;
use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Illuminate\Support\Facades\Http;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

abstract class FeatureSetup extends TestCase
{
    use ElasticquentTrait;
    use ElasticquentClientTrait;

    use MakesGraphQLRequests;

    protected static $initialized = FALSE;

    protected function setUp(): void
    {
        parent::setup();

        if (!self::$initialized) {
            // Delete index in case it exists
            Http::delete(env('ELASTICSEARCH_URL') . '/default')->body();

            // Creating it first time
            $this->assertNull((new CreateMappings())->handle());

            // Run it again to show error msg
            (new CreateMappings())->handle();

            self::$initialized = TRUE;
        }
    }
}
