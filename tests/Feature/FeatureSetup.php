<?php

namespace Tests\Feature;

use Elasticquent\ElasticquentClientTrait;
use Elasticquent\ElasticquentTrait;
use Tests\TestCase;

abstract class FeatureSetup extends TestCase
{
    use ElasticquentTrait;
    use ElasticquentClientTrait;
}
