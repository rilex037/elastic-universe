<?php

namespace Tests\Feature\Endpoints;

use Tests\Feature\FeatureSetup;

class HomepageTest extends FeatureSetup
{
    public function testHomepageGet()
    {
        $response = $this->get('/');

        $response->assertStatus(204);
    }
}
